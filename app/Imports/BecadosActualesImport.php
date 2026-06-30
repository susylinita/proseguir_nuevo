<?php

namespace App\Imports;

use App\Models\Postulacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class BecadosActualesImport implements ToCollection, WithCalculatedFormulas
{
    public int $creados = 0;
    public int $actualizados = 0;
    public int $omitidos = 0;

    public array $errores = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            // Saltar encabezado
            if ($index === 0) {
                continue;
            }

            $filaExcel = $index + 1;

            try {
                $documento = $this->limpiarNumeroComoTexto($row[4] ?? null);
                $nombre = $this->limpiarTexto($row[2] ?? null);

                if (blank($documento)) {
                    $this->registrarError($filaExcel, 'Registro omitido: no tiene número de identificación.');
                    continue;
                }

                if (blank($nombre)) {
                    $this->registrarError($filaExcel, "Registro omitido: no tiene nombre completo. Documento: {$documento}");
                    continue;
                }

                $email = $this->limpiarTexto($row[9] ?? null);

                $promedioCarrera = $this->numeroDecimal($row[28] ?? null);

                if ($promedioCarrera === null) {
                    $this->registrarError(
                        $filaExcel,
                        "Advertencia: no se pudo leer PROM CARRERA / promedio universitario. Documento: {$documento}, Nombre: {$nombre}"
                    );
                }

                $user = User::updateOrCreate(
                    ['cedula' => $documento],
                    [
                        'name' => $nombre,
                        'email' => $email ?: null,
                        'tipo_documento' => 'CC',
                        'portal' => 'postulantes',
                        'is_admin' => false,
                        'password' => Hash::make($documento),
                    ]
                );

                if (method_exists($user, 'assignRole') && ! $user->hasRole('postulante')) {
                    $user->assignRole('postulante');
                }

                $semestresPromedios = $this->obtenerSemestresPromedios($row, $filaExcel, $documento, $nombre);

                $data = [
                    'user_id' => $user->id,
                    'tipo_postulacion' => 'becado_actual',
                    'estado' => 'Aprobado',

                    'estudiante_nombre' => $nombre,
                    'estudiante_email' => $email ?: null,
                    'fecha_nacimiento' => $this->parseFecha($row[3] ?? null),
                    'tipo_documento' => 'CC',
                    'documento_identidad' => $documento,

                    'telefono_fijo' => $this->limpiarNumeroComoTexto($row[5] ?? null),
                    'telefono_celular' => $this->limpiarNumeroComoTexto($row[6] ?? null),
                    'direccion' => $this->limpiarTexto($row[7] ?? null),
                    'barrio' => $this->limpiarTexto($row[8] ?? null),

                    'nombre_acudiente' => $this->limpiarTexto($row[10] ?? null),
                    'telefono_acudiente' => $this->limpiarNumeroComoTexto($row[11] ?? null),

                    'universidad_actual' => $this->limpiarTexto($row[12] ?? null),
                    'carrera_actual' => $this->limpiarTexto($row[13] ?? null),
                    'semestre_en_curso' => $this->numeroEntero($row[14] ?? null),

                    'semestres_promedios' => $semestresPromedios,
                    'promedio_carrera' => $promedioCarrera,
                    'promedio_universitario' => $promedioCarrera,

                    'banco' => $this->limpiarTexto($row[29] ?? null),
                    'titular_cuenta' => $nombre,
                    'tipo_cuenta' => $this->normalizarTipoCuenta($row[31] ?? null),
                    'numero_cuenta' => $this->limpiarNumeroComoTexto($row[32] ?? null),

                    'cuenta_actualizada' => false,

                    'estado_actualizado_por' => auth()->id(),
                    'estado_actualizado_en' => now(),
                ];

                $postulacion = Postulacion::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'tipo_postulacion' => 'becado_actual',
                    ],
                    $data
                );

                $postulacion->wasRecentlyCreated
                    ? $this->creados++
                    : $this->actualizados++;
            } catch (\Throwable $e) {
                $documentoError = $documento ?? 'Sin documento';
                $nombreError = $nombre ?? 'Sin nombre';

                $this->registrarError(
                    $filaExcel,
                    "Error guardando registro. Documento: {$documentoError}. Nombre: {$nombreError}. Error: {$e->getMessage()}"
                );
            }
        }
    }

    private function obtenerSemestresPromedios($row, int $filaExcel, ?string $documento, ?string $nombre): ?array
    {
        $items = [];

        // PROM SEM 1 empieza en columna 15.
        // Índices 15 a 27 equivalen a semestre 1 a 13.
        for ($i = 1; $i <= 13; $i++) {
            $index = 14 + $i;

            $valorOriginal = $row[$index] ?? null;
            $promedio = $this->numeroDecimal($valorOriginal);

            if ($promedio !== null) {
                $items[] = [
                    'semestre' => $i,
                    'promedio_acumulado' => $promedio,
                ];
            }
        }

        if (count($items) === 0) {
            $this->registrarError(
                $filaExcel,
                "Advertencia: no se encontraron promedios por semestre. Documento: {$documento}, Nombre: {$nombre}"
            );
        }

        return count($items) > 0 ? $items : null;
    }

    private function registrarError(int $filaExcel, string $mensaje): void
    {
        $this->errores[] = "Fila {$filaExcel}: {$mensaje}";
        $this->omitidos++;
    }

    private function limpiarTexto($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;

        if (! mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252, ISO-8859-1, UTF-8');
        }

        $value = str_replace(
            [
                "\u{00A0}",
                "\u{200B}",
                "\u{FEFF}",
                "\t",
                "\r",
                "\n",
            ],
            ' ',
            $value
        );

        $value = str_replace(
            ['“', '”', '‘', '’', '–', '—', '−', 'º', 'ª'],
            ['"', '"', "'", "'", '-', '-', '-', '°', 'a'],
            $value
        );

        // Elimina solo caracteres de control no válidos, conserva tildes y ñ.
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);

        $value = preg_replace('/\s+/u', ' ', $value);

        $value = trim($value);

        return $value !== '' ? $value : null;
    }

    private function limpiarNumeroComoTexto($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;

        if (! mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1252, ISO-8859-1, UTF-8');
        }

        $value = str_replace(["\u{00A0}", "\t", "\r", "\n"], '', $value);

        // Conserva solo dígitos para documentos, teléfonos y cuentas.
        $value = preg_replace('/[^0-9]/u', '', $value);

        return $value !== '' ? $value : null;
    }

    private function numeroEntero($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        $value = preg_replace('/[^0-9]/', '', (string) $value);

        return $value !== '' ? (int) $value : null;
    }

    private function numeroDecimal($value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Si Excel entrega el resultado de una fórmula como número
        |--------------------------------------------------------------------------
        */
        if (is_int($value) || is_float($value)) {
            return round((float) $value, 2);
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Si por algún motivo llega una fórmula sin calcular, no se puede convertir.
        | WithCalculatedFormulas debería evitar esto.
        |--------------------------------------------------------------------------
        */
        if (Str::startsWith($value, '=')) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Limpieza de errores comunes de Excel
        |--------------------------------------------------------------------------
        */
        $value = str_replace(
            ['#DIV/0!', '#N/A', '#VALUE!', '#REF!', '#NAME?', '#NUM!', '#NULL!'],
            '',
            strtoupper($value)
        );

        if ($value === '') {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Normalizar formato decimal
        | Casos:
        | 4,25  => 4.25
        | 4.25  => 4.25
        | 4,250 => 4.25 si viene como promedio
        |--------------------------------------------------------------------------
        */
        $value = str_replace(["\u{00A0}", ' '], '', $value);

        // Si tiene coma decimal, convertir a punto.
        if (str_contains($value, ',') && ! str_contains($value, '.')) {
            $value = str_replace(',', '.', $value);
        }

        // Si tiene separadores mixtos tipo 1.234,56
        if (str_contains($value, '.') && str_contains($value, ',')) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        }

        // Dejar solo números, punto y signo negativo.
        $value = preg_replace('/[^0-9\.\-]/', '', $value);

        if ($value === '' || $value === '-' || $value === '.') {
            return null;
        }

        if (! is_numeric($value)) {
            return null;
        }

        return round((float) $value, 2);
    }

    private function parseFecha($value): ?string
    {
        if (blank($value)) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value)->format('Y-m-d');
        }

        /*
        |--------------------------------------------------------------------------
        | Si Excel entrega fecha como serial numérico
        |--------------------------------------------------------------------------
        */
        if (is_numeric($value)) {
            try {
                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            } catch (\Throwable) {
                return null;
            }
        }

        $value = strtoupper(trim((string) $value));

        $meses = [
            'ENERO' => '01',
            'FEBRERO' => '02',
            'MARZO' => '03',
            'ABRIL' => '04',
            'MAYO' => '05',
            'JUNIO' => '06',
            'JULIO' => '07',
            'AGOSTO' => '08',
            'SEPTIEMBRE' => '09',
            'SETIEMBRE' => '09',
            'OCTUBRE' => '10',
            'NOVIEMBRE' => '11',
            'DICIEMBRE' => '12',
        ];

        foreach ($meses as $mesTexto => $mesNumero) {
            if (Str::contains($value, $mesTexto)) {
                $value = str_replace($mesTexto, $mesNumero, $value);
                break;
            }
        }

        // Ejemplo: MARZO 5/2002 => 2002-03-05
        if (preg_match('/(\d{1,2})\s+(\d{1,2})\/(\d{4})/', $value, $matches)) {
            $mes = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $dia = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $anio = $matches[3];

            return "{$anio}-{$mes}-{$dia}";
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }

    private function normalizarTipoCuenta($value): ?string
{
    $value = $this->limpiarTexto($value);

    if (blank($value)) {
        return null;
    }

    $valueNormalizado = Str::upper($value);

    $valueNormalizado = str_replace(
        ['Á', 'É', 'Í', 'Ó', 'Ú'],
        ['A', 'E', 'I', 'O', 'U'],
        $valueNormalizado
    );

    $valueNormalizado = preg_replace('/\s+/', ' ', trim($valueNormalizado));

    if (Str::contains($valueNormalizado, ['AHORRO', 'AHORROS'])) {
        return 'Ahorros';
    }

    if (Str::contains($valueNormalizado, ['CORRIENTE'])) {
        return 'Corriente';
    }

    if (Str::contains($valueNormalizado, ['NEQUI'])) {
        return 'Nequi';
    }

    if (Str::contains($valueNormalizado, ['DAVIPLATA', 'DAVI PLATA'])) {
        return 'Daviplata';
    }

    return null;
}
}