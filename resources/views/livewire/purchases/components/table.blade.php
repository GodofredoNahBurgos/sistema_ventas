@php
    $purchases = $this->purchases;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 text-center">Usuario</th>
                <th class="border border-gray-300 text-center">Producto</th>
                <th class="border border-gray-300 text-center">Cantidad</th>
                <th class="border border-gray-300 text-center">Precio de compra</th>
                <th class="border border-gray-300 text-center">Total</th>
                <th class="border border-gray-300 text-center">Fecha</th>
                <th class="border border-gray-300 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($purchases->isEmpty())
            <tr>
                <td colspan="7" class="border border-gray-300 text-center">No hay compras disponibles.</td>
            </tr>
            @else
            @foreach ($purchases as $purchase)
            <tr>
                <td class="border border-gray-300 text-center">{{ $purchase->user_name }}</td>
                <td class="border border-gray-300 text-center">{{ $purchase->product_name }}</td>
                <td class="border border-gray-300 text-center">{{ $purchase->quantity }}</td>
                <td class="border border-gray-300 text-center">{{ '$'.$purchase->cost_price }}</td>
                <td class="border border-gray-300 text-center">{{ '$'.($purchase->cost_price * $purchase->quantity) }}
                </td>
                <td class="border border-gray-300 text-center">{{ $purchase->created_at }}</td>
                <td class="border border-gray-300 text-center">
                    <div class="flex justify-around gap-2">
                        <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                            wire:click="updatePurchase({{ $purchase->id }})">Editar</flux:button>
                        <flux:modal.trigger name="delete-purchase">
                            <flux:button wire:click="confirmDelete({{ $purchase->id }})" icon="trash"
                                class="my-2 cursor-pointer" variant="danger">Eliminar
                            </flux:button>
                        </flux:modal.trigger>
                    </div>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-2">
        {{ $purchases->links() }}
    </div>
</div>