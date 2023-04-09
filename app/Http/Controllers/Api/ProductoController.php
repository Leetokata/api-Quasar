<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;

use App\Http\Requests\ProductoRequest;

use App\Http\Resources\ProductoResource;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('id','desc')->get();
        //$productos = Producto::with('variaciones')->get();

        return ProductoResource::collection($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {

       // Producto::create($request->all());

        return new ProductoResource(Producto::create($request->all()));

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->variaciones;
        $producto->condition = true;

        return new ProductoResource($producto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $producto->update($request->all());
        return new ProductoResource($producto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
