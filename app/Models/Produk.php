<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = ['nama', 'harga', 'stok', 'kategori_id', 'gambar'];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function keranjang() {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }
}
