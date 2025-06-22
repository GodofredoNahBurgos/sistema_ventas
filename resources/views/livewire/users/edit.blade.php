<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {
    
    public int $id;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $role = '';

    public function mount()
    {
        $user = User::find($this->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,cashier'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->id)],
        ]);

        try {
            $user = User::find($this->id);
            $user->fill($validated);
            $user->save();
            $this->reset();
            return redirect()->route('users.index')->with('success', __('Usuario actualizado correctamente.'));
        } catch (\Throwable $th) {
            $this->reset();
            return redirect()->route('users.index')->with('danger', __('Error al actualizar el usuario: :message', ['message' => $th->getMessage()]));
        }
        
    }
}; ?>

<div>
    <flux:heading size="xl">Editar Usuarios</flux:heading>
    <flux:text class="mt-2">Edita los usuarios de nuestra aplicacion.</flux:text>

    <form wire:submit="updateUser" class="flex flex-col gap-6 mt-4">
        <flux:input wire:model.defer="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />
            <flux:select wire:model.defer='role' label="Role">
            <flux:select.option value="" disabled>
                {{__('Select role...')}}
            </flux:select.option>
            <flux:select.option value="cashier">
                {{__('Cashier')}}
            </flux:select.option>
            <flux:select.option value="admin">
                {{__('Administrator')}}
            </flux:select.option>
        </flux:select>
        <flux:input wire:model.defer="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />
        <div class="flex items-center justify-start">
            <flux:button icon="arrow-path" type="submit" variant="primary" class="cursor-pointer" wire:loading.attr="disabled" >
                {{ __('Actualizar') }}
            </flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a href="{{ route('users.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>