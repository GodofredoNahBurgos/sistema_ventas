<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductReportsController extends Controller
{
    public function index()
    {
        $titulo = 'Reporte de Productos';
        $items = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name'
        )
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->get();
        return view('livewire.product_reports.index', compact('titulo', 'items'));
    }
}
