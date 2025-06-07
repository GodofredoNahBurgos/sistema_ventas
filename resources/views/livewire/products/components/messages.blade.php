@if (session()->has('success'))
<div class="w-80 m-2 ">
    <flux:callout variant="success" icon="check-circle" heading="{{ session('success') }}" />
</div>
@endif

@if (session()->has('danger'))
<div class="w-80 m-2 ">
    <flux:callout variant="danger" icon="x-circle" heading="{{ session('danger') }}" />
</div>
@endif