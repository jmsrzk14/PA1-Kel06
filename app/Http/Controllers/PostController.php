<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\STr;
use App\Models\Category;
use App\Models\Post;
use File;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::get();
        return view('post.index', ['post' =>$post]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::get();
        return view('post.create', ['category' =>$category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'gambar' => 'required | image | mimes:jpg, png, jpeg',
            'category_id' => 'required',
        ]);

        $fileName = time().'.'.$request->gambar->extension();
        $request->gambar->move(public_path('image'), $fileName);
        $post = new Post;

        $post->name = $request->name;
        $post->slug = STr::slug($request->name);
        $post->description = $request->description;
        $post->price = $request->price;
        $post->category_id = $request->category_id;
        $post->gambar = $fileName;

        $post->save();

        Alert::success('Sukses', 'Menu berhasil disimpan!');
        return redirect('/post');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('post.detail', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $category = Category::get();

        return view('post.update', ['post'=>$post, 'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => STr::slug($request->name),
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'gambar' => 'image | mimes:jpg, png, jpeg',
            'category_id' => 'required',
        ]);

        $post = Post::find($id);

        if($request->has('gambar')){
            $path = 'image/';
            File::delete($path. $post->gambar);
            $fileName = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('image'), $fileName);
            $post->gambar = $fileName;
            $post->save();
        }
        $post->name = $request['name'];
        $post->slug = STr::slug($request->name);
        $post->description = $request['description'];
        $post->price = $request['price'];
        $post->category_id = $request['category_id'];
        $post->save();

        Alert::success('Sukses', 'Menu berhasil diedit!');
        return redirect('/post');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $path = 'image/';
        File::delete($path, $post->gambar);
        $post->delete();

        Alert::success('Sukses', 'Menu berhasil dihapus!');
        return redirect('/post');
    }
}
