<?php

use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Image;

use Livewire\WithFileUploads; // Importante para subir archivos
new class extends Component {
    use WithFileUploads; // Trae la funcionalidad para subir archivos
    public $code;
    public $name;
    public $description;
    public $categorySelected = '';
    public $supplierSelected = '';
    public $categories;
    public $suppliers;
    public $image;
    public function mount()
    {
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
    }
    public function create()
    {
        $this->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'categorySelected' => 'required|exists:categories,id',
            'supplierSelected' => 'required|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /* dd($this->image); */
        try {
            $product = new Product();
            $product->code = $this->code;
            $product->name = $this->name;
            $product->description = $this->description;
            $product->category_id = $this->categorySelected;
            $product->supplier_id = $this->supplierSelected;
            $product->user_id = auth()->user()->id;
            if ($product->save()) {
                if ($this->image) {
                    if ($this->uploadImage($product->id)) {
                        $this->image = null;
                        session()->flash('success', __('Producto creado exitosamente.'));
                        return redirect()->route('products.index');
                    }else {
                        session()->flash('danger', __('Producto creado pero no se subio la imagen.'));
                        return redirect()->route('products.index');
                    }
                }
            }
            } catch (\Throwable $th) {
                session()->flash('danger', __('Error al crear el producto: ') . $th->getMessage());
                return redirect()->route('products.index');
            }
    }
    public function uploadImage($product_id)
    {
        $path = $this->image->store('products', 'public');
        $nameImage = basename($path);

        $imageModel = new Image();
        $imageModel->name = $nameImage;
        $imageModel->product_id = $product_id;
        $imageModel->path = $path;
        return $imageModel->save();
    }
}; ?>

<div>
    <flux:heading size="xl">Crear Producto</flux:heading>
    <flux:text class="mt-2">Crea los productos de nuestra aplicación.</flux:text>
    <form wire:submit.prevent="create" class="flex flex-col gap-6 mt-4" enctype="multipart/form-data">
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
        <flux:input type="file" label="Imagen" wire:model.live="image" />
        <div class="flex items-center justify-start">
            {{-- Desactivamos mientras carga la imagen --}}
            <flux:button icon="plus" variant="primary" type="submit" class="cursor-pointer" wire:loading.attr="disabled">Crear Producto</flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('products.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>