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
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                $this->categories = Category::all();
            }
            Flux::modal('delete-category')->close();
            session()->flash('danger', 'Categoria eliminada correctamente.');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar la categoria: ' . $th->getMessage());
        }
        $this->selectedCategoryId = null;
        $this->selectedCategoryName = null;
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

        <div class="m-2 w-full h-16 flex justify-end">
            @include('livewire.categories.components.messages')
            <flux:button icon="plus" variant="primary" class="m-2 self-end">
                <a href="{{ route('categories.create') }}" wire:navigate>{{ __('Crear Categoria') }}</a>
            </flux:button>
        </div>
    </div>

    <flux:separator class="my-4" text="Datos" />

    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Nombre</th>
                    <th class="border border-gray-300 text-center w-96 ">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @include('livewire.categories.components.tbody')
            </tbody>
        </table>
    </div>

    @include('livewire.categories.components.modal-delete')

</div>