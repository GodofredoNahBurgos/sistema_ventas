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
            return redirect()->route('users.index')->with('success', __('User created successfully.'));
        } catch (\Throwable $th) {
            return redirect()->route('users.index')->with('danger', __('Error al crear el usuario: :message', ['message' => $th->getMessage()]));
        }
    
    }

}; ?>

<div>

    <flux:heading size="xl">Registrar Usuarios</flux:heading>
    <flux:text class="mt-2">Crea los usuarios de nuestra aplicacion.</flux:text>

    <form wire:submit="register" class="flex flex-col gap-6 mt-4">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <flux:select wire:model='role' label="Role">
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

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full cursor-pointer">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>
</div>