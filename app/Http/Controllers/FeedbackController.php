<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Feedback;
use RealRashid\SweetAlert\Facades\Alert;


class FeedbackController extends Controller
{
    public function UserFeedback()
    {
        $category = Category::all();
        $masukan = Feedback::all();
        return view('User.masukan', compact('masukan', 'category'));
    }

    public function feedback(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'komentar' => 'required',
        ], [
            'email.required' => 'Email Wajib Diisi.',
            'email.email' => 'Format email tidak valid',
            'komentar.required' => 'Pesan wajib diisi'
        ]);

        if (auth()->check()) {
            $masukan = new Feedback;
            $masukan->ID_user = auth()->user()->id;
            $masukan->email = $request->input('email');
            $masukan->komentar = $request->input('komentar');
            $masukan->save();

            Alert::success('Sukses', 'Komentar Berhasil Dikirim.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Masukkan email anda dengan benar');
            return redirect()->back();
        }
    }
}
