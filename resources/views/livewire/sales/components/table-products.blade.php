@php
    $products = $this->products;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <td class="border border-gray-300 text-center">Codigo</td>
                <td class="border border-gray-300 text-center">Nombre</td>
                <td class="border border-gray-300 text-center">Cantidad</td>
                <td class="border border-gray-300 text-center">Precio</td>
                <td class="border border-gray-300 text-center">Agregar</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td class="border border-gray-300 text-center">{{ $product->code }}</td>
                <td class="border border-gray-300 text-center">{{ $product->name }} </td>
                <td class="border border-gray-300 text-center">{{ $product->quantity }} </td>
                <td class="border border-gray-300 text-center">{{ '$'.number_format($product->sale_price, 2) }}</td>
                <td class="border border-gray-300 text-center">
                    @if ($product->quantity > 0)
                    <flux:button icon="plus" class="cursor-pointer" variant="primary"
                        wire:click="addToCart({{ $product->id }})">Agregar</flux:button>
                    @else
                    <flux:button icon="plus" class="cursor-pointer" variant="primary"
                        disabled>Agregar</flux:button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2">
        {{$products->links()}}
    </div>
</div>