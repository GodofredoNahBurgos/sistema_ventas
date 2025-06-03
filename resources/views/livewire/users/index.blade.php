<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $users;
    public $selectedUserId = null;
    public $selectedUserName = null;

    public function mount()
    {
        $this->users = User::all();
    }

    public function confirmDelete($id)
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = User::find($id)->name;
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->users = User::all();
        }

        Flux::modal('delete-user')->close();

        session()->flash('messageDelete', 'Usuario eliminado correctamente.');

    }

    public function updateUser($id)
    {
        return redirect()->route('users.edit', ['id' => $id]);
    }
}; ?>

<div>
    <div class="flex flex-col">
        <flux:heading size="xl">Usuarios</flux:heading>
        <flux:text class="mt-2">Administrar los usuarios de la aplicacion.</flux:text>
        
        @if (session()->has('message'))
        <div class="w-80 m-2 ">
            <flux:callout variant="success" icon="check-circle" heading="{{ session('message') }}" />
        </div>
        @endif

        @if (session()->has('messageDelete'))
        <div class="w-80 m-2 ">
            <flux:callout variant="danger" icon="check-circle" heading="{{ session('messageDelete') }}" />
        </div>
        @endif

        <flux:button icon="plus" variant="primary" class="m-2 self-end">
            <a href="{{ route('users.create') }}" wire:navigate>{{ __('Crear Usuario') }}</a>
        </flux:button>
    </div>
    
    
    <flux:separator class="my-4" text="Tabla" />
    <div class="overflow-x-auto">
        <table class="table-fixed w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 text-center">Nombre</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="border border-gray-300 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                <tr>
                    <td colspan="2" class="border border-gray-300 text-center">No hay categorias disponibles.</td>
                </tr>
                @else
                @foreach ($users as $user)
                <tr>
                    <td class="border border-gray-300 text-center">{{ $user->name }}</td>
                    <td class="border border-gray-300 text-center">
                        <flux:button icon="pencil" class="my-2 cursor-pointer" variant="primary"
                            wire:click="updateCategory({{ $user->id }})">Editar</flux:button>
                        <flux:modal.trigger name="delete-category">
                            <flux:button wire:click="confirmDelete({{ $user->id }})" icon="trash" class="my-2 cursor-pointer" variant="danger">Eliminar
                            </flux:button>
                        </flux:modal.trigger>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <flux:modal name="delete-user" class="min-w-[22rem]">
        <div class="space-y-6">
            <div class="my-6">
                <flux:heading size="lg">¿Estás seguro de que deseas eliminar este usuario?</flux:heading>
                <flux:heading class="text-center text-red-600 mt-2" size="md">
                    {{$selectedUserName}}
                </flux:heading>
                <flux:text class="text-center mt-2">
                    <p>Estás a punto de eliminar este usuario.</p>
                    <p>Esta acción no se puede deshacer.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button class="cursor-pointer" icon="x-mark" variant="primary">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button class="cursor-pointer" icon="trash" variant="danger" wire:click="delete({{ $selectedUserId }})">Eliminar
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
