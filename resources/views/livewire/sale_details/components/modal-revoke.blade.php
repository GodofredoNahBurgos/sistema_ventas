<flux:modal name="sale-revoker" class="min-w-[22rem]">
    <div class="space-y-6">
        <div class="my-6">
            <flux:heading size="lg">¿Estás seguro de revocar la venta?</flux:heading>
            <flux:heading class="text-center text-red-600 mt-2" size="md">
                ID: {{$selectedSaleId}}
            </flux:heading>
            <flux:text class="text-center mt-2">
                <p>Estás a punto de revocar esta venta.</p>
                <p>Esta acción no se puede deshacer.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button class="cursor-pointer" icon="x-mark" variant="primary">Cancelar</flux:button>
            </flux:modal.close>

            <flux:button class="cursor-pointer" icon="trash" variant="danger"
                wire:click="revoke({{ $selectedSaleId }})">Eliminar
            </flux:button>
        </div>
    </div>
</flux:modal>