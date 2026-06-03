<?php

namespace App\Filament\Resources\PostulacionResource\Pages;

use App\Filament\Resources\PostulacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostulacion extends EditRecord
{
    protected static string $resource = PostulacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['semestres_promedios'] = $this->normalizarSemestresPromedios(
            $data['semestres_promedios'] ?? null
        );

        unset($data['clave_usuario']);

        return $data;
    }

    private function normalizarSemestresPromedios($semestres): ?array
    {
        if (! is_array($semestres)) {
            return null;
        }

        $items = collect($semestres)
            ->filter(fn ($item) =>
                ! empty($item['semestre']) &&
                isset($item['promedio_acumulado']) &&
                $item['promedio_acumulado'] !== ''
            )
            ->map(fn ($item) => [
                'semestre' => (int) $item['semestre'],
                'promedio_acumulado' => (float) $item['promedio_acumulado'],
            ])
            ->values()
            ->toArray();

        return count($items) > 0 ? $items : null;
    }
}