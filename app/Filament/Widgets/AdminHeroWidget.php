<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class AdminHeroWidget extends Widget
{
    protected static string $view = 'filament.widgets.admin-hero-widget';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;
}