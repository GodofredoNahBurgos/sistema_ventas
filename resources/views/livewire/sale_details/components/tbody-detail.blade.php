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
</tr>
@endforeach
@endif