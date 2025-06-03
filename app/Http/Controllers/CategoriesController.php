<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Administrar Categorías';
        $items = Category::all(); 
        return view('livewire.categories.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Categoría';
        return view('livewire.categories.create', compact);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $item = new Category();
        $item->name = $request->name;
        $items->user_id = auth()->id();
        $item->save();

        /* to_route */
        return view('livewire.categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Category::find($id);
        return view('livewire.categories.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Categoría';
        $item = Category::find($id);
        return view('livewire.categories.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Category::find($id);
        $item->name = $request->name;
        $item->save();

        /* to_route */
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Category::find($id);
        $item->delete();
        /* to_route */
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
