<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Image;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titulo = 'Productos';
        $items = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name'
        )
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->get();
        return view('livewire.products.index', compact('titulo', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titulo = 'Crear Producto';
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('livewire.products.create', compact('titulo', 'categories', 'suppliers'));
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
            /* $item->save(); */
            /* $id_product = $item->id; */
            if ($item->save()) {
                if ($this->subirImagen($request, $item->id)) {
                    return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
                }else{
                    return redirect()->route('products.index')->with('danger', 'No se subio la imagen.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al crear el producto: ' . $th->getMessage());
        }
        
    }

    public function subirImagen($request, $id_product)
    {
        $rutaImagen = $request->file('image')->store('images', 'public');
        $nombreImagen = basename($rutaImagen);
        $item = new Image();
        $item->product_id = $id_product;
        $item->name = $nombreImagen;
        $item->path = $rutaImagen;
        return $item->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $titulo = 'Eliminar Producto';
        $item = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name'
        )
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->where('products.id', $id)->first();
        return view('livewire.products.show', compact('item', 'titulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $titulo = 'Editar Producto';       
        $categories = Category::all();
        $suppliers = Supplier::all();
        $item = Product::find($id);
        return view('livewire.products.edit', compact('titulo', 'item', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $item = Product::find($id);
            $item->name = $request->name;
            $item->description = $request->description;
            $item->sale_price = $request->sale_price;
            $item->category_id = $request->category_id;
            $item->supplier_id = $request->supplier_id;
            $item->save();
            return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al actualizar el producto: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Product::find($id);
            $item->delete();
            return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al eliminar el producto: ' . $th->getMessage());
        }
    }
    public function show_imagenes($id){
        $titulo = 'Editar Imagen';
        $item = Image::where('product_id', $id)->get();
        return view('livewire.products.show-images', compact('item', 'images'));
    }
}
