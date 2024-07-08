<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';

    protected $fillable = [
        'name',
        'tanggal',
        'waktu',
        'medsos',
        'address',
        'phone_number',
        'event',
        'jumlah_anggota',
        'status'
    ];
    
}
