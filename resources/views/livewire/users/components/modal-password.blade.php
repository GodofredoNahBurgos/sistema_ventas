<flux:modal name="edit-password" variant="default">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Actualizar contraseña</flux:heading>
            <flux:text class="mt-2">Actualizar contraseña de {{ $selectedUserName }}.</flux:text>
        </div>
        <flux:input wire:model.defer="password" label="Contraseña" type="password" />
        <div class="flex">
            <flux:spacer />
            <flux:button class="cursor-pointer" wire:click="changePassword({{ $selectedUserId }})" type="submit"
                variant="primary" wire:loading.attr="disabled">Actualizar</flux:button>
        </div>
    </div>
</flux:modal>