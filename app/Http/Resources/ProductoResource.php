<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\VariacionResource;


class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'nombre'       => $this->nombre,
            'referencia'   => $this->referencia,
            'descripcion'  => $this->descripcion,
            'precio'       => $this->precio,
            'variaciones'  => $this->when($this->condition, VariacionResource::collection($this->variaciones)),
            'updated_at'   => $this->updated_at->format('d-m-Y'),
            'created_at'   => $this->created_at->format('d-m-Y')
        ];
    }
}
