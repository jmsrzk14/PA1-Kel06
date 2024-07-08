<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    public function Userhome()
    {
        $storage = order::get();
        $category = Category::all();
        return view('User.home', compact('storage', 'category'));
    }

    public function adminWelcome()
    {
        return view('admin.welcome');
    }

    public function AllPesanan()
    {
        $category = Category::all();
        $storage = order::get();
        return view('Admin.pesanan.all', compact('storage', 'category'));
    }

    public function Category($slug)
    {
        $category = Category::all();
        $categories = Category::where('slug', $slug)->firstOrFail();
        $item = $categories->product()->get();

        return view('User.menucategory', compact('category', 'item'));
    }

    public function pesanan(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silahkan Login atau Register untuk membuat reservasi.');
        }
        $category = Category::all();
        $order = order::where('user_id', auth()->user()->id)->get();
        return view('User.daftarpemesanan', compact('category', 'order'));
    }

    public function addPesanan(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silahkan Login atau Register untuk membuat reservasi.');
        }

        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
        ]);
        $storage = new order;
        $storage->user_id = $request->user()->id;
        $storage->product_name = $request->product_name;
        $storage->price = $request->price;
        $storage->save();

        return redirect()->route('pesanan')->with('message', 'Barang Berhasil Ditambahkan ke Daftar Pesanan.');
    }

    public function deletePesanan($id)
    {
    order::find($id)->delete();
        return redirect()->back()->with('success', 'Pesanan Behasil di Hapus.');
    }

    public function statuspemesanan(Request $request, $id)
    {
        $data = order::find($id);

        if ($request->has('status')) {
            $status = $request->status;
            if ($status == 1) {
                    $data->status = 1; //Diterima
            } elseif ($status == 2) {
                $data->status = 2; // Ditolak
            } else {
                $data->status = 0; // Menunggu
            }
        }

        $data->save();
        return redirect()->back()->with('message', 'Status Pemesanan Berhasil Diubah');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $items = Product::where('name', 'LIKE', "%{$query}%")->get();
        $category = Category::all();

        return view('User.searchresults', compact('items', 'category'));
    }
}
