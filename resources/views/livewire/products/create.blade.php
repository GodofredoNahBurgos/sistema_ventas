<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

new class extends Component {
    public $name;
    public $description;
    public $categorySelected = '';
    public $supplierSelected = '';
    public $categories;
    public $suppliers;
    public function mount()
    {
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
    }
    public function create()
    {
        $this->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'categorySelected' => 'required|exists:categories,id',
                'supplierSelected' => 'required|exists:suppliers,id',
            ]);
            try {
                Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->categorySelected,
                'supplier_id' => $this->supplierSelected,
                'user_id' => Auth::id(),
            ]);
            session()->flash('success', __('Producto creado exitosamente.'));
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            session()->flash('danger', __('Error al crear el producto: ') . $th->getMessage());
            return redirect()->route('products.index');
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Crear Producto</flux:heading>
    <flux:text class="mt-2">Crea los productos de nuestra aplicación.</flux:text>
    <form wire:submit.prevent="create" class="flex flex-col gap-6 mt-4">
        <flux:select wire:model='categorySelected' label="Categoria">
            <flux:select.option value="" disabled>
                {{__('Seleccionar categoria ...')}}
            </flux:select.option>
            @foreach ($categories as $category)
            <flux:select.option value="{{$category->id}}">
                {{__($category->name)}}
            </flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model='supplierSelected' label="Proveedor">
            <flux:select.option value="" disabled>
                {{__('Seleccionar proveedor ...')}}
            </flux:select.option>
            @foreach ($suppliers as $supplier)
            <flux:select.option value="{{$supplier->id}}">
                {{__($supplier->name)}}
            </flux:select.option>
            @endforeach
        </flux:select>
        <flux:input type="text" label="{{__('Nombre')}}" wire:model="name" />
        <flux:textarea label="Descripción" placeholder="Descripción sobre el producto" wire:model="description" rows="auto" />
        <div class="flex items-center justify-start">
            <flux:button icon="plus" variant="primary" type="submit" class="cursor-pointer">Crear Producto</flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('products.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>