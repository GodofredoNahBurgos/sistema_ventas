<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

new class extends Component {
    public int $id;
    public $code;
    public $name;
    public $description;
    public $sale_price;
    public $categories;
    public $suppliers;
    public $categorySelected;
    public $supplierSelected;
    
    public function mount(){
        $product = Product::find($this->id);
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
        $this->code = $product->code;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->sale_price = $product->sale_price;
        $this->categorySelected = $product->category_id;
        $this->supplierSelected = $product->supplier_id;
    }
    public function update(){
        $validated = $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'categorySelected' => 'required|exists:categories,id',
            'supplierSelected' => 'required|exists:suppliers,id',
            'sale_price' => 'required|numeric',
        ]);
        try {
            $product = Product::find($this->id);
            $product->name = $this->name;
            $product->code = $this->code;
            $product->description = $this->description;
            $product->category_id = $this->categorySelected;
            $product->supplier_id = $this->supplierSelected;
            $product->sale_price = $this->sale_price;
            $product->save();
            session()->flash('success', __('Producto actualizado exitosamente.'));
            $this->reset();
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            $this->reset();
            return redirect()->route('products.index')->with('danger', 'Error al actualizar el producto: ' . $th->getMessage());
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Actualizar Producto</flux:heading>
    <flux:text class="mt-2">Actualiza los productos de nuestra aplicación.</flux:text>
    <form wire:submit.prevent="update" class="flex flex-col gap-6 mt-4">
        <flux:input type="text" label="Codigo" wire:model.defer="code" />
        <flux:select wire:model.defer='categorySelected' label="Categoria">
            <flux:select.option value="" disabled>
                {{__('Seleccionar categoria ...')}}
            </flux:select.option>
            @foreach ($categories as $category)
            <flux:select.option value="{{$category->id}}">
                {{__($category->name)}}
            </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.defer='supplierSelected' label="Proveedor">
            <flux:select.option value="" disabled>
                {{__('Seleccionar proveedor ...')}}
            </flux:select.option>
            @foreach ($suppliers as $supplier)
            <flux:select.option value="{{$supplier->id}}">
                {{__($supplier->name)}}
            </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input type="text" label="{{__('Nombre')}}" wire:model.defer="name" />
        <flux:textarea label="Descripción" placeholder="Descripción sobre el producto" wire:model.defer="description"
            rows="auto" />
        <flux:input type="text" label="Precio de Venta" wire:model.defer="sale_price" />
        <div class="flex items-center justify-start">
            <flux:button icon="arrow-path" variant="primary" type="submit" class="cursor-pointer" wire:loading.attr="disabled">Actualizar Producto
            </flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('products.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>