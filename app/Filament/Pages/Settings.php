<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationLabel = 'Configuración';
    protected static ?string $title = 'Configuración';
    protected static ?string $navigationGroup = 'Coordinación';

    public ?array $data = [];

    public function mount(): void
    {
        $s = Setting::current();

        $this->form->fill([
            'valor_aprobado' => $s->valor_aprobado,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Becas')
                    ->schema([
                        Forms\Components\TextInput::make('valor_aprobado')
                            ->label('Valor aprobado (para planilla contabilidad)')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->helperText('Este valor se imprimirá en el PDF de aprobados.'),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $validated = $this->form->getState();

        $s = Setting::current();
        $s->update([
            'valor_aprobado' => (int) $validated['valor_aprobado'],
        ]);

        Notification::make()
            ->title('Configuración guardada')
            ->success()
            ->send();
    }

    public static function canAccess(): bool
    {
        // Solo coordinación/gerencia
        return auth()->user()?->hasRole(['admin']) ?? false;
    }
}
