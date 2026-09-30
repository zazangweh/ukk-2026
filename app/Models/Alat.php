<?php

namespace App\Models;

use Sakuci\Database\Model;

class Alat extends Model
{
    protected static ?string $table = 'alat';
    protected string $primaryKey = 'id_alat';

    protected array $fillable = [
        'id_alat',
        'nama_alat',
        'kode_alat',
        'jumlah',
        'id_kategori',
        'lokasi',
        'kondisi'
    ];

    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}