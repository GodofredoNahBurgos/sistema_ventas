<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Proveedores';
        $items = Supplier::all();
        return view('livewire.suppliers.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Proveedor';
        return view('livewire.suppliers.create', compact('titulo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $item = new Supplier();
            $item->name = $request->input('name');
            $item->email = $request->input('email');
            $item->phone = $request->input('phone');
            $item->cp = $request->input('cp');
            $item->website = $request->input('website');
            $item->notes = $request->input('notes');
            $item->save();
            return redirect()->route('suppliers.index')->with('success', 'Proveedor creado exitosamente.');
        }catch(\Exception $e){
            return redirect()->back()->with('danger', 'Error al crear el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Supplier::find($id);
        $titulo = 'Eliminar proveedor';
        return view('livewire.suppliers.show', compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Supplier::find($id);
        $titulo = 'Editar Proveedor.';
        return view('livewire.suppliers.edit', compact('titulo', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Supplier::find($id);
            $item->name = $request->input('name');
            $item->email = $request->input('email');
            $item->phone = $request->input('phone');
            $item->cp = $request->input('cp');
            $item->website = $request->input('website');
            $item->notes = $request->input('notes');
            $item->save();
            return redirect()->route('suppliers.index')->with('success', 'Proveedor actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Error al actualizar el proveedor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Supplier::find($id);
            $item->delete();
            return redirect()->route('suppliers.index')->with('success', 'Proveedor eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Error al eliminar el proveedor: ' . $e->getMessage());
        }
    }
}
