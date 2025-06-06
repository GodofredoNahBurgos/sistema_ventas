<flux:modal name="delete-category" class="min-w-[22rem]">
    <div class="space-y-6">
        <div class="my-6">
            <flux:heading size="lg">¿Estás seguro de que deseas eliminar esta categoría?</flux:heading>
            <flux:heading class="text-center text-red-600 mt-2" size="md">
                {{$selectedCategoryName}}
            </flux:heading>
            <flux:text class="text-center mt-2">
                <p>Estás a punto de eliminar esta categoría.</p>
                <p>Esta acción no se puede deshacer.</p>
            </flux:text>
        </div>

        <div class="flex gap-2">
            <flux:spacer />

            <flux:modal.close>
                <flux:button class="cursor-pointer" icon="x-mark" variant="primary">Cancelar</flux:button>
            </flux:modal.close>

            <flux:button class="cursor-pointer" icon="trash" variant="danger"
                wire:click="delete({{ $selectedCategoryId }})">Eliminar
            </flux:button>
        </div>
    </div>
</flux:modal>