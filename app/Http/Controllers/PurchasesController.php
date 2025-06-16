<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Compras';
        $items = Purchase::select(
            'purchases.*',
            'users.name as user_name',
            'products.name as product_name',
        )
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->get();
        return view('livewire.purchases.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $titulo = 'Comprar Productos';
        $item = Product::find($id);
        return view('livewire.purchases.create', compact('titulo', 'item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $item = new Purchase();
            $item->user_id = auth()->id();
            $item->quantity = $request->quantity;
            $item->product_id = $request->product_id;
            $item->cost_sale = $request->cost_price;
            if ($item->save()) {
                $item = Product::find($request->product_id);
                $item->quantity = ($item->quantity + $request->quantity);
                $item->save();
            }
            return redirect()->route('products.index')->with('success', 'Producto comprado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al comprar el producto: ' . $th->getMessage());
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
        $titulo = 'Editar Compras';
        $items = Purchase::select(
            'purchases.*',
            'users.name as user_name',
            'products.name as product_name',
        )
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->where('purchases.id', $id)->first();
        return view('livewire.purchases.edit', compact('titulo', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $quantityBefore = 0;
            $item = Purchase::find($id);
            $item->quantity = $request->quantity;
            $quantityBefore = $item->quantity;
            $item->cost_price = $request->cost_price;
            if ($item->save()) {
                $item = Product::find($request->product_id);
                $item->quantity = ($item->quantity - $quantityBefore) + $request->quantity;
                $item->save();
            }
            return redirect()->route('purchases.index')->with('success', 'Compra actualizada exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('purchases.index')->with('danger', 'Error al actualizar la compra: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
