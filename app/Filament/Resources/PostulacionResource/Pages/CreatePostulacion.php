<?php

namespace App\Filament\Resources\PostulacionResource\Pages;

use App\Filament\Resources\PostulacionResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePostulacion extends CreateRecord
{
    protected static string $resource = PostulacionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Si el admin seleccionó un usuario existente, se conserva ese user_id.
    if (! empty($data['user_id'])) {
        return $data;
    }

    // Si no seleccionó usuario existente, crea o actualiza usuario con la información de la postulación.
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
                    ? \Illuminate\Support\Facades\Hash::make($data['clave_usuario'])
                    : \Illuminate\Support\Facades\Hash::make($data['documento_identidad']),
            ]
        );

        if (method_exists($user, 'assignRole') && ! $user->hasRole('postulante')) {
            $user->assignRole('postulante');
        }

        $data['user_id'] = $user->id;
    }

    unset($data['clave_usuario']);

    return $data;
}

    

    
}