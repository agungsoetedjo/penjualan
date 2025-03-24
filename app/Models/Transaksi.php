<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['kode_transaksi', 'total_harga', 'status'];

    public function details() {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }
}
