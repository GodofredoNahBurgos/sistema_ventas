<?php

use Livewire\Volt\Component;
use App\Models\Supplier;

new class extends Component {
    public $id;
    public $name;
    public $phone;
    public $email;
    public $cp;
    public $website;
    public $notes;
    public function mount($id)
    {
        $supplier = Supplier::find($id);
        $this->id = $supplier->id;
        $this->name = $supplier->name;
        $this->phone = $supplier->phone;
        $this->email = $supplier->email;
        $this->cp = $supplier->cp;
        $this->website = $supplier->website;
        $this->notes = $supplier->notes;
    }
    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'cp' => 'required|string|max:10',
            'website' => 'nullable|url|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $supplier = Supplier::find($this->id);
            $supplier->fill($validated);
            $supplier->save();
            session()->flash('success', __('Proveedor actualizado exitosamente.'));
            return redirect()->route('suppliers.index');
        } catch (\Throwable $th) {
            session()->flash('danger', __('Error al actualizar el proveedor: ') . $th->getMessage());
            return redirect()->route('suppliers.index');
        }
    }
}; ?>

<div>
    <flux:heading size="xl">Actualizar Proveedor</flux:heading>
    <flux:text class="mt-2">Actualiza los proveedores de nuestros productos.</flux:text>
    <form wire:submit.prevent="update" class="mt-4">
        <flux:input type="text" label="{{__('Nombre')}}" wire:model.defer="name" value="{{ $name }}"/>
        <flux:input type="text" label="{{__('Teléfono')}}" wire:model.defer="phone" value="{{ $phone }}" />
        <flux:input type="email" label="{{__('Correo Electrónico')}}" wire:model.defer="email" value="{{ $email }}" />
        <flux:input type="text" label="{{__('CP')}}" wire:model.defer="cp" value="{{ $cp }}" />
        <flux:input type="text" label="{{__('Sitio web')}}" wire:model.defer="website" value="{{ $website }}" />
        <flux:textarea label="Notas" placeholder="Notas adicionales sobre el proveedor" wire:model.defer="notes" rows="auto" value="{{ $notes }}" />
        <flux:button icon="arrow-path" variant="primary" type="submit" class="mt-4 cursor-pointer" wire:loading.attr="disabled" >Actualizar Proveedor</flux:button>
        <flux:button icon="x-mark" variant="danger" type="button" class="mt-4"><a href="{{ route('suppliers.index') }}">Cancelar</a></flux:button>
    </form>
</div>