<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AdminHero extends Widget
{
    protected static string $view = 'filament.widgets.admin-hero';

    // Que se vea arriba y ancho completo
    protected int|string|array $columnSpan = 'full';

    // Opcional: orden para que quede primero
    protected static ?int $sort = 1;
}
