<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table ='post';
    protected $fillable = ['name', 'description', 'price', 'gambar', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }

    // public function keranjang()
    // {
    //     return $this->hasMany(Keranjangs::class, 'id');
    // }
}
