<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    
    protected $fillable = [
        'npm',
        'nama',
        'jurusan',
        'tanggal_lahir',
        'foto'
    ];

    protected $dates = [
        'tanggal_lahir'
    ];
}