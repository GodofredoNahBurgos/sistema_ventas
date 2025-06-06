@if ($users->isEmpty())
<tr>
    <td colspan="2" class="border border-gray-300 text-center">No hay categorias disponibles.</td>
</tr>
@else
@foreach ($users as $user)
<tr>
    <td class="border border-gray-300 text-center">{{ $user->email }}</td>
    <td class="border border-gray-300 text-center">{{ $user->name }}</td>
    <td class="border border-gray-300 text-center">{{ __(''.$user->role) }}</td>
    <td class="border border-gray-300 text-center">
        <flux:modal.trigger name="edit-password">
            <flux:button variant="primary" icon="key" class="my-2 cursor-pointer"
                wire:click="confirmChangePassword({{ $user->id }})">Cambiar Contraseña</flux:button>
        </flux:modal.trigger>
    </td>
    <td class="border border-gray-300 text-center">
        <flux:switch wire:model.change="userStates.{{ $user->id }}" />
    </td>
    <td class="border border-gray-300 text-center">
        <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
            wire:click="updateUser({{ $user->id }})">Editar</flux:button>
    </td>
</tr>
@endforeach
@endif