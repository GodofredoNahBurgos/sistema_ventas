@if ($suppliers->isEmpty())
<tr>
    <td colspan="7" class="border border-gray-300 text-center">No hay proveedores disponibles.</td>
</tr>
@else
@foreach ($suppliers as $supplier)
<tr>
    <td class="border border-gray-300 text-center">{{ $supplier->name }}</td>
    <td class="border border-gray-300 text-center">{{ $supplier->phone }}</td>
    <td class="border border-gray-300 text-center">{{ $supplier->email }}</td>
    <td class="border border-gray-300 text-center">{{ $supplier->cp }}</td>
    <td class="border border-gray-300 text-center">{{ $supplier->website }}</td>
    <td class="border border-gray-300 text-center">{{ $supplier->notes }}</td>
    <td class="border border-gray-300 text-center">
        <div class="flex justify-around gap-2">
            <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
                wire:click="updateSupplier({{ $supplier->id }})">Editar</flux:button>
            <flux:modal.trigger name="delete-supplier">
                <flux:button wire:click="confirmDelete({{ $supplier->id }})" icon="trash" class="my-2 cursor-pointer"
                    variant="danger">Eliminar
                </flux:button>
            </flux:modal.trigger>
        </div>
    </td>
</tr>
@endforeach
@endif