<flux:modal name="delete-purchase" class="min-w-[22rem]">
    <div class="space-y-6">
        <div class="my-6">
            <flux:heading size="lg">¿Desea elimnar la compra de {{$selectedPurchaseProduct}}?</flux:heading>
            <flux:heading class="text-center text-red-600 mt-2" size="md">
                {{'Fecha: '.$selectedPurchaseDate}}
            </flux:heading>
            <flux:text class="text-center mt-2">
                <p>Estás a punto de eliminar esta compra.</p>
                <p>Esta acción no se puede deshacer.</p>
            </flux:text>
        </div>
        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button class="cursor-pointer" icon="x-mark" variant="primary" wire:click="resetSelectedPurchase">Cancelar</flux:button>
            </flux:modal.close>
            <flux:button class="cursor-pointer" icon="trash" variant="danger"
                wire:click="delete({{ $selectedPurchaseId }})" wire:loading.attr="disabled">Eliminar
            </flux:button>
        </div>
    </div>
</flux:modal>