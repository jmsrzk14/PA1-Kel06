<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Post;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class SaleController extends Controller
{
    public function index()
    {
        $penjualan = Sale::with('post')->orderBy('created_at', 'desc')->paginate(20);
        $post = Post::all();

        return view('Admin.penjualan.indexSale', compact('penjualan', 'post'));
    }

    public function create()
    {
        $post = Post::all();
        return view('Admin.penjualan.createSale', compact('post'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'post_id.*' => 'required|exists:post,id',
            'jumlah.*' => 'required|numeric|min:1',
            'tanggal_penjualan' => 'required|date',
        ]);

        $post_id = $request->post_id;
        $jumlah = $request->jumlah;
        $tanggal_penjualan = $request->tanggal_penjualan;

        foreach ($post_id as $index => $post_id) {
            $post = Post::find($post_id);
            $jumlah = $jumlah[$index];
            $price = $post->price;
            $price = $jumlah * $price;

            $newPenjualan = new Sale;
            $newPenjualan->fill([
                'nama_pembeli' => $request->nama_pembeli,
                'post_id' => $post_id,
                'jumlah' => $jumlah,
                'tanggal_penjualan' => $tanggal_penjualan,
                'price' => $price,
            ]);
            $newPenjualan->save();
        }
        Alert::success('Sukses', 'Data pembelian berhasil dibuat!');
        return redirect("admin/sale");
    }

    public function show($id)
    {
        $penjualan = Sale::find($id);
        return view('Admin.penjualan.viewSale', compact('penjualan'));
    }

    public function edit(string $id)
    {
        $penjualan = Sale::find($id);
        return view('Admin.penjualan.editSale', ['penjualan' => $penjualan]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
            'tanggal_penjualan' => 'required|date',
        ]);

        $penjualan = Sale::find($id);
        if (!$penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Data tidak ditemukan.');
        }

        $post = Post::find($penjualan->post_id);
        $price = $request->jumlah * $post->price;

        $penjualan->update([
            'jumlah' => $request->jumlah,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'price' => $price,
        ]);

        Alert::success('Sukses', 'Data penjualan berhasil diedit!');
        return redirect('/admin/sale');
    }

    public function destroy(string $id)
    {
        $penjualan = Sale::find($id);
        $penjualan->delete();
        Alert::success('Sukses', 'Daftar penjualan berhasil dihapus!');
        return redirect('/admin/sale');
    }
}
