<?php

namespace App\Http\Controllers\Kasir;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Http\Controllers\Controller;

class PenjualanKasirController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::orderBy('created_at', 'desc')->paginate(20);
        $produk = Produk::all();

        return view('kasir.penjualan.indexPenjualan', compact('penjualan', 'produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::all();

        return view('kasir.penjualan.tambahPenjualan', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'produk_id.*' => 'required|exists:produk,id',
            'jumlah.*' => 'required|numeric|min:1',
        ]);

        $produk_id = array_reverse($request->get('produk_id'));
        $jumlah = array_reverse($request->get('jumlah'));

        foreach($produk_id as $index => $produk_id){
            if (isset($jumlah[$index])) {
                $newPenjualan = new Penjualan;
                $newPenjualan->fill([
                    'nama_pembeli' => $request->get('nama_pembeli'),
                    'produk_id' => $produk_id,
                    'jumlah' => $jumlah[$index]
                ]);
                $newPenjualan->save();
            }
        }
        return redirect("kasir/penjualan")->with ('status', 'penjualan berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penjualan = Penjualan::find($id);
        return view('kasir.penjualan.viewPenjualan', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $penjualan = Penjualan::find($id);
        return view('kasir.penjualan.editPenjualan', ['penjualan' => $penjualan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
        ]);

        Penjualan::where('id', $id)->update
        ([
                'jumlah' => $request->jumlah,
        ]);

        return redirect('/kasir/penjualan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $penjualan = Penjualan::find($id);
        $penjualan->delete();
        return redirect('/kasir/penjualan')->with('status', 'Data Penjualan berhasil di hapus');
    }
}
