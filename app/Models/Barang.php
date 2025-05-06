<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // <- beri tahu Laravel nama tabelnya 'barang'

    protected $fillable = ['nama', 'kategori_id'];
    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
