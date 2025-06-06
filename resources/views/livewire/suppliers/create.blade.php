<?php

use Livewire\Volt\Component;
use App\Models\Supplier;

new class extends Component {
    public $name;
    public $phone;
    public $email;
    public $cp;
    public $website;
    public $notes;
    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'cp' => 'required|string|max:10',
        'website' => 'nullable|url|max:255',
        'notes' => 'nullable|string|max:500',
    ];
    public function create()
    {
        $this->validate();
        try {
            Supplier::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'cp' => $this->cp,
            'website' => $this->website,
            'notes' => $this->notes,
        ]);
        session()->flash('success', __('Proveedor creado exitosamente.'));
        return redirect()->route('suppliers.index');
        } catch (\Throwable $th) {
            session()->flash('danger', __('Error al crear el proveedor: ') . $th->getMessage());
            return redirect()->route('suppliers.index');
        }
        
    }
}; ?>

<div>
    <flux:heading size="xl">Crear Proveedor</flux:heading>
    <flux:text class="mt-2">Crea los proveedores de nuestros productos.</flux:text>
    <form wire:submit.prevent="create" class="mt-4">
        <flux:input type="text" label="{{__('Nombre')}}" wire:model="name" />
        <flux:input type="text" label="{{__('Teléfono')}}" wire:model="phone" />
        <flux:input type="email" label="{{__('Correo Electrónico')}}" wire:model="email" />
        <flux:input type="text" label="{{__('CP')}}" wire:model="cp" />
        <flux:input type="text" label="{{__('Sitio web')}}" wire:model="website" />
        <flux:textarea label="Notas" placeholder="Notas adicionales sobre el proveedor" wire:model="notes" rows="auto" />
        <flux:button icon="plus" variant="primary" type="submit" class="mt-4 cursor-pointer">Crear Proveedor</flux:button>
        <flux:button icon="x-mark" variant="danger" type="button" class="mt-4"><a href="{{ route('suppliers.index') }}">Cancelar</a></flux:button>
    </form>
</div>