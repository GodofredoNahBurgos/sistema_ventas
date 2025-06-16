@if ($purchases->isEmpty())
<tr>
    <td colspan="11" class="border border-gray-300 text-center">No hay compras disponibles.</td>
</tr>
@else
@foreach ($purchases as $purchase)
<tr>
    <td class="border border-gray-300 text-center">{{ $purchase->user_name }}</td>
    <td class="border border-gray-300 text-center">{{ $purchase->product_name }}</td>
    <td class="border border-gray-300 text-center">{{ $purchase->quantity }}</td>
    <td class="border border-gray-300 text-center">{{ '$'.$purchase->cost_price }}</td>
    <td class="border border-gray-300 text-center">{{ '$'.($purchase->cost_price * $purchase->quantity) }}</td>
    <td class="border border-gray-300 text-center">{{ $purchase->created_at }}</td>
    <td class="border border-gray-300 text-center">
        <div class="flex justify-around gap-2">
            <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                wire:click="updatePurchase({{ $purchase->id }})">Editar</flux:button>
            <flux:modal.trigger name="delete-product">
                <flux:button wire:click="confirmDelete({{ $purchase->id }})" icon="trash" class="my-2 cursor-pointer"
                    variant="danger">Eliminar
                </flux:button>
            </flux:modal.trigger>
        </div>
    </td>
</tr>
@endforeach
@endif