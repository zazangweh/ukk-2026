<?php

namespace App\Models;

use Sakuci\Database\Model;

class Lokasi extends Model
{
    protected static ?string $table = 'lokasi';
    protected string $primaryKey = 'id_lokasi';
    protected array $fillable = ['nama_lokasi'];
}