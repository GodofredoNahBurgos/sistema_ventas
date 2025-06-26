<x-layouts.app :title="__('Dashboard')">
    <div class="text-center m-4 text-2xl">
        <strong>Panel de Control</strong>
    </div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class=" text-center pt-2 dark:text-white relative flex-1 overflow-hidden rounded-xl border border-neutral-400 dark:border-neutral-700">
            <h1> <strong>Venta Historica</strong></h1>
            <p>{{ '$'.number_format($totalSales, 2) }}</p>
        </div>
        
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 justify-items-center">
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-2 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Venta Historica</strong></h1>
                <p>{{ '$'.number_format($totalSales, 2) }}</p>
            </div>
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-4 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Venta de Hoy</strong></h1>
                <p>{{ '$'.number_format($totalSalesToday, 2) }}</p>
            </div>
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-4 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Tus Ventas Historicas</strong></h1>
                <p>{{ '$'.number_format($totalSalesUser, 2) }}</p>
            </div>
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-2 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Tus Ventas de Hoy</strong></h1>
                <p>{{ '$'.number_format($totalSalesTodayUser, 2) }}</p>
            </div>
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-2 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Cantidad de Ventas Historicas</strong></h1>
                <p>{{ $quantitySales }}</p>
            </div>
            <div
                class="bg-stone-800 dark:bg-neutral-900 text-white pt-2 px-2 h-18 w-72 text-center relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <h1> <strong>Tu Cantidad de Ventas Hoy</strong></h1>
                <p>{{ $quantitySalesTodayUser }}</p>
            </div>
        </div>

        <div class="bg-stone-800 dark:bg-neutral-900 text-white relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="text-center pt-2">
                <strong>Ultimas Ventas</strong>
            </div>
            <div class="px-4">
                <ol>
                    @foreach ($recentSales as $item)
                    <li>{{'Cantidad: $'.$item->total_sale.' Fecha: '.$item->created_at }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
        <div
            class="bg-stone-800 dark:bg-neutral-900 text-white relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="text-center pt-2">
                <strong>Productos con Stock Minimo</strong>
            </div>
            <div class="px-4">
                <ol>
                    @foreach ($lowStock as $item)
                    <li>{{ 'Codigo: '.$item->code.' Nombre: '.$item->name.' Cantidad: '.$item->quantity }}</li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>