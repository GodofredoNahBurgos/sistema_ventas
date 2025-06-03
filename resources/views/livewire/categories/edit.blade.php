<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {
    
    public $name;
    public $id;

    public function mount($id)
    {
        $category = Category::find($id);
        $this->name = $category->name;
        $this->id = $category->id;
    }

    public function updateCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($this->id);
        $category->name = $this->name;
        $category->save();
        session()->flash('message', 'Categoria actualizada exitosamente.');
        return redirect()->route('categories.index');
    }
}; ?>

<div>
    <flux:heading size="xl">Actualizar Categoria</flux:heading>
    <flux:text class="mt-2">Actualiza las categorias de nuestros productos.</flux:text>
    <form wire:submit.prevent="updateCategory" class="mt-4">
        {{-- Aca se pondria el CRF --}}
        {{-- Se pondria PUT --}}
        <flux:input type="text" label="{{__('Nombre')}}" wire:model="name" value="{{ $name }}" />
        <flux:button icon="plus" variant="primary" type="submit" class="mt-4 cursor-pointer">Actualizar Categoria</flux:button>
        <flux:button icon="x-mark" variant="danger" type="button" class="mt-4"><a
                href="{{ route('categories.index') }}">Cancelar</a></flux:button>
    </form>
</div>