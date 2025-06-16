@if ($products->isEmpty())
<tr>
    <td colspan="11" class="border border-gray-300 text-center">No hay productos disponibles.</td>
</tr>
@else
@foreach ($products as $product)
<tr>
    <td class="border border-gray-300 text-center">{{ $product->category_name }}</td>
    <td class="border border-gray-300 text-center">{{ $product->supplier_name }}</td>
    <td class="border border-gray-300 text-center">{{ $product->name }}</td>
    <td class="border border-gray-300 text-center">
        <img src="{{ asset('storage/'.$product->image_path) }}" alt="Imagen del producto" class="w-16 h-16 object-cover">
    </td>
    <td class="border border-gray-300 text-center">{{ $product->description }}</td>
    <td class="border border-gray-300 text-center">{{ $product->quantity }}</td>
    <td class="border border-gray-300 text-center">{{ $product->cost_price }}</td>
    <td class="border border-gray-300 text-center">{{ $product->sale_price }}</td>
</tr>
@endforeach
@endif