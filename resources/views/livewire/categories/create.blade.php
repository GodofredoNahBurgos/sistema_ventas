<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {

    public $name;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        try {

            Category::create([
                'name' => $this->name,
                'user_id' => auth()->id()
            ]);

            session()->flash('success', 'Categoria creada exitosamente.');
            $this->reset();
            return redirect()->route('categories.index');

        } catch (\Throwable $th) {

            session()->flash('danger', 'Error al crear la categoria: ' . $th->getMessage());
            $this->reset();
            return redirect()->route('categories.index');
            
        }   
    }
}; ?>

<div>
    <flux:heading size="xl">Crear Categoria</flux:heading>
    <flux:text class="mt-2">Crea las categorias de nuestros productos.</flux:text>
    <form wire:submit.prevent="submit" class="mt-4">
        {{-- Aca se pondria el CRF --}}
        <flux:input type="text" label="{{__('Nombre')}}" wire:model.defer="name" />
        <flux:button icon="plus" variant="primary" type="submit" class="mt-4 cursor-pointer" wire:loading.attr="disabled">Crear Categoria</flux:button>
        <flux:button icon="x-mark" variant="danger" type="button" class="mt-4" ><a href="{{ route('categories.index') }}">Cancelar</a></flux:button>
    </form>
</div>
