<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\Variacion;

use App\Http\Resources\VariacionResource;

// use App\Http\Requests\Variacion\IndexVariacionRequest;

class VariacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $variaciones =  Variacion::all();
       return VariacionResource::collection($variaciones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
