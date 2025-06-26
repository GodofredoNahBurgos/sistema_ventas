<?php

use Livewire\Volt\Component;
use App\Models\Purchase;
use App\Models\Product;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $selectedPurchaseId = null;
    public $selectedPurchaseDate = null;
    public $selectedPurchaseProduct = null;
    public $search = '';
    
    public function getPurchasesProperty()
    {
        return Purchase::select(
            'purchases.*',
            'users.name as user_name',
            'products.name as product_name',
        )
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->join('products', 'purchases.product_id', '=', 'products.id')
        ->where('purchases.created_at', 'like', '%' . $this->search . '%')
        ->paginate(5);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatePurchase($id){
        return redirect()->route('purchases.edit', ['id' => $id]);
    }
    public function confirmDelete($id){
        $this->selectedPurchaseId = $id;
        $this->selectedPurchaseDate = Purchase::find($id)->created_at;
        $this->selectedPurchaseProduct = Product::find(Purchase::find($id)->product_id)->name;
    }
    public function delete($id){
        try {
            $purchase = Purchase::find($id);
            $product = Product::find($purchase->product_id);
            if ($product->quantity >= $purchase->quantity) {
                $product->quantity = ($product->quantity - $purchase->quantity);
                $product->save();
                $purchase->delete();
            } else {
                session()->flash('danger', 'No hay suficiente stock para eliminar la compra.');
            }
            session()->flash('success', 'Compra eliminada exitosamente.');
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al eliminar la compra: ' . $th->getMessage());
        }
        Flux::modal('delete-purchase')->close();
        $this->reset('selectedPurchaseId', 'selectedPurchaseDate', 'selectedPurchaseProduct');
        $this->resetPage();
    }
    public function resetSelectedPurchase(){
        $this->reset('purchaseSelected');
    }
}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Compras de productos</flux:heading>
            <flux:text class="mt-2">Administrar compras de productos.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Compras" placeholder="Ingrese fecha de compra" size="30"
                wire:model.live="search"></flux:input>
        </div>
    </div>
    @include('livewire.products.components.messages')
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.purchases.components.table')
    @include('livewire.purchases.components.modal-delete')
</div>