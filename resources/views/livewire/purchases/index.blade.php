<?php

use Livewire\Volt\Component;
use App\Models\Purchase;

new class extends Component {
    public $purchases;
    public function mount()
    {
        $this->purchases = Purchase::select(
            'purchases.*',
            'users.name as user_name',
            'products.name as product_name',
        )
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->get();
    }
    public function updatePurchase($id){
        return redirect()->route('purchases.edit', ['id' => $id]);
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Compras de productos</flux:heading>
        <flux:text class="mt-2">Administrar compras de productos.</flux:text>
        <div class="m-2 w-full{{--  h-16 --}} flex justify-end">
            @include('livewire.products.components.messages')
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.purchases.components.tbody')
</div>