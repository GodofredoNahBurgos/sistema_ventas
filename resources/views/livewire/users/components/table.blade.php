@php
    $users = $this->users;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 text-center px-2">Correo</th>
                <th class="border border-gray-300 text-center px-2">Nombre</th>
                <th class="border border-gray-300 text-center px-2">Rol</th>
                <th class="border border-gray-300 text-center px-2">Cambiar Contraseña</th>
                <th class="border border-gray-300 text-center px-2">Activo</th>
                <th class="border border-gray-300 text-center px-2">Editar</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isEmpty())
            <tr>
                <td colspan="6" class="border border-gray-300 text-center">No hay usuarios disponibles.</td>
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
                    @if ($user->active)
                    <flux:switch checked wire:click="updateUserState({{ $user->id }})" class="cursor-pointer" />
                    @elseif(!$user->active)
                    <flux:switch  wire:click="updateUserState({{ $user->id }})" class="cursor-pointer" />
                    @endif 
                </td>
                <td class="border border-gray-300 text-center">
                    <flux:button icon="pencil-square" class="my-2 cursor-pointer" variant="primary"
                        wire:click="updateUser({{ $user->id }})">Editar</flux:button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-2">
        {{$users->links()}}
    </div>
</div>