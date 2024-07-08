<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sale';

    protected $fillable = [
        'nama_pembeli', 'post_id', 'jumlah', 'tanggal_penjualan', 'price'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
