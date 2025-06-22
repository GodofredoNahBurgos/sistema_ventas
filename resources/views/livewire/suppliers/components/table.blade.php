@php
    $suppliers = $this->suppliers;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 text-center">Nombre</th>
                <th class="border border-gray-300 text-center">Teléfono</th>
                <th class="border border-gray-300 text-center">Correo Electrónico</th>
                <th class="border border-gray-300 text-center">CP</th>
                <th class="border border-gray-300 text-center">Sitio web</th>
                <th class="border border-gray-300 text-center">Notas</th>
                <th class="border border-gray-300 text-center">Acciónes</th>
            </tr>
        </thead>
        <tbody>
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
                        <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                            wire:click="updateSupplier({{ $supplier->id }})">Editar</flux:button>
                        <flux:modal.trigger name="delete-supplier">
                            <flux:button wire:click="confirmDelete({{ $supplier->id }})" icon="trash"
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
        {{$suppliers->links()}}
    </div>
</div>