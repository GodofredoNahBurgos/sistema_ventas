<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public $products;
    public function mount(){
        $this->products = Product::all();
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Productos y Stock</flux:heading>
        <flux:text class="mt-2">Administrar el stock del sistema.</flux:text>
        <flux:button icon="clipboard-document-list" variant="primary" class="m-2 self-end">
                <a href="{{ route('products.create') }}" wire:navigate>{{ __('Productos en stock minimo.') }}</a>
            </flux:button>
        <flux:separator class="my-4" />
        <div class="m-2 w-full h-16 flex justify-end">
            @include('livewire.suppliers.components.messages')
            <flux:button icon="plus" variant="primary" class="m-2 self-end">
                <a href="{{ route('products.create') }}" wire:navigate>{{ __('Crear Producto') }}</a>
            </flux:button>
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Categoria</th>
                    <th class="border border-gray-300 text-center">Proveedor</th>
                    <th class="border border-gray-300 text-center">Nombre</th>
                    <th class="border border-gray-300 text-center">Imagen</th>
                    <th class="border border-gray-300 text-center">Descripción</th>
                    <th class="border border-gray-300 text-center">Cantidad</th>
                    <th class="border border-gray-300 text-center">Compra</th>
                    <th class="border border-gray-300 text-center">Venta</th>
                    <th class="border border-gray-300 text-center">Activo</th>
                    <th class="border border-gray-300 text-center">Comprar</th>
                    <th class="border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @include('livewire.products.components.tbody')
            </tbody>
        </table>
    </div>
    {{-- @include('livewire.suppliers.components.modal-delete') --}}
</div>
