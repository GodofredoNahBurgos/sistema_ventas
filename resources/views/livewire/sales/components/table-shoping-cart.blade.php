<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <td class="border border-gray-300 text-center">Codigo</td>
                <td class="border border-gray-300 text-center">Nombre</td>
                <td class="border border-gray-300 text-center">Cantidad</td>
                <td class="border border-gray-300 text-center">Precio V.</td>
                <td class="border border-gray-300 text-center">Quitar</td>
            </tr>
        </thead>
        <tbody>
            @php
                $total_general = 0;
            @endphp
            @if (Session::has('items_cart') )
            @foreach (Session::get('items_cart') as $item_cart)
            @php
                $total_product = $item_cart['sale_price'] * $item_cart['quantity'];
                $total_general += $total_product;
            @endphp
            <tr>
                <td class="border border-gray-300 text-center">{{ $item_cart['code'] }}</td>
                <td class="border border-gray-300 text-center">{{ $item_cart['name'] }} </td>
                <td class="border border-gray-300 text-center">{{ $item_cart['quantity'] }} </td>
                <td class="border border-gray-300 text-center">{{ '$'.$item_cart['sale_price'] }}</td>
                <td class="border border-gray-300 text-center">
                    <flux:button icon="trash" class="cursor-pointer" variant="danger"
                        wire:click="removeFromCart({{ $item_cart['id'] }})">Quitar 1</flux:button>
                </td>
            </tr>
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
                <td class="text-center"><strong>{{ '$'.$total_general }}</strong></td>
            </tr>
        </tfoot>
    </table>
</div>