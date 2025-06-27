@php
    $total_general = 0;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <td class="border border-gray-300 text-center">Codigo</td>
                <td class="border border-gray-300 text-center">Nombre</td>
                <td class="border border-gray-300 text-center">Cantidad</td>
                <td class="border border-gray-300 text-center">Precio</td>
                <td class="border border-gray-300 text-center">Quitar</td>
            </tr>
        </thead>
        <tbody>
            @if (Session::has('items_cart') )
            @foreach (Session::get('items_cart') as $item_cart)
            <tr>
                <td class="border border-gray-300 text-center">{{ $item_cart['code'] }}</td>
                <td class="border border-gray-300 text-center">{{ $item_cart['name'] }} </td>
                <td class="border border-gray-300 text-center">{{ $item_cart['quantity'] }} </td>
                <td class="border border-gray-300 text-center">{{ '$'.number_format($item_cart['sale_price'], 2) }}</td>
                <td class="border border-gray-300 text-center">
                    <flux:button icon="trash" class="cursor-pointer" variant="danger"
                        wire:click="removeFromCart({{ $item_cart['id'] }})">Quitar 1</flux:button>
                </td>
            </tr>
            @php
                $total_product = $item_cart['sale_price'] * $item_cart['quantity'];
                $total_general += $total_product;
            @endphp
            @endforeach
            @else
            <tr>
                <td colspan="5" class="border border-gray-300 text-center">No hay productos disponibles.</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center">Total General:</td>
                <td class="text-center"><strong>{{ '$'.number_format($total_general, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>
</div>