@if (session()->has('success'))
<div class="w-80 m-2 text-center">
    <flux:callout class="" variant="success" icon="check-circle" text="{{ session('success') }}" />
</div>
@endif

@if (session()->has('danger'))
<div class="w-80 m-2 text-center">
    <flux:callout variant="danger" icon="check-circle" text="{{ session('danger') }}" />
</div>
@endif