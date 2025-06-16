@if ($products->isEmpty())
<tr>
    <td colspan="11" class="border border-gray-300 text-center">No hay productos disponibles.</td>
</tr>
@else
@foreach ($products as $product)
<tr>
    <td class="border border-gray-300 text-center">{{ $product->code }}</td>
    <td class="border border-gray-300 text-center">{{ $product->category_name }}</td>
    <td class="border border-gray-300 text-center">{{ $product->supplier_name }}</td>
    <td class="border border-gray-300 text-center">{{ $product->name }}</td>
    <td class="border border-gray-300 text-center">
        <img src="{{ asset('storage/'.$product->image_path) }}" alt="Imagen del producto" class="w-16 h-16 object-cover">
        <flux:badge class="cursor-pointer" icon="pencil-square" color="blue" size="sm" wire:click="updateImage({{ $product->image_id }})" ></flux:badge>
    </td>
    <td class="border border-gray-300 text-center">{{ $product->description }}</td>
    <td class="border border-gray-300 text-center">{{ $product->quantity }}</td>
    <td class="border border-gray-300 text-center">{{ '$'.$product->cost_price }}</td>
    <td class="border border-gray-300 text-center">{{ '$'.$product->sale_price }}</td>
    <td class="border border-gray-300 text-center">
        <flux:switch wire:model.change="productStates.{{ $product->id }}" />
    </td>
    <td class="border border-gray-300 text-center">
        <flux:button icon="shopping-cart" class="cursor-pointer" variant="primary"><a href="{{route('purchases.create', ['product_id' => $product->id])}}">Comprar</a></flux:button>
    </td>
    <td class="border border-gray-300 text-center">
        <div class="flex justify-around gap-2">
            <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                wire:click="updateProduct({{ $product->id }})">Editar</flux:button>
            <flux:modal.trigger name="delete-product">
                <flux:button wire:click="confirmDelete({{ $product->id }})" icon="trash" class="my-2 cursor-pointer"
                    variant="danger">Eliminar
                </flux:button>
            </flux:modal.trigger>
        </div>
    </td>
</tr>
@endforeach
@endif