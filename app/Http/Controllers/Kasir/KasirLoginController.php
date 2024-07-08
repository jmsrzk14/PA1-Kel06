<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Log;

class KasirLoginController extends Controller
{
    public function dashboard(){
        $JumlahProduk = Produk::count();
        $JumlahKategori = Kategori::count();

        $PenjualanPerHari = DB::table('penjualan')
            ->whereDate('created_at', Carbon::today())
            ->sum('jumlah');

            return view ('kasir.dashboard', compact('JumlahProduk', 'JumlahKategori', 'PenjualanPerHari'));
        }

    public function Login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            $required = [
                'username' => 'required',
                'password' => 'required|min:6',
            ];
            $message = [
                'username.required' => 'Username harus diisi',
                'password.required' => 'Password harus diisi',
                'password.min' => 'Password minimal 6 karakter',
            ];
            $this->validate($request, $required, $message);
            if(Auth::attempt(['username' => $data['username'], 'password' => $data['password']])){
                return redirect('kasir/dashboard')->with('success_message', 'Login Berhasil!');
            }
            else{
                return redirect()->back()->with('message', 'Invalid Login');
            }
        }
        return view ('kasir.login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/kasir/login');
    }

    public function profile(){
        $kasir = Auth::user();

        return view('kasir.profile.profile');
    }

    public function UpdateKasirDetails(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'tempatLahir' => 'required',
                'tanggalLahir' => 'required',
                'jenisKelamin' => 'required',
                'agama' => 'required',
                'alamat' => 'required',
                'email' => 'required|email|max:255',
                'noTelp' => 'required|numeric',
            ];

            $messages = [
                'name.required' => 'Nama Harus Di Isi',
                'noTelp.required' => 'No Telephone Harus Di Isi',
                'noTelp.numeric' => 'No Telephone yang Benar Harus Di Isi',
                'name.regex' => 'Nama yang Benar Harus Di Isi',
                'email.required' => 'Email Harus Di Isi',
                'email.email' => 'Email tidak valid',
                'tempatLahir.required' => 'Tempat Lahir Harus Di Isi',
                'tanggalLahir.required' => 'Tanggal Lahir Harus Di Isi',
                'jenisKelamin.required' => 'Jenis Kelamin Harus Di Isi',
            ];

            $this->validate($request, $rules, $messages);

            // Upload photo
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();

                    $imageName = rand() . '.' . $extension;
                    $imagePath = 'kasir/foto/' . $imageName;

                    $image->move('kasir/foto', $imageName);
                }
            } else if (!empty($data['current_kasir_image'])) {
                $imageName = $data['current_kasir_image'];
            } else {
                $imageName = "";
            }

            User::where('id', Auth::user()->id)->update(['name' => $data['name'], 'tempatLahir' => $data['tempatLahir'], 'tanggalLahir' => $data['tanggalLahir'], 'jenisKelamin' => $data['jenisKelamin'], 'agama' => $data['agama'], 'alamat' => $data['alamat'], 'email' => $data['email'], 'noTelp' => $data['noTelp'], 'foto' => $imageName]);
            return redirect('/kasir/profile')->with('status', 'Data Diri Berhasil di Update');
        }
        $kasir = Auth::user();
        return view('kasir.settings.update_kasir_details');
    }

    public function UpdateKasirPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required',
            ];
            $message = [
                'current_password.required' => 'Current Password Harus Di Isi',
                'new_password.required' => 'Password Baru Harus Di Isi',
                'new_password.min' => 'Password Baru minimal 8 karakter',
                'confirm_password.required' => 'Confirm Password Harus Di Isi',
            ];
            $this->validate($request, $rules, $message);

            if (Hash::check($data['current_password'], Auth::user()->password)) {
                if ($data['confirm_password'] == $data['new_password']) {
                    User::where('id', Auth::user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect("kasir/profile")->with('success_message', 'Password Kamu berhasil di Update');
                } else {
                    return redirect()->back()->with('error_message', 'New Password dan Confirm Password Kamu tidak sesuai');
                }
            } else {
                return redirect()->back()->with('error_message', 'Current Password Kamu Salah');
            }
        }
        $kasirDetails = User::where('email', Auth::user()->email)->first()->toArray();
        $kasir = Auth::user();

        return view('kasir.settings.update_kasir_password')->with(compact('kasirDetails'));
    }
}
