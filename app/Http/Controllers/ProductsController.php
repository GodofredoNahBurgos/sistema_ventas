<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Supplier;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Productos';
        return view('livewire.products.index', compact('titulo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Producto';
        $categorias = Category::all();
        $proveedores = Supplier::all();
        return view('livewire.products.create', compact('titulo', 'categorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Product();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->user_id = auth()->id();
            $item->category_id = $request->category_id;
            $item->supplier_id = $request->supplier_id;
            $item->save();
            return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');return redirect()->route('products.index')->with('success', 'Proveedor creado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al crear el producto: ' . $th->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
