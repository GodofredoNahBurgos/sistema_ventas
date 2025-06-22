@if ($this->sales->isEmpty())
<tr>
    <td colspan="5" class="border border-gray-300 text-center">No hay ventas disponibles.</td>
</tr>
@else
@foreach ($this->sales as $sale)
<tr>
    <td class="border border-gray-300 text-center">{{ $sale->id }}</td>
    <td class="border border-gray-300 text-center">{{ '$'.$sale->total_sale }}</td>
    <td class="border border-gray-300 text-center">{{ $sale->created_at }}</td>
    <td class="border border-gray-300 text-center">{{ $sale->user_name }}</td>
    <td class="border border-gray-300 text-center">
        <flux:button wire:click="detailSale({{ $sale->id }})" icon="clipboard-document-list" class="my-2 cursor-pointer"
            variant="primary">Detalle</flux:button>
    </td>
    <td class="border border-gray-300 text-center">
        <flux:button href="{{route('ticket.pdf', ['sale_id' => $sale->id])}}" target="_blank" {{-- wire:click="printTicket({{ $sale->id }})" --}} icon="printer" class="my-2 cursor-pointer" variant="primary">Imprimir   
    </flux:button>
    </td>
    <td class="border border-gray-300 text-center">
        <flux:modal.trigger name="sale-revoker">
            <flux:button wire:click="confirmRevoke({{ $sale->id }})" icon="trash" class="my-2 cursor-pointer"
                variant="danger">Revocar
            </flux:button>
        </flux:modal.trigger>
    </td>
</tr>
@endforeach
@endif