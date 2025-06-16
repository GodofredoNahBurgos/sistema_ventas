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
        $item = Product::find($product_id);
        /* Obtener productos ya almacenados. */
        $availableQuantity = $item->quantity;
        $items_cart = Session::get('items_cart', []);
        /* Verificar si el producto ya está en el carrito. */
        $exists = false;
        foreach ($items_cart as $key => $cart_item) {
            if ($cart_item['id'] == $product_id) {
                if ($cart_item['quantity'] >= $availableQuantity) {
                    return back()->with('danger', 'No hay stock suficiente');
                }
                /* Actualizar la cantidad. */
                $items_cart[$key]['quantity'] += 1;
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            /* Agregar el nuevo producto. */
        $items_cart [] = [
            'id' => $product_id,
            'code' => $item->code,
            'name' => $item->name,
            'quantity' => 1,
            'sale_price' => $item->sale_price
        ];
        }
        /* Creamos la sesiom */
        Session::put('items_cart', $items_cart);
    }
    public function removeFromCart($product_id){
        $items_cart = Session::get('items_cart', []);
        foreach ($items_cart as $key => $cart_item) {
            if ($cart_item['id'] == $product_id) {
                if ($cart_item['quantity'] > 1) {
                    $items_cart[$key]['quantity'] -= 1;
                }else {
                    unset($items_cart[$key]);
                }
                break;
            }
        }
        Session::put('items_cart', $items_cart);
    }
    public function sale()
    {
        $items_cart = Session::get('items_cart', []);
        if (empty($items_cart)) {
            return back()->with('danger', 'No hay productos en el carrito.');
        }
        /* Inciar transaccion, si algo sale mal no se guarda*/
        DB::beginTransaction();
        try {
            $totalSale = 0;
            foreach ($items_cart as $item) {
                $totalSale += $item['sale_price'] * $item['quantity'];
                $product = Product::find($item['id']);
                $product->quantity -= $item['quantity'];
                $product->save();
            }
            /* Crear la venta */
            $sale = new Sale();
            $sale->user_id = auth()->id();
            $sale->total_sale = $totalSale;
            $sale->save();
            /* Guardar los detalles de la venta */
            foreach ($items_cart as $item) {
                $saleDetail = new SaleDetails();
                $saleDetail->sale_id = $sale->id;
                $saleDetail->product_id = $item['id'];
                $saleDetail->quantity = $item['quantity'];
                $saleDetail->sub_total = $item['sale_price'] * $item['quantity'];
                $saleDetail->unit_price = $item['sale_price'];
                $saleDetail->save();
            }
            DB::commit();
            $this->resetCart();
            return redirect()->route('sales.index')->with('success', 'Venta realizada exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('sales.index')->with('danger', 'Error al realizar la venta: ' . $th->getMessage());
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
            <flux:button icon="banknotes" class="cursor-pointer" variant="primary" type="submit" >Realizar Venta</flux:button>
        </form>
        </div>
        <div class="mx-2">
            <flux:button icon="trash" class="cursor-pointer" variant="danger" wire:click="resetCart()" >Vaciar Carrito</flux:button>    
        </div>
    </div>
</div>
