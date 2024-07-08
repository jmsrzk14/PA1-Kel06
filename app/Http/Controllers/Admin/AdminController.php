<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Penjualan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request){
        $JumlahProduk = Produk::count();
        $JumlahKategori = Kategori::count();
        $JumlahKasir = User::where('role', 'kasir')->count();
        $PenjualanPerHari = DB::table('penjualan')
        ->whereDate('penjualan.created_at', Carbon::today())
        ->join('produk', 'penjualan.produk_id', '=', 'produk.id')
        ->select(DB::raw('SUM(penjualan.jumlah * produk.harga) as Rp'))
        ->value('Rp');

        $tahun = $request->input('tahun', date('Y'));
        $penjualan = DB::table('penjualan')
            ->join('produk', 'penjualan.produk_id', '=', 'produk.id')
            ->whereYear('penjualan.created_at', $tahun)
            ->select(DB::raw('SUM(penjualan.jumlah * produk.harga) as total_penjualan'))
            ->first();

        // Calculate the sum of donations for each month
        $charts_donasi = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalPenjualan = DB::table('penjualan')
                ->join('produk', 'penjualan.produk_id', '=', 'produk.id')
                ->whereYear('penjualan.created_at', $tahun)
                ->whereMonth('penjualan.created_at', $month)
                ->select(DB::raw('SUM(penjualan.jumlah * produk.harga) as total_penjualan'))
                ->first();
        
            $charts_donasi[] = intval($totalPenjualan->total_penjualan);
        }
        
        // Check if there are any donations for the year
        $no_penjualan = array_sum($charts_donasi) == 0;

        return view('admin.dashboard', [
            'charts_donasi' => $charts_donasi,
            'tahun' => $tahun,
            'penjualan' => $no_penjualan ? 0 : $penjualan, // Set $donasi to 0 if there are no donations
            'no_penjualan' => $no_penjualan, // Pass $no_donations to the view
            'PenjualanPerHari' => $PenjualanPerHari,
            'JumlahProduk' => $JumlahProduk,
            'JumlahKategori' => $JumlahKategori,
            'JumlahKasir' => $JumlahKasir,
        ]);
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
            if(Auth::guard('admin')->attempt(['username' => $data['username'], 'password' => $data['password']])){
                return redirect('admin/dashboard')->with('status', 'Login Berhasil!');
            }
            else{
                return redirect()->back()->with('message', 'Invalid Login');
            }
        }
        return view ('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            $required = [
                'nama' => 'required|regex:/^[\pL\s\-]+$/u',
                'username' => 'required|max:20|unique:admins',
                'password' => 'required|min:8',
            ];

            $message = [
                'nama.required' => 'Nama tidak boleh kosong',
                'nama.regex' => 'Nama tidak boleh menggunakan simbol',
                'username.required' => 'Username tidak boleh kosong',
                'username.max' => 'Username tidak boleh melebihi 20 karakter',
                'username.unique' => 'Username sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password harus lebih dari 8 karakter',
            ];

            $this->validate($request, $required, $message);
            Admin::insert([
                'nama' => $request->input('nama'),
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
            ]);
            return redirect('admin/login')->with('success_message', 'Admin berhasil didaftarkan ');
        }
        return view('auth.register');
    }

    public function profile(){
        $admin = Auth::user();

        return view('admin.profile.profile');
    }

    public function UpdateAdminDetails(Request $request)
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
                'nama.regex' => 'Nama yang Benar Harus Di Isi',
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
                    $imagePath = 'admin/foto/' . $imageName;

                    $image->move('admin/foto', $imageName);
                }
            } else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = "";
            }

            User::where('id', Auth::user()->id)->update(['name' => $data['name'], 'tempatLahir' => $data['tempatLahir'], 'tanggalLahir' => $data['tanggalLahir'], 'jenisKelamin' => $data['jenisKelamin'], 'agama' => $data['agama'], 'alamat' => $data['alamat'], 'email' => $data['email'], 'noTelp' => $data['noTelp'], 'foto' => $imageName]);
            return redirect('/admin/profile')->with('success_message', 'Admin Details Berhasil di Update');
        }
        $admin = Auth::user();
        return view('admin.settings.update_admin_details');
    }

    public function UpdateAdminPassword(Request $request)
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
                    return redirect("admin/profile")->with('success_message', 'Password Kamu berhasil di Update');
                } else {
                    return redirect()->back()->with('error_message', 'New Password dan Confirm Password Kamu tidak sesuai');
                }
            } else {
                return redirect()->back()->with('error_message', 'Current Password Kamu Salah');
            }
        }
        $adminDetails = User::where('email', Auth::user()->email)->first()->toArray();
        $admin = Auth::user();

        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }
}
