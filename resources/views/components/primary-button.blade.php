@props(['type' => 'submit'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white bg-blue-800 hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition'
]) }}>
    {{ $slot }}
</button>
