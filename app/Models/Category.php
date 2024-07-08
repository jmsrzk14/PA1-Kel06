<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    
    protected $fillable = ['name', 'description'];

    public function product()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

}
