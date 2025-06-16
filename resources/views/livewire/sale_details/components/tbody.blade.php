@if ($this->sales->isEmpty())
<tr>
    <td colspan="5" class="border border-gray-300 text-center">No hay ventas disponibles.</td>
</tr>
@else
@foreach ($this->sales as $sale)
<tr>
    <td class="border border-gray-300 text-center">{{ '$'.$sale->total_sale }}</td>
    <td class="border border-gray-300 text-center">{{ $sale->created_at }}</td>
    <td class="border border-gray-300 text-center">{{ $sale->user_name }}</td>
    <td class="border border-gray-300 text-center">
        <flux:button wire:click="detailSale({{ $sale->id }})" icon="clipboard-document-list" class="my-2 cursor-pointer" variant="primary">Detalle</flux:button>
    </td>
    <td class="border border-gray-300 text-center">
        <flux:button icon="trash" class="my-2 cursor-pointer" variant="danger">Revocar</flux:button>
    </td>
</tr>
@endforeach
@endif