@php
$details = $this->details;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="">
            <tr>
                <th class="border border-gray-300 text-center">Producto</th>
                <th class="border border-gray-300 text-center">Cantdad</th>
                <th class="border border-gray-300 text-center">Precio Unitario</th>
                <th class="border border-gray-300 text-center">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @if ($details->isEmpty())
            <tr>
                <td colspan="4" class="border border-gray-300 text-center">No hay venta disponibles.</td>
            </tr>
            @else
            @foreach ($details as $detail)
            <tr>
                <td class="border border-gray-300 text-center">{{ $detail->product_name }}</td>
                <td class="border border-gray-300 text-center">{{ $detail->quantity }}</td>
                <td class="border border-gray-300 text-center">{{ number_format($detail->unit_price, 2) }}</td>
                <td class="border border-gray-300 text-center">{{ number_format($detail->sub_total, 2) }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>