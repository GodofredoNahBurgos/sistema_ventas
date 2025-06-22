@php
    $products = $this->products_table;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead >
            <tr>
                <th class="border border-gray-300 text-center">Categoria</th>
                <th class="border border-gray-300 text-center">Proveedor</th>
                <th class="border border-gray-300 text-center">Nombre</th>
                <th class="border border-gray-300 text-center">Imagen</th>
                <th class="border border-gray-300 text-center">Descripción</th>
                <th class="border border-gray-300 text-center">Cantidad</th>
                <th class="border border-gray-300 text-center">Compra</th>
                <th class="border border-gray-300 text-center">Venta</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isEmpty())
            <tr>
                <td colspan="8" class="border border-gray-300 text-center">No hay productos disponibles.</td>
            </tr>
            @else
            @foreach ($products as $product)
            <tr>
                <td class="border border-gray-300 text-center">{{ $product->category_name }}</td>
                <td class="border border-gray-300 text-center">{{ $product->supplier_name }}</td>
                <td class="border border-gray-300 text-center">{{ $product->name }}</td>
                <td class="border border-gray-300 text-center">
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="Imagen del producto"
                        class="w-16 h-16 object-cover">
                </td>
                <td class="border border-gray-300 text-center">{{ $product->description }}</td>
                <td class="border border-gray-300 text-center">{{ $product->quantity }}</td>
                <td class="border border-gray-300 text-center">{{ $product->cost_price }}</td>
                <td class="border border-gray-300 text-center">{{ $product->sale_price }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-2">
        {{ $products->links() }}
    </div>
</div>