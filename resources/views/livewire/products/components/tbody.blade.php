@if ($products->isEmpty())
<tr>
    <td colspan="7" class="border border-gray-300 text-center">No hay productos disponibles.</td>
</tr>
@else
@foreach ($products as $product)
<tr>
    <td class="border border-gray-300 text-center">{{ $product->name }}</td>
    <td class="border border-gray-300 text-center">{{ $product->description }}</td>
    <td class="border border-gray-300 text-center">{{ $product->quantity }}</td>
    <td class="border border-gray-300 text-center">{{ $product->cost_price }}</td>
    <td class="border border-gray-300 text-center">{{ $product->sale_price }}</td>
    <td class="border border-gray-300 text-center">{{ $product->image }}</td>
    <td class="border border-gray-300 text-center">{{ $product->active }}</td>
    <td class="border border-gray-300 text-center">
        <div class="flex justify-around gap-2">
            <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
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