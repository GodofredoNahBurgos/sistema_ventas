<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $users;
    public $selectedUserId;
    public $selectedUserName;
    public $userStates = [];
    public $password;

    public function mount()
    {
        $this->users = User::all();

        foreach ($this->users as $user) {
            if ($user->active) {
                $this->userStates[$user->id] = true;
            }else{
                $this->userStates[$user->id] = false;
            }
        }
    }

    public function confirmChangePassword($id)
    {
        $this->selectedUserId = $id;
        $this->selectedUserName = User::find($id)->name;
    }

    public function changePassword($id)
    {
        $validated = $this->validate([
            'password' =>  ['required', 'string', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        try {
            $user = User::find($id);
            if ($user) {
                $user->password = $validated['password'];
                $user->save();
            }
            Flux::modal('edit-password')->close();
            session()->flash('success', 'Contraseña actualizada correctamente.');
            $this->password = '';            
        } catch (\Throwable $th) {
            Flux::modal('edit-password')->close();
            session()->flash('danger', 'Error al actualizar la contraseña: ' . $th->getMessage());
            $this->password = '';
        }
        $this->selectedUserId = null;
        $this->selectedUserName = null;
    }

    public function updateUser($id)
    {
        return redirect()->route('users.edit', ['id' => $id]);
    }

    public function updatedUserStates($value, $key)
    {
         try {
            $user = User::find($key);
            if ($user) {
                $user->active = $value;
                $user->save();
                if ($value) {
                    session()->flash('success', 'Usuario activado correctamente.');
                } else {
                    session()->flash('danger', 'Usuario desactivado correctamente.');
        }
    }
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al actualizar el estado del usuario: ' . $th->getMessage());
        }
    
    }

}; ?>

<div>
    
    <div class="flex flex-col">
        <flux:heading size="xl">Usuarios</flux:heading>
        <flux:text class="mt-2">Administrar los usuarios de la aplicacion.</flux:text>
        <div class="m-2 w-full h-16 flex justify-end">
            @include('livewire.users.components.messages')
            <flux:button icon="user-plus" variant="primary" class="m-2 self-end">
                <a href="{{ route('users.create') }}" wire:navigate>{{ __('Crear Usuario') }}</a>
            </flux:button>
        </div>
    </div>

    <flux:separator class="my-4" text="Datos" />

    <div class="overflow-x-auto">
        <table class="table-auto w-full">
            <thead class="">
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
                @include('livewire.users.components.tbody')
            </tbody>
        </table>
    </div>

    @include('livewire.users.components.modal-password')

</div>