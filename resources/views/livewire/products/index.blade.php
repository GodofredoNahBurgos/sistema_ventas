<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component {
    public $productStates = [];
    public $products;
    public $selectedProductId = null;
    public $selectedProductName = null;
    public $supplier_name;
    public $category_name;
    public function mount(){
        /* @dump('Se está ejecutando el metodo mount'); */
        $this->products = Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name',
            'images.path as image_path',
            'images.id as image_id'
        )
        ->join('categories', 'products.category_id', '=', 'categories.id')
        ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
        ->leftjoin('images', 'products.id', '=', 'images.product_id')
        ->get();
        foreach ($this->products as $product) {
            if ($product->active) {
                $this->productStates[$product->id] = true;
            }else{
                $this->productStates[$product->id] = false;
            }
        }
    }
    public function updateProduct($id){
        return redirect()->route('products.edit', ['id' => $id]);
    }
    public function updateImage($image_id){
        return redirect()->route('products.show-image', ['image_id' => $image_id]);
    }
    public function confirmDelete($id){
        $this->selectedProductId = $id;
        $this->selectedProductName = Product::find($id)->name;
    }
    public function delete($id){
        try {
            Product::find($id)->delete();
            Flux::modal('delete-product')->close();
            session()->flash('danger', 'Producto eliminado correctamente.');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar el producto: ' . $th->getMessage());
        }
        $this->selectedProductId = null;
        $this->selectedProductName = null;
    }
    public function updatedProductStates($value, $key){
        try {
            $product = Product::find($key);
            if ($product) {
                $product->active = $value;
                $product->save();
                if ($value) {
                    session()->flash('success', 'Producto activado correctamente.');
                } else {
                    session()->flash('danger', 'Producto desactivado correctamente.');
                }
            }
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al actualizar el estado del usuario: ' . $th->getMessage());
        }
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Productos y Stock</flux:heading>
        <flux:text class="mt-2">Administrar el stock del sistema.</flux:text>
        <div class="m-2 w-full h-16 flex justify-end">
            @include('livewire.products.components.messages')
            <flux:button icon="plus" variant="primary" class="m-2 self-end">
                <a href="{{ route('products.create') }}" wire:navigate>{{ __('Crear Producto') }}</a>
            </flux:button>
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    <div class="overflow-x-auto">
        <table wire:ignore class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Codigo</th>
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
    @include('livewire.products.components.modal-delete')
</div>

@livewireScripts
