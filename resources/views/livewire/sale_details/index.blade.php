<?php

use Livewire\Volt\Component;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;
use Illuminate\Http\Response;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $sale;
    public $selectedSaleId;
    
    public function getSalesProperty()
    {
        return Sale::select(
            'sales.*',
            'users.name as user_name',
        )
        ->join('users', 'sales.user_id', '=', 'users.id')
        ->where('sales.created_at', 'like', '%' . $this->search . '%')
        ->orderBy('sales.created_at', 'desc')
        ->paginate(5);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function detailSale($id){
        return redirect()->route('sale_details.sale_detail', ['sale_id' => $id]);
    }
    public function confirmRevoke($id){
        $this->selectedSaleId = $id;
    }
    public function revoke($id)
    {
        DB::beginTransaction();
        try {
            $detailsSelect = SaleDetails::select('product_id', 'quantity')
            ->where('sale_id', '=', $id)
            ->get();
            /* Devolver el stock */
            foreach ($detailsSelect as $detail) {
                $product = Product::where('id',$detail->product_id)
                ->increment('quantity', $detail->quantity);
            }
            /* Eliminar productos */
            SaleDetails::where('sale_id', $id)->delete();
            Sale::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('sale_details.index')->with('success', 'Venta revocada exitosamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('sale_details.index')->with('danger', 'Error al revocar la venta: ' . $th->getMessage());
        }
    }

}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Consulta de Ventas</flux:heading>
            <flux:text class="mt-2">Revisar ventas existentes.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Ventas" placeholder="Ingrese fecha de venta" size="30"
                wire:model.live="search"></flux:input>
        </div>
    </div>
    @include('livewire.sale_details.components.messages')
    <flux:separator class="my-4" text="Datos" />
    @include('livewire.sale_details.components.table')
    @include('livewire.sale_details.components.modal-revoke')
</div>