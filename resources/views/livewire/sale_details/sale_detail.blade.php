<?php

use Livewire\Volt\Component;
use App\Models\Sale;
use App\Models\SaleDetails;

new class extends Component {
    public $sale;
    public $details;
    public $sale_id;
    public function mount(){
        $this->sale = Sale::select(
            'sales.*',
            'users.name as user_name',
        )
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->where('sales.id', '=', $this->sale_id)
        ->first();
        $this->details = SaleDetails::select(
            'sale_details.*',
            'products.name as product_name',
        )
        ->join('products', 'sale_details.product_id', '=', 'products.id')
        ->where('sale_details.sale_id', '=', $this->sale_id)
        ->get();
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Detalles de Venta</flux:heading>
        <flux:text class="mt-2">Detalle de la venta</flux:text>
        <div class="m-2 w-full flex justify-end">
            @include('livewire.categories.components.messages')
        </div>
    </div>
    <flux:heading size="lg" >Venta ralizada por: {{ $this->sale->user_name }}</flux:heading>
    <flux:heading size="lg" >Total de Venta: {{ '$'.$this->sale->total_sale }}</flux:heading>
    <flux:heading size="lg" >Fecha: {{ $this->sale->created_at }}</flux:heading>
    <flux:separator class="my-4" text="Datos" />
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Producto</th>
                    <th class="border border-gray-300 text-center">Cantdad</th>
                    <th class="border border-gray-300 text-center">Precio Unitario</th>
                    <th class="border border-gray-300 text-center">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @include('livewire.sale_details.components.tbody-detail')
            </tbody>
        </table>
    </div>
    <flux:button icon="arrow-left" variant="primary" class="m-2 self-end"><a href="{{ route('sale_details.index') }}">Regresar</a></flux:button>
</div>