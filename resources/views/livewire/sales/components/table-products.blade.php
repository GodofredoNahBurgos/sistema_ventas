<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <td class="border border-gray-300 text-center">Codigo</td>
                <td class="border border-gray-300 text-center">Nombre</td>
                <td class="border border-gray-300 text-center">Cantidad</td>
                <td class="border border-gray-300 text-center">Precio V.</td>
                <td class="border border-gray-300 text-center">Agregar</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($this->products as $product)
            <tr>
                <td class="border border-gray-300 text-center">{{ $product->code }}</td>
                <td class="border border-gray-300 text-center">{{ $product->name }} </td>
                <td class="border border-gray-300 text-center">{{ $product->quantity }} </td>
                <td class="border border-gray-300 text-center">{{ '$'.$product->sale_price }}</td>
                <td class="border border-gray-300 text-center">
                    <flux:button icon="plus" class="cursor-pointer" variant="primary"
                        wire:click="addToCart({{ $product->id }})">Agregar</flux:button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2">
        {{$this->products->links()}}
    </div>
</div>