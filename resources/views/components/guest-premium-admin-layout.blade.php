@props(['title' => 'Admin | Fundación Proseguir'])

<x-guest-premium-layout
    :title="$title"
    heroTitle="Acceso administrativo"
    heroDescription="Inicia sesión para gestionar postulaciones, kits, aprobaciones y reportes."
    :showHeroText="true"
>
    {{ $slot }}
</x-guest-premium-layout>
