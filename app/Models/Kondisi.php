<?php

namespace App\Models;

use Sakuci\Database\Model;

class Kondisi extends Model
{
    protected static ?string $table = 'kondisi';
    protected string $primaryKey = 'id_kondisi';
    protected array $fillable = ['nama_kondisi'];
}