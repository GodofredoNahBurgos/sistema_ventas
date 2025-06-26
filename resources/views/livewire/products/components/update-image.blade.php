<?php

use Livewire\Volt\Component;
use App\Models\Image;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;
    public $image_id;
    public $product_id;
    public $image;
    public $imageModel = null;
    public function mount(){
        if ($this->image_id > 0) {
            $this->imageModel = Image::find($this->image_id);
        }
    }
    public function changeImage(){
        $validation = $this->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    try {

        if (!$this->image || !$this->image->isValid()) {
                session()->flash('danger', __('Imagen inválida.'));
                return;
            }

            // Si hay imagen previa, la borramos
            if ($this->imageModel && Storage::disk('public')->exists($this->imageModel->path)) {
                Storage::disk('public')->delete($this->imageModel->path);
            }

            // Subir nueva imagen
            $path = $this->image->store('products', 'public');
            $nameImage = basename($path);

            // Si hay modelo existente, actualizamos; si no, creamos
            $imageModel = $this->imageModel ?? new Image(['product_id' => $this->product_id]);
            $imageModel->name = $nameImage;
            $imageModel->path = $path;
            $imageModel->save();

            session()->flash('success', __('La imagen se ha actualizado exitosamente.'));

    } catch (\Throwable $th) {
        session()->flash('danger', __('Error al actualizar la imagen: ') . $th->getMessage());
    }
    $this->reset();
    return redirect()->route('products.index');
        
    }
    public function uploadImage($product_id)
    {
        /* Guardamos la imagen. */
        $path = $this->image->store('products', 'public');
        $nameImage = basename($path);
        /* Guardamos la ruta de la imagen en la base de datos */
        $imageModel = new Image();
        $imageModel->name = $nameImage;
        $imageModel->product_id = $product_id;
        $imageModel->path = $path;
        $imageModel->save();
    }

}; ?>

<div>
    <flux:heading size="xl">Editar imagen de producto</flux:heading>
    <flux:text class="mt-2">Edición de imagen.</flux:text>
    <div class="flex gap-4">
        <div>
        <flux:label>Imagen Previa</flux:label>
        <div class="mt-2 border border-gray-400 h-28 w-28 flex items-center justify-center bg-gray-50"">
            @if ($this->image_id == 0)
                <span class=" italic">Sin imagen</span>
            @else
                <img src="{{ asset('storage/'.$this->imageModel->path) }}" alt="Imagen del producto" class="h-full max-w-full object-contain">
            @endif
        </div>
        </div>

        <div>
        <flux:label>Imagen Nueva</flux:label>
        <div class="mt-2 border border-gray-400 h-28 w-28 flex items-center justify-center bg-gray-50">
           @if ($this->image)
               <img src="{{ $this->image->temporaryUrl() }}" alt="Imagen del producto" class="h-full max-w-full object-contain">
           @else
               <span class=" italic">Sin imagen</span>
           @endif
        </div>
        </div>
    </div>
    
    <form wire:submit.prevent="changeImage" class="flex flex-col gap-6 mt-4" enctype="multipart/form-data">
        <flux:input type="file" label="Selecciona la nueva imagen" wire:model.live="image" />
        <div class="flex items-center justify-start">
            <flux:button icon="arrow-path" variant="primary" type="submit" class="cursor-pointer" wire:loading.attr="disabled">Actualizar
            </flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2">
                <a href="{{ route('products.index') }}">Cancelar</a>
            </flux:button>
        </div>
    </form>
</div>