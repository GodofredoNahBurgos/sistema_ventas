<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Image;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $selectedProductId = null;
    public $selectedProductName = null;

    public function getProductsProperty()
    {
        return Product::select(
            'products.*',
            'categories.name as category_name',
            'suppliers.name as supplier_name',
            'images.path as image_path',
            'images.id as image_id'
            )
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->leftjoin('images', 'products.id', '=', 'images.product_id')
            ->where(function ($query) {
                $query->where('products.name', 'like', '%' . $this->search . '%')
                ->orWhere('products.code', 'like', '%' . $this->search . '%');
            })->paginate(4);
    }
    public function getCurrentPage()
    {
    return $this->getPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function confirmDelete($id){
        $this->selectedProductId = $id;
        $this->selectedProductName = Product::find($id)->name;
    }
    public function delete($id)
    {
        try {
            $purchases = Purchase::where('product_id', $id);
            if ($purchases) {
            session()->flash('danger', 'No se puede eliminar el producto porque tiene compras asociadas.');
            }else {
                $product = Product::find($id);
                $imageModel = Image::where('product_id', $product->id)->first();
                if ($imageModel && $imageModel->path && Storage::disk('public')->exists($imageModel->path)) {
                Storage::disk('public')->delete($imageModel->path);
                }
            $product->delete();
            session()->flash('success', 'Producto eliminado correctamente.');
            }
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar el producto: ' . $th->getMessage());
        }
        Flux::modal('delete-product')->close();
        $this->reset('selectedProductId', 'selectedProductName');
        $this->resetPage();
    }
    public function updateProductState($user_id)
    {
        try {
            $product = Product::find($user_id);
            if ($product) {
                $product->active = !$product->active;
                $product->save();
                if ($product->active){
                    session()->flash('success', 'Producto activado correctamente.');
                } else {
                    session()->flash('danger', 'Producto desactivado correctamente.');
                }
            }
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al actualizar el estado del producto: ' . $th->getMessage());
        }
    }
    public function updateProduct($id)
    {
        return redirect()->route('products.edit', ['id' => $id]);
    }
    public function updateImage($product_id = 0, $image_id = 0)
    {
        return redirect()->route('products.update-image', ['product_id' => $product_id, 'image_id' => $image_id]);
    }
    public function resetSelectedProduct()
    {
        $this->reset('selectedProductId', 'selectedProductName');
    }

}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Productos y Stock</flux:heading>
            <flux:text class="mt-2">Administrar el stock del sistema.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Productos" size="30"
                wire:model.live="search"></flux:input>
            <div class="pt-6">
                <flux:button icon="plus" variant="primary">
                    <a href="{{ route('products.create') }}">{{ __('Crear Producto') }}</a>
                </flux:button>
            </div>
        </div>
    </div>
    @include('livewire.products.components.messages')
    <flux:separator class="my-4" text="Datos" />
    <div wire:key="users-table-{{ $search }}-page{{ $this->getCurrentPage() }}">
        @include('livewire.products.components.table')
    </div>
    @include('livewire.products.components.modal-delete')
</div>