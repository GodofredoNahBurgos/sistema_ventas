<?php

use Livewire\Volt\Component;
use App\Models\Sale;
use App\Models\SaleDetails;

new class extends Component {
    public $sales;
    public function mount()
    {
        $this->sales = Sale::select(
            'sales.*',
            'users.name as user_name',
        )
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->orderBy('sales.created_at', 'desc')
        ->get();
    }
    public function detailSale($id){
        return redirect()->route('sale_details.sale_detail', ['sale_id' => $id]);
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Consulta de Ventas</flux:heading>
        <flux:text class="mt-2">Revisar ventas existentes.</flux:text>
        <div class="m-2 w-full flex justify-end">
            @include('livewire.categories.components.messages')
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Total Vendido</th>
                    <th class="border border-gray-300 text-center">Fecha</th>
                    <th class="border border-gray-300 text-center">Usuario</th>
                    <th class="border border-gray-300 text-center">Ver Detalle</th>
                    <th class="border border-gray-300 text-center">Revocar Venta</th>
                </tr>
            </thead>
            <tbody>
                @include('livewire.sale_details.components.tbody')
            </tbody>
        </table>
    </div>
</div>