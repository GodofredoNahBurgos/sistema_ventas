<?php

/* Importamos todos estos */
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component {

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $role = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'in:admin,cashier'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        try {
            event(new Registered(($user = User::create($validated))));
            $this->reset();
            return redirect()->route('users.index')->with('success', __('User created successfully.'));
        } catch (\Throwable $th) {
            $this->reset();
            return redirect()->route('users.index')->with('danger', __('Error al crear el usuario: :message', ['message' => $th->getMessage()]));
        }
    
    }

}; ?>

<div>
    <flux:heading size="xl">Registrar Usuarios</flux:heading>
    <flux:text class="mt-2">Crea los usuarios de nuestra aplicacion.</flux:text>
    <form wire:submit.prevent="register" class="flex flex-col gap-6 mt-4">
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
        <flux:input wire:model.defer="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />
        <flux:input wire:model.defer="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />
        <div class="flex items-center justify-start">
            <flux:button type="submit" icon="plus" variant="primary" class="cursor-pointer" wire:loading.attr="disabled" >
                {{ __('Crear usuario') }}
            </flux:button>
            <flux:button icon="x-mark" variant="danger" type="button" class="mx-2"><a href="{{ route('users.index') }}">Cancelar</a></flux:button>
        </div>
    </form>
</div>