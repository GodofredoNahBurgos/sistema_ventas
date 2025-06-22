<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    
    public $name;
    public int $id;

    public function mount()
    {
        $category = Category::find($this->id);
        $this->name = $category->name;
    }

    public function updateCategory()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
        ]);
        
        try {
            $category = Category::find($this->id);
            $category->fill($validated);
            $category->save();
            session()->flash('success', 'Categoria actualizada exitosamente.');
            $this->reset();
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al actualizar la categoria: ' . $th->getMessage());
            $this->reset();
            return redirect()->route('categories.index');
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Actualizar Categoria</flux:heading>
    <flux:text class="mt-2">Actualiza las categorias de nuestros productos.</flux:text>
    <form wire:submit.prevent="updateCategory" class="mt-4">
        {{-- Aca se pondria el CRF --}}
        {{-- Se pondria PUT --}}
        <flux:input type="text" label="{{__('Nombre')}}" wire:model.defer="name" value="{{ $name }}" />
        <flux:button icon="arrow-path" variant="primary" type="submit" class="mt-4 cursor-pointer" wire:loading.attr="disabled">Actualizar Categoria</flux:button>
        <flux:button icon="x-mark" variant="danger" type="button" class="mt-4"><a
                href="{{ route('categories.index') }}">Cancelar</a></flux:button>
    </form>
</div>