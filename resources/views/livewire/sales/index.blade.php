<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function getProductsProperty()
    {
            return Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('code', 'like', '%' . $this->search . '%')
            ->paginate(2);
    }
    public function addToCart($product_id)
    {
        $product = Product::findOrFail($product_id);
        $cart = collect(Session::get('items_cart', []));

        $existingItem = $cart->firstWhere('id', $product_id);

        if ($existingItem) {
            if ($existingItem['quantity'] >= $product->quantity) {
                return back()->with('danger', 'No hay stock suficiente');
            }
            $cart = $cart->map(function ($item) use ($product_id) {
                if ($item['id'] === $product_id) {
                    $item['quantity'] += 1;
                }
                return $item;
            });
        } else {
            $cart->push([
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'quantity' => 1,
                'sale_price' => $product->sale_price
            ]);
        }

        Session::put('items_cart', $cart->toArray());
    }
    public function removeFromCart($product_id){
        $cart = collect(Session::get('items_cart', []));

        $cart = $cart->map(function ($item) use ($product_id) {
            if ($item['id'] === $product_id) {
                $item['quantity'] -= 1;
            }
            return $item;
        })->filter(fn($item) => $item['quantity'] > 0);

        Session::put('items_cart', $cart->values()->toArray());
    }
    public function sale()
    {
        $cartItems = collect(Session::get('items_cart', []));

        if ($cartItems->isEmpty()) {
            return back()->with('danger', 'No hay productos en el carrito.');
        }

        DB::beginTransaction();

        try {
            
            $totalSale = $cartItems->sum(fn($item) => $item['sale_price'] * $item['quantity']);

            // Actualizar stock
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['id']);
                $product->decrement('quantity', $item['quantity']);
            }

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total_sale' => $totalSale,
            ]);

            foreach ($cartItems as $item) {
                SaleDetails::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['sale_price'],
                    'sub_total' => $item['sale_price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            $this->resetCart();

            return redirect()->route('sales.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('sales.index')->with('danger', 'Error al realizar la venta: ' . $e->getMessage());
        }
    }
    public function resetCart(){
        Session::forget('items_cart');
    }

}; ?>

<div>
    <div class="flex flex-row justify-between items-center">
        <div>
            <flux:heading size="xl">Venta de productos</flux:heading>
        <flux:text>Crear venta de los productos existentes.</flux:text>
        </div>
        <div>
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar productos" size="52"  wire:input="$set('search', $event.target.value)" ></flux:input>
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.sales.components.table-products')
    {{-- Carrito de compras --}}
    <div class="grid grid-cols-2">
        <flux:heading size="xl">Carrito de compras</flux:heading>
        @include('livewire.sales.components.messages')
    </div>
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.sales.components.table-shoping-cart')
    <div class="flex flex-row" >
        <div>
            <form wire:submit.prevent="sale()">
            <flux:button icon="banknotes" class="cursor-pointer" variant="primary" type="submit" wire:loading.attr="disabled" >Realizar Venta</flux:button>
        </form>
        </div>
        <div class="mx-2">
            <flux:button icon="trash" class="cursor-pointer" variant="danger" wire:click="resetCart()" >Vaciar Carrito</flux:button>    
        </div>
    </div>
</div>