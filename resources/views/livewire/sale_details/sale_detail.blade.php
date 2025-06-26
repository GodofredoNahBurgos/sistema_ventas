<?php

use Livewire\Volt\Component;
use App\Models\Sale;
use App\Models\SaleDetails;

new class extends Component {
    
    public int $sale_id;

    public function getSaleProperty(){
        return Sale::select(
            'sales.*',
            'users.name as user_name',
        )
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->where('sales.id', '=', $this->sale_id)
        ->first();
    }

    public function getDetailsProperty(){
        return SaleDetails::select(
            'sale_details.*',
            'products.name as product_name',
        )
        ->join('products', 'sale_details.product_id', '=', 'products.id')
        ->where('sale_details.sale_id', '=', $this->sale_id)
        ->get();
    }

}; ?>

<div>
    @php
        $sale = $this->sale;
    @endphp
    <div class="flex flex-col">
        <flux:heading size="xl">Detalles de Venta</flux:heading>
        <flux:text class="mt-2">Detalle de la venta</flux:text>
        <div class="m-2 w-full flex justify-end">
            @include('livewire.categories.components.messages')
        </div>
    </div>
    <flux:heading size="lg" >Venta ralizada por: {{ $sale->user_name }}</flux:heading>
    <flux:heading size="lg" >Total de Venta: {{ '$'.$sale->total_sale }}</flux:heading>
    <flux:heading size="lg" >Fecha: {{ $sale->created_at }}</flux:heading>
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.sale_details.components.table-detail')
    <flux:button icon="arrow-left" variant="primary" class="m-2 self-end"><a href="{{ route('sale_details.index') }}">Regresar</a></flux:button>
</div>