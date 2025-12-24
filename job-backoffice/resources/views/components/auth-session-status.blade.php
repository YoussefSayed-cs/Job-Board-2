@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-lato text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif
