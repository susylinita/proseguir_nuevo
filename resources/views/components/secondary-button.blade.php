@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 transition'
]) }}>
    {{ $slot }}
</button>
