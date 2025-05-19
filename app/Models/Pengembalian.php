<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian'; // penting karena nama tabel tidak plural

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'jumlah',
        'kondisi',
        'status',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
