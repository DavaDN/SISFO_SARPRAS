<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // ini wajib kalau kamu pakai nama tabel tunggal

    protected $fillable = ['pengguna_id', 'barang_id', 'tanggal_pinjam','tanggal_kembali', 'kelas','keperluan','jumlah'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
