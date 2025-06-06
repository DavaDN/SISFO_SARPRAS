<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;
    protected $table = 'kategori_barang';
    protected $fillable = ['nama'];
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_barang_nama', 'nama');
    }
}
