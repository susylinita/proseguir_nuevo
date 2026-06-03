<?php

namespace App\Filament\Resources\PostulacionResource\Pages;

use App\Filament\Resources\PostulacionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePostulacion extends CreateRecord
{
    protected static string $resource = PostulacionResource::class;

    /**
     * Botón superior para volver al listado de postulaciones.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('volver_postulaciones')
                ->label('Volver a postulaciones')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(PostulacionResource::getUrl('index')),
        ];
    }

    /**
     * Después de crear la postulación, vuelve al listado.
     */
    protected function getRedirectUrl(): string
    {
        return PostulacionResource::getUrl('index');
    }

    /**
     * Mensaje de confirmación al crear.
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Postulación creada correctamente';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['semestres_promedios'] = $this->normalizarSemestresPromedios(
            $data['semestres_promedios'] ?? null
        );

        if (! empty($data['user_id'])) {
            unset($data['clave_usuario']);

            $data['titular_cuenta'] = $data['estudiante_nombre'] ?? null;

            return $data;
        }

        if (! empty($data['documento_identidad'])) {
            $user = \App\Models\User::updateOrCreate(
                ['cedula' => $data['documento_identidad']],
                [
                    'name' => $data['estudiante_nombre'] ?? 'Usuario sin nombre',
                    'email' => $data['estudiante_email'] ?? null,
                    'tipo_documento' => $data['tipo_documento'] ?? null,
                    'portal' => 'postulantes',
                    'is_admin' => false,
                    'password' => ! empty($data['clave_usuario'])
                        ? Hash::make($data['clave_usuario'])
                        : Hash::make($data['documento_identidad']),
                ]
            );

            if (method_exists($user, 'assignRole') && ! $user->hasRole('postulante')) {
                $user->assignRole('postulante');
            }

            $data['user_id'] = $user->id;
        }

        unset($data['clave_usuario']);

        $data['titular_cuenta'] = $data['estudiante_nombre'] ?? null;

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