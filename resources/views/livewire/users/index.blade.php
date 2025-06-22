<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $selectedUserId;
    public $selectedUserName;
    public $password;
    public $search = '';

    public function getUsersProperty()
    {
        return User::query()
        ->where('name', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->paginate(5);
    }
    public function getCurrentPage()
    {
    return $this->getPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
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
        } catch (\Throwable $th) {
            Flux::modal('edit-password')->close();
            session()->flash('danger', 'Error al actualizar la contraseña: ' . $th->getMessage());
        }
        $this->reset('password', 'selectedUserId', 'selectedUserName');
    }
    public function updateUserState($user_id)
    {
         try {
            $user = User::find($user_id);
            if ($user) {
                $user->active = !$user->active;
                $user->save();
                if ($user->active) {
                    session()->flash('success', 'Usuario activado correctamente.');
                } else {
                    session()->flash('danger', 'Usuario desactivado correctamente.');
        }
    }
        } catch (\Throwable $th) {
            session()->flash('danger', 'Error al actualizar el estado del usuario: ' . $th->getMessage());
        }
    }
    public function updateUser($id)
    {
        return redirect()->route('users.edit', ['id' => $id]);
    }
    public function resetSelectedUser(){
        $this->reset('selectedUserId', 'selectedUserName');
    }

}; ?>

<div>
    <div class="flex justify-between items-end flex-wrap w-full mb-4">
        <div class="text-left">
            <flux:heading size="xl">Usuarios</flux:heading>
            <flux:text class="mt-2">Administrar los usuarios de la aplicacion.</flux:text>
        </div>
        <div class="flex items-center space-x-4 mt-2">
            <flux:input icon="magnifying-glass-plus" type="search" label="Buscar Usuarios" size="30"
                wire:model.live="search" ></flux:input>
            <div class="pt-6">
                <flux:button icon="user-plus" variant="primary" >
                    <a href="{{ route('users.create') }}">{{ __('Crear Usuario') }}</a>
                </flux:button>
            </div>
        </div>
    </div>
    @include('livewire.users.components.messages')
    <flux:separator class="my-4" text="Datos" />
    <div wire:key="users-table-{{ $search }}-page{{ $this->getCurrentPage() }}">
    @include('livewire.users.components.table')
    </div>
    @include('livewire.users.components.modal-password')
</div>