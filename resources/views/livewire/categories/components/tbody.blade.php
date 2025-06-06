@if ($categories->isEmpty())
<tr>
    <td colspan="2" class="border border-gray-300 text-center">No hay categorias disponibles.</td>
</tr>
@else
@foreach ($categories as $category)
<tr>
    <td class="border border-gray-300 text-center">{{ $category->name }}</td>
    <td class="border border-gray-300 text-center">
        <div class="flex justify-around gap-2">
            <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
                wire:click="updateCategory({{ $category->id }})">Editar</flux:button>
            <flux:modal.trigger name="delete-category">
                <flux:button wire:click="confirmDelete({{ $category->id }})" icon="trash" class="my-2 cursor-pointer"
                    variant="danger">Eliminar
                </flux:button>
            </flux:modal.trigger>
        </div>
    </td>
</tr>
@endforeach
@endif