@if ($this->details->isEmpty())
<tr>
    <td colspan="5" class="border border-gray-300 text-center">No hay venta disponibles.</td>
</tr>
@else
@foreach ($this->details as $detail)
<tr>
    <td class="border border-gray-300 text-center">{{ $detail->product_name }}</td>
    <td class="border border-gray-300 text-center">{{ $detail->quantity }}</td>
    <td class="border border-gray-300 text-center">{{ $detail->unit_price }}</td>
    <td class="border border-gray-300 text-center">{{ $detail->sub_total }}</td>
    <td class="border border-gray-300 text-center">
        <flux:button icon="trash" class="my-2 cursor-pointer" variant="danger">Revocar</flux:button>
    </td>
</tr>
@endforeach
@endif