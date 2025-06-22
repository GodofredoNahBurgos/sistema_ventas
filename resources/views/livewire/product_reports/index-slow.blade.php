<?php

use Livewire\Volt\Component;
use App\Models\Product;
/* Para manejo de excel */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    
    public function getProductsProperty()
    {
        return Product::select(
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
    }
    public function getProductsTableProperty()
    {
        return Product::select(
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
        ->paginate(5);
    }
    public function exportAllProductsExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Categoria');
        $sheet->setCellValue('D1', 'Proveedor');
        $sheet->setCellValue('E1', 'Cantidad');
        $sheet->setCellValue('F1', 'Precio Compra');
        $sheet->setCellValue('G1', 'Precio Venta');

        $data = $this->products;
        
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->category_name);
            $sheet->setCellValue('D' . $row, $item->supplier_name);
            $sheet->setCellValue('E' . $row, $item->quantity);
            $sheet->setCellValue('F' . $row, $item->cost_price);
            $sheet->setCellValue('G' . $row, $item->sale_price);
            $row++;
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'productos-sin-stock.xlsx');

    }

}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Reportes de productos</flux:heading>
        <flux:text class="mt-2">Administrar los reportes de nuestros productos.</flux:text>
        <div class="m-2 w-full flex justify-around">
            <flux:button icon="clipboard-document-list" variant="primary" wire:click="exportAllProductsExcel"
                class="cursor-pointer">
                Exportar en Excel
            </flux:button>
            <flux:button href="{{route('products-min.pdf')}}" target="_blank" icon="clipboard-document-list" variant="primary" class="cursor-pointer">
                Exportar en PDF
            </flux:button>
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.product_reports.components.table')
</div>
