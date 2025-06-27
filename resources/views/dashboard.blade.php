<x-layouts.app :title="__('Dashboard')">
    <div class="text-center m-4 text-2xl">
        <strong>Panel de Control</strong>
    </div>
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Venta Historica</strong></h1>
            <p>{{ '$'.number_format($totalSales, 2) }}</p>
        </div>
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Venta de Hoy</strong></h1>
            <p>{{ '$'.number_format($totalSalesToday, 2) }}</p>
        </div>
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Tus Ventas Historicas</strong></h1>
            <p>{{ '$'.number_format($totalSalesUser, 2) }}</p>
        </div>
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Tus Ventas de Hoy</strong></h1>
            <p>{{ '$'.number_format($totalSalesTodayUser, 2) }}</p>
        </div>
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Cantidad de Ventas Historicas</strong></h1>
            <p>{{ $quantitySales }}</p>
        </div>
        <div class=" text-center pt-2 dark:text-white relative flex-none rounded-xl border border-neutral-300 dark:border-neutral-700">
            <h1> <strong>Tu Cantidad de Ventas Hoy</strong></h1>
            <p>{{ $quantitySalesTodayUser }}</p>
        </div>

        <div class=" dark:text-white relative rounded-xl border border-neutral-300 dark:border-neutral-700 max-h-60 overflow-y-auto">
            <div class="text-center pt-2">
                <strong>Ultimas Ventas</strong>
            </div>
            <div class="px-4 mb-2">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 text-center px-2">Cantidad</th>
                            <th class="border border-gray-300 text-center px-2">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentSales as $item)
                        <tr>
                            <td class="border border-gray-300 text-center px-2">{{ '$'.$item->total_sale }}</td>
                            <td class="border border-gray-300 text-center px-2">{{ $item->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div
            class="dark:text-white relative rounded-xl border border-neutral-300 dark:border-neutral-700 max-h-60 overflow-y-auto">
            <div class="text-center pt-2">
                <strong>Productos con Stock Minimo</strong>
            </div>
            <div class="px-4 mb-2">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 text-center px-2">Codigo</th>
                            <th class="border border-gray-300 text-center px-2">Nombre</th>
                            <th class="border border-gray-300 text-center px-2">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowStock as $item)
                        <tr>
                            <td class="border border-gray-300 text-center px-2">{{ $item->code }}</td>
                            <td class="border border-gray-300 text-center px-2">{{ $item->name }}</td>
                            <td class="border border-gray-300 text-center px-2">{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>