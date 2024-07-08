<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ReservationController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('User.reservation', compact('category'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            Alert::warning('Perhatian', 'Silahkan Login atau Register untuk membuat reservasi.');
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required',
            'tanggal' => 'required',
            'waktu' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'event' => 'required',
            'jumlah_anggota' => 'required',
        ]);

        // Jam Operasi Roiyall
        $waktu = strtotime($request->waktu);
        $startTime = strtotime('08:00'); // mulai dari jam 8 pagi
        $endTime = strtotime('22:00'); // sampai jam 10 malam

        if ($waktu < $startTime || $waktu > $endTime) {
            Alert::error('Mohon Maaf', 'Batas waktu operasional Roiyall Coffee dari jam 08:00 - 22:00.');
            return redirect()->back()->withInput();
        }


        $message = ("Reservasi Baru:\n\nNama: {$request->name}
            \nTanggal: {$request->tanggal}
            \nWaktu: {$request->waktu}
            \nAlamat: {$request->address}
            \nNo. Telepon: {$request->phone_number}
            \nKegiatan: {$request->event}
            \nJumlah Anggota: {$request->jumlah_anggota}");
        $encodedMessage = urlencode($message);
        $phoneNumber = '6281361175877';
        $whatsappUrl = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";

        Alert::success('Success', 'Reservasi Berhasil Dibuat.');
        return redirect()->away($whatsappUrl);
    }
}
