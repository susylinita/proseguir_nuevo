<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostulacionResource\Pages;
use App\Models\Postulacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Tables\Actions\Action;


use Illuminate\Support\Facades\Storage;

class PostulacionResource extends Resource
{
    protected static ?string $model = Postulacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function canCreate(): bool
    {
        return auth()->user()?->hasAnyRole(['coordinador', 'gerente']) ?? false;
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if (! $user) return false;

        if ($record?->estado === 'Aprobado') {
            return false;
        }

        return $user->hasAnyRole(['coordinador', 'gerente']);
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        if (! $user) return false;

        return $user->hasRole('gerente');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Datos del Postulante')
                ->schema([
                    Forms\Components\Select::make('tipo_postulacion')
                        ->label('Tipo de postulación')
                        ->options([
                            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
                            'otro_semestre'   => 'Ingreso a otro semestre (primera vez)',
                            'renovacion'      => 'Renovación (ya becado)',
                        ])
                        ->required(),

                    Forms\Components\TextInput::make('estudiante_nombre')
                        ->label('Nombre Completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('estudiante_email')
                        ->label('Correo Electrónico')
                        ->email()
                        ->required()
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('fecha_nacimiento')
                        ->label('Fecha de nacimiento'),

                    Forms\Components\TextInput::make('documento_identidad')
                        ->label('Documento de identidad')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('telefono_celular')
                        ->label('Teléfono celular')
                        ->maxLength(30),

                    Forms\Components\TextInput::make('telefono_fijo')
                        ->label('Teléfono fijo')
                        ->maxLength(30),

                    Forms\Components\TextInput::make('direccion')
                        ->label('Dirección')
                        ->maxLength(120),

                    Forms\Components\TextInput::make('barrio')
                        ->label('Barrio')
                        ->maxLength(80),

                    Forms\Components\Select::make('genero')
                        ->label('Género')
                        ->options([
                            'F' => 'F',
                            'M' => 'M',
                            'Otro' => 'Otro',
                            'Prefiero no decir' => 'Prefiero no decir',
                        ]),
                ])
                ->columns(2),

            Forms\Components\Section::make('Puntajes')
                ->schema([
                    Forms\Components\TextInput::make('puntaje_saber')
                        ->label('Puntaje Saber 11')
                        ->numeric()
                        ->required(),

                    Forms\Components\TextInput::make('promedio_universitario')
                        ->label('Promedio acumulado')
                        ->numeric()
                        ->step(0.1)
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Acudiente')
                ->schema([
                    Forms\Components\TextInput::make('nombre_acudiente')
                        ->label('Nombre acudiente')
                        ->maxLength(120),

                    Forms\Components\TextInput::make('telefono_acudiente')
                        ->label('Teléfono acudiente')
                        ->maxLength(30),
                ])
                ->columns(2),

            Forms\Components\Section::make('Estudios')
                ->schema([
                    Forms\Components\TextInput::make('universidad_aplica')
                        ->label('Universidad a la que aplica (primer semestre)')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'primer_semestre'),

                    Forms\Components\TextInput::make('carrera_aplica')
                        ->label('Carrera a la que aplica (pregrado)')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'primer_semestre'),

                    Forms\Components\TextInput::make('universidad_actual')
                        ->label('Universidad actual')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'otro_semestre'),

                    Forms\Components\TextInput::make('carrera_actual')
                        ->label('Carrera actual (pregrado)')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'otro_semestre'),

                    Forms\Components\TextInput::make('semestre_en_curso')
                        ->label('Semestre en curso')
                        ->numeric()
                        ->minValue(1)
                        ->maxValue(12)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'otro_semestre'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Datos bancarios')
                ->schema([
                    Forms\Components\TextInput::make('banco')->maxLength(80),
                    Forms\Components\TextInput::make('titular_cuenta')->maxLength(120),
                    Forms\Components\Select::make('tipo_cuenta')->options([
                        'Ahorros' => 'Ahorros',
                        'Corriente' => 'Corriente',
                    ]),
                    Forms\Components\TextInput::make('numero_cuenta')->maxLength(50),
                    Forms\Components\Toggle::make('cuenta_actualizada')->label('Cuenta actualizada'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Información adicional')
                ->schema([
                    Forms\Components\Textarea::make('como_encontro')
                        ->label('¿Cómo encontró la Fundación?')
                        ->rows(4)
                        ->maxLength(2000),
                ]),

            Forms\Components\Section::make('Documentos')
                ->schema([
                    // Foto (expediente)
                    Forms\Components\FileUpload::make('anexo_foto_documento')
                        ->label('Foto tipo documento')
                        ->image()
                        ->imageEditor()
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false),

                    Forms\Components\FileUpload::make('anexo_doc_identidad')
                        ->label('Documento de identidad (PDF/JPG/PNG)')
                        ->acceptedFileTypes(['application/pdf','image/jpeg','image/png'])
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false),

                    Forms\Components\FileUpload::make('anexo_certificado_bancario')
                        ->label('Certificado bancario (PDF/JPG/PNG)')
                        ->acceptedFileTypes(['application/pdf','image/jpeg','image/png'])
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false),

                    // Compatibilidad
                    Forms\Components\FileUpload::make('pdf_notas')
                        ->label('PDF Notas (compatibilidad)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/notas')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false),

                    Forms\Components\FileUpload::make('pdf_matricula')
                        ->label('PDF Matrícula (compatibilidad)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/matricula')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false),

                    // Renovación
                    Forms\Components\FileUpload::make('anexo_certificado_notas')
                        ->label('Certificado de notas (renovación)')
                        ->acceptedFileTypes(['application/pdf','image/jpeg','image/png'])
                        ->directory('postulaciones/renovacion')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'renovacion'),

                    Forms\Components\FileUpload::make('anexo_recibo_matricula')
                        ->label('Recibo matrícula (renovación)')
                        ->acceptedFileTypes(['application/pdf','image/jpeg','image/png'])
                        ->directory('postulaciones/renovacion')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'renovacion'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Gestión Interna')
                ->schema([
                    Forms\Components\Select::make('estado')
                        ->label('Estado')
                        ->options(function () {
                            $user = auth()->user();

                            if ($user?->hasRole('gerente')) {
                                return [
                                    'Pendiente' => 'Pendiente',
                                    'Entrevista' => 'Entrevista',
                                    'Aprobado' => 'Aprobado',
                                    'Rechazado' => 'Rechazado',
                                ];
                            }

                            if ($user?->hasRole('coordinador')) {
                                return [
                                    'Pendiente' => 'Pendiente',
                                    'Entrevista' => 'Entrevista',
                                    'Rechazado' => 'Rechazado',
                                ];
                            }

                            return [];
                        })
                        ->required()
                        ->disabled(fn ($record) => $record && $record->estado === 'Aprobado'),

                    Forms\Components\Textarea::make('perfil_descriptivo')
                        ->label('Perfil descriptivo (coordinación)')
                        ->rows(4)
                        ->maxLength(5000)
                        ->disabled(fn () => ! (auth()->user()?->hasAnyRole(['coordinador','gerente']) ?? false)),
                ])
                ->columns(1),
        ]);
    }

    /**
     * ✅ VIEW BONITO (Infolist) — esto es lo que hace el “show” premium en Filament
     */
    public static function infolist(Infolist $infolist): Infolist
{
    $getPendientes = function ($record): array {
        $tipo = $record->tipo_postulacion ?? 'primer_semestre';

        $pendientes = [];

        if ($tipo === 'renovacion') {
            if (empty($record->anexo_certificado_notas)) $pendientes[] = 'Certificado de notas (renovación)';
            if (empty($record->anexo_recibo_matricula)) $pendientes[] = 'Recibo de matrícula (renovación)';
        } else {
            if (empty($record->anexo_doc_identidad)) $pendientes[] = 'Documento de identidad';
            if (empty($record->anexo_foto_documento)) $pendientes[] = 'Foto tipo documento';
            if (empty($record->anexo_certificado_bancario)) $pendientes[] = 'Certificado cuenta bancaria';
            if (is_null($record->promedio_carrera)) $pendientes[] = 'Promedio de carrera';
        }

        // Compatibilidad (si todavía los usas)
        if (empty($record->pdf_notas)) $pendientes[] = 'Notas académicas (PDF)';
        if (empty($record->pdf_matricula)) $pendientes[] = 'Recibo de matrícula (PDF)';

        return $pendientes;
    };

    $semaforoColor = function (int $count): string {
        // 0 = verde, 1-2 = amarillo, 3+ = rojo
        if ($count === 0) return 'success';
        if ($count <= 2) return 'warning';
        return 'danger';
    };

    return $infolist->schema([

        InfoSection::make('Resumen')
            ->schema([
                Grid::make(4)->schema([
                    TextEntry::make('estado')
                        ->label('Estado')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Aprobado' => 'success',
                            'Entrevista' => 'info',
                            'Rechazado' => 'danger',
                            'Pendiente' => 'gray',
                            default => 'gray',
                        }),

                    TextEntry::make('tipo_postulacion')
                        ->label('Tipo')
                        ->formatStateUsing(fn ($state) => match ($state) {
                            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
                            'otro_semestre' => 'Ingreso a otro semestre (primera vez)',
                            'renovacion' => 'Renovación (ya becado)',
                            default => 'N/D',
                        }),

                    TextEntry::make('updated_at')
                        ->label('Última actualización')
                        ->dateTime('Y-m-d H:i'),

                    TextEntry::make('id')->label('ID'),
                ]),
            ]),

        // ✅ Pendientes + semáforo
        InfoSection::make('Pendientes')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('pendientes_count')
                        ->label('Pendientes (semáforo)')
                        ->state(fn ($record) => count($getPendientes($record)))
                        ->badge()
                        ->color(fn ($state) => $semaforoColor((int) $state))
                        ->formatStateUsing(fn ($state) => (int)$state === 0 ? '0 · Completo' : $state . ' · Por completar'),

                    TextEntry::make('pendientes_list')
                        ->label('Detalle')
                        ->state(function ($record) use ($getPendientes) {
                            $items = $getPendientes($record);
                            return empty($items) ? 'Sin pendientes.' : implode("\n• ", array_merge([''], $items));
                        })
                        ->formatStateUsing(fn ($state) => nl2br(e($state)))
                        ->html(),
                ]),
            ]),

        InfoSection::make('Datos del estudiante')
            ->schema([
                Grid::make(3)->schema([
                    Grid::make(2)
                        ->schema([
                            TextEntry::make('estudiante_nombre')->label('Nombre'),
                            TextEntry::make('estudiante_email')->label('Email'),

                            TextEntry::make('fecha_nacimiento')
                                ->label('Fecha de nacimiento')
                                ->date('Y-m-d')
                                ->placeholder('N/D'),

                            TextEntry::make('documento_identidad')->label('Documento')->placeholder('N/D'),
                            TextEntry::make('telefono_celular')->label('Celular')->placeholder('N/D'),
                            TextEntry::make('telefono_fijo')->label('Fijo')->placeholder('N/D'),

                            TextEntry::make('direccion')->label('Dirección')->placeholder('N/D'),
                            TextEntry::make('barrio')->label('Barrio')->placeholder('N/D'),
                            TextEntry::make('genero')->label('Género')->placeholder('N/D'),
                        ])
                        ->columnSpan(2),

                    ImageEntry::make('anexo_foto_documento')
                        ->label('Foto')
                        ->disk('public')
                        ->visibility('public')
                        ->height(180)
                        ->extraImgAttributes(['class' => 'rounded-md border border-gray-200'])
                        ->columnSpan(1),
                ]),
            ]),

        InfoSection::make('Puntajes')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('puntaje_saber')
                        ->label('Puntaje Saber 11')
                        ->badge()
                        ->color(fn ($state) => ((float)$state >= 300) ? 'success' : 'danger')
                        ->placeholder('N/D'),

                    TextEntry::make('promedio_universitario')
                        ->label('Promedio acumulado')
                        ->badge()
                        ->color(fn ($state) => ((float)$state >= 3.8) ? 'success' : 'danger')
                        ->placeholder('N/D'),
                ]),
            ]),

        InfoSection::make('Acudiente')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('nombre_acudiente')->label('Nombre')->placeholder('N/D'),
                    TextEntry::make('telefono_acudiente')->label('Teléfono')->placeholder('N/D'),
                ]),
            ]),

        InfoSection::make('Estudios')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('universidad_aplica')
                        ->label('Universidad a la que aplica')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'primer_semestre')
                        ->placeholder('N/D'),

                    TextEntry::make('carrera_aplica')
                        ->label('Carrera (pregrado)')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'primer_semestre')
                        ->placeholder('N/D'),

                    TextEntry::make('universidad_actual')
                        ->label('Universidad actual')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                        ->placeholder('N/D'),

                    TextEntry::make('carrera_actual')
                        ->label('Carrera (pregrado)')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                        ->placeholder('N/D'),

                    TextEntry::make('semestre_en_curso')
                        ->label('Semestre en curso')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                        ->placeholder('N/D'),

                    TextEntry::make('tipo_postulacion')
                        ->label('')
                        ->formatStateUsing(fn () => 'Renovación: se validan documentos de notas y matrícula (y cuenta si cambió).')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion'),
                ]),
            ]),

        InfoSection::make('Datos bancarios')
            ->schema([
                Grid::make(2)->schema([
                    TextEntry::make('banco')->label('Banco')->placeholder('N/D'),
                    TextEntry::make('titular_cuenta')->label('Titular')->placeholder('N/D'),
                    TextEntry::make('tipo_cuenta')->label('Tipo de cuenta')->placeholder('N/D'),
                    TextEntry::make('numero_cuenta')->label('Número de cuenta')->placeholder('N/D'),

                    IconEntry::make('cuenta_actualizada')
                        ->label('Cuenta actualizada')
                        ->boolean()
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion'),
                ]),
            ]),

        InfoSection::make('Información adicional')
            ->schema([
                TextEntry::make('como_encontro')
                    ->label('¿Cómo la encontró?')
                    ->placeholder('Sin respuesta.')
                    ->columnSpanFull(),
            ]),

        InfoSection::make('Perfil descriptivo (coordinación)')
            ->schema([
                TextEntry::make('perfil_descriptivo')
                    ->label('')
                    ->placeholder('Aún no hay perfil descriptivo registrado.')
                    ->columnSpanFull(),
            ]),

        // ✅ Documentos con "Ver" que abre en nueva pestaña (Filament v3.2: hintAction)
        InfoSection::make('Documentos')
            ->schema([
                Grid::make(2)->schema([

                    TextEntry::make('anexo_doc_identidad')
                        ->label('Documento de identidad')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->hintAction(
                            Action::make('ver_doc_identidad')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->anexo_doc_identidad)
                                    ? Storage::disk('public')->url($record->anexo_doc_identidad)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->anexo_doc_identidad))
                        ),

                    TextEntry::make('anexo_certificado_bancario')
                        ->label('Certificado bancario')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->hintAction(
                            Action::make('ver_cert_bancario')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->anexo_certificado_bancario)
                                    ? Storage::disk('public')->url($record->anexo_certificado_bancario)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->anexo_certificado_bancario))
                        ),

                    TextEntry::make('pdf_notas')
                        ->label('Notas académicas (PDF)')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->hintAction(
                            Action::make('ver_pdf_notas')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->pdf_notas)
                                    ? Storage::disk('public')->url($record->pdf_notas)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->pdf_notas))
                        ),

                    TextEntry::make('pdf_matricula')
                        ->label('Recibo de matrícula (PDF)')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->hintAction(
                            Action::make('ver_pdf_matricula')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->pdf_matricula)
                                    ? Storage::disk('public')->url($record->pdf_matricula)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->pdf_matricula))
                        ),

                    TextEntry::make('anexo_certificado_notas')
                        ->label('Certificado de notas (renovación)')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion')
                        ->hintAction(
                            Action::make('ver_notas_renovacion')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->anexo_certificado_notas)
                                    ? Storage::disk('public')->url($record->anexo_certificado_notas)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->anexo_certificado_notas))
                        ),

                    TextEntry::make('anexo_recibo_matricula')
                        ->label('Recibo matrícula (renovación)')
                        ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                        ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion')
                        ->hintAction(
                            Action::make('ver_matricula_renovacion')
                                ->label('Ver')
                                ->url(fn ($record) => !empty($record->anexo_recibo_matricula)
                                    ? Storage::disk('public')->url($record->anexo_recibo_matricula)
                                    : null
                                )
                                ->openUrlInNewTab()
                                ->visible(fn ($record) => !empty($record->anexo_recibo_matricula))
                        ),
                ]),
            ]),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
    // ✅ 1) General (Coordinación) - déjalo como ya lo tienes
    Action::make('export_pdf_general')
        ->label('PDF General (Coordinación)')
        ->icon('heroicon-o-document-arrow-down')
        ->action(function () {
            $postulaciones = Postulacion::query()
                ->latest()
                ->get();

            $fecha = now();
            $titulo = 'Reporte General - Coordinación';

            $pdf = Pdf::loadView('pdf.coordinacion-general', compact('postulaciones', 'fecha', 'titulo'))
                ->setPaper('a4', 'landscape');

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'reporte_coordinacion_general_' . $fecha->format('Ymd_His') . '.pdf'
            );
        }),

        // ✅ 2) Contabilidad - SOLO APROBADOS
            Action::make('export_pdf_aprobados')
                ->label('PDF Aprobados (Contabilidad)')
                ->icon('heroicon-o-banknotes')
                ->action(function () {
                    $VALOR_APROBADO = config('becas.valor_aprobado', 0); // o fijo: 500000

                    $postulaciones = Postulacion::query()
                        ->where('estado', 'Aprobado')
                        ->latest()
                        ->get();

                    $fecha = now();
                    $titulo = 'Planilla de Pagos - Contabilidad (Aprobados)';

                    $pdf = Pdf::loadView('pdf.coordinacion-contabilidad', compact('postulaciones', 'fecha', 'titulo', 'VALOR_APROBADO'))
                        ->setPaper('a4', 'portrait');

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'planilla_contabilidad_aprobados_' . $fecha->format('Ymd_His') . '.pdf'
                    );
                }),
        ])
            ->columns([
                Tables\Columns\TextColumn::make('estudiante_nombre')
                    ->label('Postulante')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('estudiante_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('promedio_universitario')
                    ->label('Promedio')
                    ->badge()
                    ->color(fn ($state) => $state >= 3.8 ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('puntaje_saber')
                    ->label('Saber 11')
                    ->badge()
                    ->color(fn ($state) => $state >= 300 ? 'success' : 'danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aprobado' => 'success',
                        'Entrevista' => 'info',
                        'Rechazado' => 'danger',
                        'Pendiente' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('Cumple Requisitos')
                    ->query(fn (Builder $query) => $query
                        ->where('promedio_universitario', '>=', 3.8)
                        ->where('puntaje_saber', '>=', 300)
                    )
                    ->label('Candidatos Aptos (Manual)'),
            ])
            ->actions([
                Tables\Actions\Action::make('preseleccionar')
                    ->label('Preseleccionar')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn ($record) =>
                        auth()->user()?->hasRole('coordinador')
                        && $record->estado === 'Pendiente'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Entrevista']);

                        Notification::make()
                            ->title('Postulación marcada para entrevista')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('aprobar')
                    ->label('Aprobar')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) =>
                        auth()->user()?->hasRole('gerente')
                        && $record->estado === 'Entrevista'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Aprobado']);

                        Notification::make()
                            ->title('Postulación aprobada')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\Action::make('rechazar')
                    ->label('Rechazar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) =>
                        auth()->user()?->hasAnyRole(['coordinador', 'gerente'])
                        && $record->estado !== 'Aprobado'
                        && $record->estado !== 'Rechazado'
                    )
                    ->action(function ($record) {
                        $record->update(['estado' => 'Rechazado']);

                        Notification::make()
                            ->title('Postulación rechazada')
                            ->danger()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->visible(fn ($record) => static::canEdit($record)),
                Tables\Actions\DeleteAction::make()->visible(fn ($record) => static::canDelete($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->hasRole('gerente') ?? false),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostulacions::route('/'),
            'create' => Pages\CreatePostulacion::route('/create'),
            'view' => Pages\ViewPostulacion::route('/{record}'),
            'edit' => Pages\EditPostulacion::route('/{record}/edit'),
        ];
    }
}
