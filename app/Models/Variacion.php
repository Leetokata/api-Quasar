<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variacion extends Model
{
    use HasFactory;

    protected $table = 'variaciones';

    protected $fillable = [
        'referencia',
        'descripcion',
        'precio',
        'producto_id'
    ];
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
