@php
    $categories = $this->categories;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="">
            <tr>
                <th class="border border-gray-300 text-center">Nombre</th>
                <th class="border border-gray-300 text-center w-96 ">Acciones</th>
            </tr>
        </thead>
        <tbody>
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
                        <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                            wire:click="updateCategory({{ $category->id }})">Editar</flux:button>
                        <flux:modal.trigger name="delete-category">
                            <flux:button wire:click="confirmDelete({{ $category->id }})" icon="trash"
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
        {{$categories->links()}}
    </div>
</div>