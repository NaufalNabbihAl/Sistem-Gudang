<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    public $fillable = [
        'barang_id',
        'jumlah',
        'tanggal',
        'jenis_mutasi',
        'user_id'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
