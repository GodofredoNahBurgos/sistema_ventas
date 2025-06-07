<?php

use Livewire\Volt\Component;
use App\Models\Supplier;

new class extends Component {
    public $suppliers;
    public $selectedSupplierId = null;
    public $selectedSupplierName = null;
    public function mount(){
        $this->suppliers = Supplier::all();
    }
    public function updateSupplier($id){
        return redirect()->route('suppliers.edit', ['id' => $id]);
    }
    public function confirmDelete($id){
        $this->selectedSupplierId = $id;
        $this->selectedSupplierName = Supplier::find($id)->name;
    }
    public function delete($id){
        try {
            $supplier = Supplier::find($id);
            if ($supplier) {
                $supplier->delete();
                $this->suppliers = Supplier::all();
            }
            Flux::modal('delete-supplier')->close();
            session()->flash('danger', 'Proveedor eliminado correctamente.');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar el proveedor: ' . $th->getMessage());
        }
        $this->selectedSupplierId = null;
        $this->selectedSupplierName = null;
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Proveedores</flux:heading>
        <flux:text class="mt-2">Administrar los proveedores de nuestros productos.</flux:text>
        <div class="m-2 w-full h-16 flex justify-end">
            @include('livewire.suppliers.components.messages')
            <flux:button icon="plus" variant="primary" class="m-2 self-end">
                <a href="{{ route('suppliers.create') }}" wire:navigate>{{ __('Crear Proveedor') }}</a>
            </flux:button>
        </div>
    </div>
    <flux:separator class="my-4" text="Datos" />
    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
                <tr>
                    <th class="border border-gray-300 text-center">Nombre</th>
                    <th class="border border-gray-300 text-center">Teléfono</th>
                    <th class="border border-gray-300 text-center">Correo Electrónico</th>
                    <th class="border border-gray-300 text-center">CP</th>
                    <th class="border border-gray-300 text-center">Sitio web</th>
                    <th class="border border-gray-300 text-center">Notas</th>
                    <th class="border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @include('livewire.suppliers.components.tbody')
            </tbody>
        </table>
    </div>
    @include('livewire.suppliers.components.modal-delete')
</div>