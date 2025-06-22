<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Purchase;

new class extends Component {
    public int $product_id;
    public $quantity;
    public $cost_price;
    public $purchase;
    public function mount($product_id){
        $this->product_id = $product_id;
    }
    public function getProductProperty()
    {
        return Product::find($this->product_id);
    }
    public function buy()
    {
        $this->validate([
            'quantity' => 'required|numeric',
            'cost_price' => 'required|numeric',
        ]);
        try {
            $purchase = new Purchase();
            $purchase->user_id = auth()->id();
            $purchase->quantity = $this->quantity;
            $purchase->product_id = $this->product_id;
            $purchase->cost_price = $this->cost_price;
            if ($purchase->save()) {
                $item = Product::find($this->product_id);
                $item->quantity = ($item->quantity + $this->quantity);
                $item->cost_price = $this->cost_price;
                $item->save();
            }
            $this->reset();
            return redirect()->route('products.index')->with('success', 'Producto comprado exitosamente.');
        } catch (\Throwable $th) {
            $this->reset();
            return redirect()->route('products.index')->with('danger', 'Error al comprar el producto: ' . $th->getMessage());
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Hacer una compra de: {{$this->product->name}}</flux:heading>
    <flux:text class="mt-2">Compra los productos de nuestra aplicación.</flux:text>
    <form wire:submit.prevent="buy" class="flex flex-col gap-6 mt-4">
        <flux:input type="text" label="Cantidad del producto" wire:model.defer="quantity" />
        <flux:input type="text" label="Costo del producto" wire:model.defer="cost_price" />
        <div class="flex items-center justify-start">
            <flux:button icon="shopping-bag" variant="primary" type="submit" class="cursor-pointer" wire:loading.attr="disabled">Comprar</flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('products.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>
