<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public $fillable = [
        'nama_barang',
        'kode',
        'kategori_id',
        'lokasi',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function mutasi()
    {
        return $this->hasMany(Mutasi::class);
    }

    use HasFactory;
}
