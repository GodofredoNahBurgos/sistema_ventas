<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PdfController extends Controller
{
    public function ticket($sale_id)
    {
        $sale = Sale::select(
            'sales.*',
            'users.name as user_name',
        )
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->where('sales.id', '=', $sale_id)
        ->first();
        $details = SaleDetails::select(
            'sale_details.*',
            'products.name as product_name',
        )
        ->join('products', 'sale_details.product_id', '=', 'products.id')
        ->where('sale_details.sale_id', '=', $sale_id)
        ->get();
        $html = View::make('livewire.sale_details.components.ticket', [
            'sale' => $sale,
            'details' => $details
        ])->render();
        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('ticket'.$sale->id.'.pdf', array("Attachment" => false));
    }
    public function productsStock()
    {
        $products = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name',
            'images.path as image_path',
            'images.id as image_id'
            )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->leftjoin('images', 'products.id', '=', 'images.product_id')
            ->get();
            
            $html = View::make('livewire.product_reports.components.products_pdf', [
                'products' => $products
                ])->render();
                $pdf = new Dompdf();
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();
                $pdf->stream('Productos.pdf', array("Attachment" => false));
    }
    public function productsStockMin()
    {
        $products = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name',
            'images.path as image_path',
            'images.id as image_id'
        )
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->leftjoin('images', 'products.id', '=', 'images.product_id')
        ->whereBetween('products.quantity', [0,3])
        ->get();

        $html = View::make('livewire.product_reports.components.products_pdf_minstock', [
                'products' => $products
                ])->render();
                $pdf = new Dompdf();
                $pdf->loadHtml($html);
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();
                $pdf->stream('productos-sin-stock.pdf', array("Attachment" => false));
    }
}
