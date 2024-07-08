<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $kasir = User::where('role', 'kasir')->paginate(10);

        return view('admin.kasir.indexKasir', compact('kasir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kasir.tambahKasir');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        $newKasir = new User;
        $newKasir->name = $request->name;
        $newKasir->email = $request->email;
        $newKasir->password = Hash::make($request->password);
        $newKasir->role = 'kasir';

        $newKasir->save();
        return redirect("admin/kasir")->with ('status', 'Kasir berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kasir = DB::table('users')->where('id', $id)->where('role', 'kasir')->first();
        return view('admin.kasir.viewKasir', compact('kasir'));
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        DB::table('users')->where('id', $id)->where('role', 'kasir')->delete();
        return redirect('/admin/kasir');
    }
}
