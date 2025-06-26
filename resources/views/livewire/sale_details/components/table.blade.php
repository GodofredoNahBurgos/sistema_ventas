@php
    $sales = $this->sales;
@endphp
<div class="overflow-x-auto">
    <table class="table-auto w-full">
        <thead class="">
            <tr>
                <th class="border border-gray-300 text-center">#</th>
                <th class="border border-gray-300 text-center">Total Vendido</th>
                <th class="border border-gray-300 text-center">Fecha</th>
                <th class="border border-gray-300 text-center">Usuario</th>
                <th class="border border-gray-300 text-center">Ver Detalle</th>
                <th class="border border-gray-300 text-center">Imprimir Ticket</th>
                <th class="border border-gray-300 text-center">Revocar Venta</th>
            </tr>
        </thead>
        <tbody>
            @if ($sales->isEmpty())
            <tr>
                <td colspan="5" class="border border-gray-300 text-center">No hay ventas disponibles.</td>
            </tr>
            @else
            @foreach ($sales as $sale)
            <tr>
                <td class="border border-gray-300 text-center">{{ $sale->id }}</td>
                <td class="border border-gray-300 text-center">{{ '$'.$sale->total_sale }}</td>
                <td class="border border-gray-300 text-center">{{ $sale->created_at }}</td>
                <td class="border border-gray-300 text-center">{{ $sale->user_name }}</td>
                <td class="border border-gray-300 text-center">
                    <flux:button wire:click="detailSale({{ $sale->id }})" icon="clipboard-document-list"
                        class="my-2 cursor-pointer" variant="primary">Detalle</flux:button>
                </td>
                <td class="border border-gray-300 text-center">
                    <flux:button href="{{route('ticket.pdf', ['sale_id' => $sale->id])}}" target="_blank" icon="printer" class="my-2 cursor-pointer"
                        variant="primary">Imprimir
                    </flux:button>
                </td>
                <td class="border border-gray-300 text-center">
                    <flux:modal.trigger name="sale-revoker">
                        <flux:button wire:click="confirmRevoke({{ $sale->id }})" icon="trash"
                            class="my-2 cursor-pointer" variant="danger">Revocar
                        </flux:button>
                    </flux:modal.trigger>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-2">
        {{ $sales->links() }}
    </div>
</div>