<?php

use Livewire\Volt\Component;
use App\Models\Category;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $selectedCategoryId = null;
    public $selectedCategoryName = null;

    public function getCategoriesProperty()
    {
        return Category::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(5);
    }
    public function updatedSearch()
    {
        $this->resetPage();
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
            }
            Flux::modal('delete-category')->close();
            session()->flash('danger', 'Categoria eliminada correctamente.');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar la categoria: ' . $th->getMessage());
        }
        $this->resetSelectedCategory();
        $this->resetPage();
    }
    public function resetSelectedCategory()
    {
        $this->reset('selectedCategoryName', 'selectedCategoryId');
    }
    public function updateCategory($id)
    {
        return redirect()->route('categories.edit', ['id' => $id]);
    }
}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Categorias</flux:heading>
            <flux:text class="mt-2">Administrar las categorias de nuestros productos.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Categorias" size="30"
                wire:model.live="search"></flux:input>
            <div class="pt-6">
                <flux:button icon="plus" variant="primary">
                    <a href="{{ route('categories.create') }}">{{ __('Crear Categoria') }}</a>
                </flux:button>
            </div>
        </div>
    </div>
    @include('livewire.categories.components.messages')
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.categories.components.table')
    @include('livewire.categories.components.modal-delete')
</div>