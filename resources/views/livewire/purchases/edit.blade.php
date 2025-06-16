<?php

use Livewire\Volt\Component;
use App\Models\Purchase;
use App\Models\Product;

new class extends Component {
    public $id;
    public $quantity;
    public $originalQuantity;
    public $cost_price;
    public $purchase;
    public $purchaseSelected;
    public $productSelected;
    public function mount(){
        $this->purchase = Purchase::select(
            'purchases.*',
            'users.name as user_name',
            'products.name as product_name',
        )
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->where('purchases.id', '=', $this->id)->first();
        /* get() devuelte un objeto no una colección. */
        $this->quantity = $this->purchase->quantity;
        $this->cost_price = $this->purchase->cost_price;
    }
    public function update(){
        $this->validate([
            'quantity' => 'required|numeric',
            'cost_price' => 'required|numeric',
    ]);
        try {
            $this->purchaseSelected = Purchase::find($this->id);
            $this->originalQuantity = $this->purchaseSelected->quantity;
            $this->purchaseSelected->quantity = $this->quantity;
            $this->purchaseSelected->cost_price = $this->cost_price;
            if ($this->purchaseSelected->save()) {
                $this->productSelected = Product::find($this->purchaseSelected->product_id);
                $this->productSelected->quantity = $this->productSelected->quantity - $this->originalQuantity + $this->quantity;
                $this->productSelected->save();
            }
            return redirect()->route('purchases.index')->with('success', 'Compra actualizada exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('purchases.index')->with('danger', 'Error al actualizar la compra: ' . $th->getMessage());
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Editar una compra.</flux:heading>
    <flux:text class="mt-2">Edición de compra de: {{ $this->purchase->product_name }} </flux:text>
    <form wire:submit.prevent="update" class="flex flex-col gap-6 mt-4">
        <flux:input type="text" label="Cantidad del producto" wire:model="quantity" />
        <flux:input type="text" label="Costo del producto" wire:model="cost_price" />
        <div class="flex items-center justify-start">
            <flux:button icon="arrow-path" variant="primary" type="submit" class="cursor-pointer">Actualizar Compra</flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('purchases.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>