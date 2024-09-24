<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    public $fillable = [
        'nama_kategori',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
    use HasFactory;
}
