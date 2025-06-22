<?php

use Livewire\Volt\Component;
use App\Models\Supplier;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $selectedSupplierId = null;
    public $selectedSupplierName = null;
    /* Getter */
    public function getSuppliersProperty()
    {
        return Supplier::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->paginate(5);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updateSupplier($id){
        return redirect()->route('suppliers.edit', ['id' => $id]);
    }
    public function confirmDelete($id){
        $this->selectedSupplierId = $id;
        $this->selectedSupplierName = Supplier::find($id)->name;
    }
    public function resetSelectedSupplier()
    {
        $this->reset('selectedSupplierId', 'selectedSupplierName');
    }
    public function delete($id){
        try {
            $supplier = Supplier::find($id);
            if ($supplier) {
                $supplier->delete();
            }
            Flux::modal('delete-supplier')->close();
            session()->flash('danger', 'Proveedor eliminado correctamente.');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar el proveedor: ' . $th->getMessage());
        }
        $this->resetSelectedSupplier();
        $this->resetPage();
    }
}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Proveedores</flux:heading>
            <flux:text class="mt-2">Administrar los proveedores de nuestros productos.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Proveedores" size="30" wire:model.live="search"></flux:input>
            <div class="pt-6">
                <flux:button icon="plus" variant="primary" >
                    <a href="{{ route('suppliers.create') }}">{{ __('Crear Proveedor') }}</a>
                </flux:button>
            </div>
        </div>
    </div>
@include('livewire.suppliers.components.messages')
<flux:separator class="my-4" text="Datos" />
@include('livewire.suppliers.components.table')
@include('livewire.suppliers.components.modal-delete')
</div>