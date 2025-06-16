<?php

use Livewire\Volt\Component;
use App\Models\Image;
use Livewire\WithFileUploads; 
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithFileUploads;
    public $image_id;
    public $image;
    public $imageModel;
    public function mount(){
        $this->imageModel = Image::find($this->image_id);
        /* dd($this->imageModel); */
    }
    public function changeImage(){
        try {
            $this->imageModel = Image::find($this->image_id);
            if ($this->imageModel->path && Storage::disk('public')->exists($this->imageModel->path)) {
                Storage::disk('public')->delete($this->imageModel->path);
            }
            $path = $this->image->store('products', 'public');
            $nameImage = basename($path);

            $this->imageModel->name = $nameImage;
            $this->imageModel->path = $path;
            $this->imageModel->save();
            return redirect()->route('products.index')->with('success', 'Imagen actualizada exitosamente.');
        } catch (\Throwable $th) {
            return redirect()->route('products.index')->with('danger', 'Error al actualizar la imagen: ' . $th->getMessage());
        }
        
    }

}; ?>

<div>
    <flux:heading size="xl">Editar imagen de producto.</flux:heading>
    <flux:text class="mt-2">Edición de imagen.</flux:text>
    <img src="{{ asset('storage/'.$this->imageModel->path) }}" alt="Imagen del producto" class="h-16">
    <form wire:submit.prevent="changeImage" class="flex flex-col gap-6 mt-4" enctype="multipart/form-data">
        <flux:input type="file" label="Selecciona la nueva imagen" wire:model.live="image" />
        <div class="flex items-center justify-start">
            <flux:button icon="arrow-path" variant="primary" type="submit" class="cursor-pointer">Actualizar
            </flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a
                    href="{{ route('products.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>