<?php

namespace App\Http\Controllers;
use Dompdf\Dompdf;
use App\Models\Sale;
use App\Models\SaleDetails;
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

        /* return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="ticket.pdf"',
        ]); */
        /* return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ticket.pdf"',
        ]); */
    }
}
