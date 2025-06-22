<flux:modal name="edit-password" variant="default" :dismissible="false" >
    <div class="space-y-6">
        <div>
            <flux:heading class="text-center text-red-600 mt-6" size="md">
                {{"''¿Actualizar contraseña de ".$selectedUserName." ?''"}}
            </flux:heading>
        </div>
        <flux:input wire:model.defer="password" label="Contraseña" type="password" />
        <div class="flex gap-2">
            <flux:spacer />
            <flux:button class="cursor-pointer" icon="arrow-path" wire:click="changePassword({{ $selectedUserId }})" type="submit" variant="primary" wire:loading.attr="disabled">Actualizar</flux:button>
            <flux:modal.close>
                <flux:button class="cursor-pointer" icon="x-mark" variant="danger" wire:click="resetSelectedUser">Cancelar</flux:button>
            </flux:modal.close>
        </div>
    </div>
</flux:modal>