<?php

use Livewire\Volt\Component;
use App\Models\Category;

new class extends Component {

    public $categories;
    public $selectedCategoryId = null;
    public $selectedCategoryName = null;

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function confirmDelete($id)
    {
        $this->selectedCategoryId = $id;
        $this->selectedCategoryName = Category::find($id)->name;
    }

    public function delete($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            $this->categories = Category::all();
        }

        Flux::modal('delete-category')->close();

        session()->flash('messageDelete', 'Categoria eliminada correctamente.');

    }

    public function updateCategory($id)
    {
        return redirect()->route('categories.edit', ['id' => $id]);
    }

}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Categorias</flux:heading>
        <flux:text class="mt-2">Administrar las categorias de nuestros productos.</flux:text>
        
        @if (session()->has('message'))
        <div class="w-80 m-2 ">
            <flux:callout variant="success" icon="check-circle" heading="{{ session('message') }}" />
        </div>
        @endif

        @if (session()->has('messageDelete'))
        <div class="w-80 m-2 ">
            <flux:callout variant="danger" icon="check-circle" heading="{{ session('messageDelete') }}" />
        </div>
        @endif

        <flux:button icon="plus" variant="primary" class="m-2 self-end">
            <a href="{{ route('categories.create') }}" wire:navigate>{{ __('Crear Categoria') }}</a>
        </flux:button>
    </div>
    <flux:separator class="my-4" text="Tabla" />
    <div class="overflow-x-auto">
        <table class="table-fixed w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 text-center">Nombre</th>
                    <th class="border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($categories->isEmpty())
                <tr>
                    <td colspan="2" class="border border-gray-300 text-center">No hay categorias disponibles.</td>
                </tr>
                @else
                @foreach ($categories as $category)
                <tr>
                    <td class="border border-gray-300 text-center">{{ $category->name }}</td>
                    <td class="border border-gray-300 text-center">
                        <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
                            wire:click="updateCategory({{ $category->id }})">Editar</flux:button>
                        <flux:modal.trigger name="delete-category">
                            <flux:button wire:click="confirmDelete({{ $category->id }})" icon="trash" class="my-2 cursor-pointer" variant="danger">Eliminar
                            </flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <flux:modal name="delete-category" class="min-w-[22rem]">
        <div class="space-y-6">
            <div class="my-6">
                <flux:heading size="lg">¿Estás seguro de que deseas eliminar esta categoría?</flux:heading>
                <flux:heading class="text-center text-red-600 mt-2" size="md">
                    {{$selectedCategoryName}}
                </flux:heading>
                <flux:text class="text-center mt-2">
                    <p>Estás a punto de eliminar esta categoría.</p>
                    <p>Esta acción no se puede deshacer.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button class="cursor-pointer" icon="x-mark" variant="primary">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button class="cursor-pointer" icon="trash" variant="danger" wire:click="delete({{ $selectedCategoryId }})">Eliminar
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>