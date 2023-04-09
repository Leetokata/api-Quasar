<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variacion extends Model
{
    use HasFactory;

    protected $table = 'variaciones';

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
