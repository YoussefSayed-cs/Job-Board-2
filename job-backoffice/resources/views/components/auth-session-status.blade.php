@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'p-4 rounded-xl bg-emerald-50 border border-emerald-100 font-bold text-sm text-emerald-600 flex items-center gap-3']) }}>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ $status }}
    </div>
@endif
