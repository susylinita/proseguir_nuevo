@props(['header' => null])

<x-layouts.kits>
    @isset($header)
        <x-slot name="header">{{ $header }}</x-slot>
    @endisset

    {{ $slot }}
</x-layouts.kits>
