<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\STr;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function create()
    {
        return view('category.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        DB::table('category')->insert([
            'name' => $request['name'],
            'slug' => STr::slug($request->name),
            'description' => $request['description']
        ]);

        return redirect('/category');
    }

    public function userIndex()
    {
        $category = Category::all();
        return view('StrukturAdmin.navbar', compact('category'));
    }

    public function index()
    {
        $category = DB::table('category')->get();
        return view('category.show', ['category' => $category]);
    }

    public function show($id)
    {
        $category = DB::table('category')->where('id', $id)->first();
        return view('category.detail', ['category' => $category]);
    }

    public function edit($id)
    {
        $category = DB::table('category')->where('id', $id)->first();
        return view('category.edit', ['category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        DB::table('category')->where('id', $id)->update([
            'name' => $request -> name,
            'slug' => STr::slug($request->name),
            'description' => $request -> description,
        ]);

        return redirect('/category');
    }

    public function destroy($id)
    {
        DB::table('post')->where('category_id', $id)->delete();
        DB::table('category')->where('id', $id)->delete();
        return redirect('/category');
    }
}
