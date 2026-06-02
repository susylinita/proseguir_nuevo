<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostulacionResource\Pages;
use App\Models\Postulacion;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action as InfolistAction;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Enums\ActionsPosition;

class PostulacionResource extends Resource
{
    protected static ?string $model = Postulacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Postulaciones';
    protected static ?string $modelLabel = 'Postulación';
    protected static ?string $pluralModelLabel = 'Postulaciones';

    public static function canViewAny(): bool
{
    return auth()->user()?->hasAnyRole([
        'admin',
        'gerencia',
    ]) ?? false;
}

public static function canView($record): bool
{
    return auth()->user()?->hasAnyRole([
        'admin',
        'gerencia',
    ]) ?? false;
}

public static function canCreate(): bool
{
    return auth()->user()?->hasAnyRole([
        'admin',
    ]) ?? false;
}

public static function canEdit($record): bool
{
    return auth()->user()?->hasAnyRole([
        'admin',
    ]) ?? false;
}

public static function canDelete($record): bool
{
    return auth()->user()?->hasRole('admin') ?? false;
}

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Usuario asociado')
    ->schema([
        Forms\Components\Select::make('user_id')
            ->label('Asignar a usuario existente')
            ->placeholder('Seleccione un usuario existente')
            ->helperText('Seleccione un usuario existente si esta postulación pertenece a un becado ya creado.')
            ->options(function () {
                return \App\Models\User::query()
                    ->where('portal', 'postulantes')
                    ->orderBy('name')
                    ->get()
                    ->mapWithKeys(function ($user) {
                        $label = $user->name ?: 'Usuario sin nombre';

                        if ($user->cedula) {
                            $label .= ' - Doc: ' . $user->cedula;
                        }

                        if ($user->email) {
                            $label .= ' - ' . $user->email;
                        }

                        return [$user->id => $label];
                    })
                    ->toArray();
            })
            ->native(true)
            ->nullable()
            ->live()
            ->afterStateUpdated(function ($state, callable $set) {
                if (! $state) {
                    return;
                }

                $user = \App\Models\User::find($state);

                if (! $user) {
                    return;
                }

                $set('estudiante_nombre', $user->name);
                $set('estudiante_email', $user->email);
                $set('documento_identidad', $user->cedula);
                $set('tipo_documento', $user->tipo_documento);
            }),
    ])
    ->columns(1),

    
            Forms\Components\Section::make('Datos del Postulante')
                ->schema([
                    Forms\Components\Select::make('tipo_postulacion')
                        ->label('Tipo de postulación')
                        ->options([
                            'primer_semestre' => 'Ingreso a primer semestre (primera vez)',
                            'otro_semestre' => 'Ingreso a otro semestre (primera vez)',
                            'renovacion' => 'Renovación (ya becado)',
                            'becado_actual' => 'Becado actual',
                        ])
                        ->required()
                        ->live(),

                    Forms\Components\TextInput::make('estudiante_nombre')
                        ->label('Nombre completo')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('estudiante_email')
                        ->label('Correo electrónico')
                        ->required()
                        ->email()
                        ->nullable()
                        ->maxLength(255),

                    Forms\Components\DatePicker::make('fecha_nacimiento')
                        ->label('Fecha de nacimiento'),

                    Forms\Components\Select::make('tipo_documento')
                        ->label('Tipo de documento')
                        ->options([
                            'CC' => 'Cédula de ciudadanía',
                            'TI' => 'Tarjeta de identidad',
                            'CE' => 'Cédula de extranjería',
                            'PAS' => 'Pasaporte',
                            'RC' => 'Registro civil',
                        ])
                        ->required()
                        ->searchable(),

                    Forms\Components\TextInput::make('documento_identidad')
                        ->label('Número de documento')
                        ->required()
                        ->maxLength(50),

                    Forms\Components\TextInput::make('clave_usuario')
                        ->label('Clave de acceso del postulante')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(false)
                        ->visible(fn () => auth()->user()?->hasRole('admin') ?? false),

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
                        ->label('Universidad a la que aplica')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'primer_semestre'),

                    Forms\Components\TextInput::make('carrera_aplica')
                        ->label('Carrera a la que aplica')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'primer_semestre'),

                    Forms\Components\TextInput::make('universidad_actual')
                        ->label('Universidad actual')
                        ->maxLength(160)
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'otro_semestre'),

                    Forms\Components\TextInput::make('carrera_actual')
                        ->label('Carrera actual')
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
                    Forms\Components\TextInput::make('banco')
                        ->label('Banco')
                        ->maxLength(80),

                    Forms\Components\TextInput::make('titular_cuenta')
                        ->label('Titular de la cuenta')
                        ->maxLength(120),

                    Forms\Components\Select::make('tipo_cuenta')
                        ->label('Tipo de cuenta')
                        ->options([
                            'Ahorros' => 'Ahorros',
                            'Corriente' => 'Corriente',
                        ]),

                    Forms\Components\TextInput::make('numero_cuenta')
                        ->label('Número de cuenta')
                        ->maxLength(50),

                    Forms\Components\Toggle::make('cuenta_actualizada')
                        ->label('Cuenta actualizada')
                        ->live()
                        ->visible(fn ($get) => $get('tipo_postulacion') === 'renovacion'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Información adicional')
                ->schema([
                    Forms\Components\Textarea::make('como_encontro')
                        ->label(fn ($get) => $get('tipo_postulacion') === 'renovacion'
                            ? 'Recomendación para la fundación o sugerencia'
                            : '¿Cómo encontró la Fundación?'
                        )
                        ->rows(4)
                        ->maxLength(2000),
                ]),

            Forms\Components\Section::make('Gestión interna')
                ->schema([
                    Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Postulado' => 'Postulado',
                        'En estudio' => 'En estudio',
                        'Pendiente aprobación gerencia' => 'Pendiente aprobación gerencia',
                        'Aprobado' => 'Aprobado',
                        'Rechazado' => 'Rechazado',
                        'Cancelado' => 'Cancelado',
                    ])
                    ->required()
                    ->default('Postulado')
                    ->disabled(fn ($record) => $record && in_array($record->estado, ['Aprobado', 'Rechazado', 'Cancelado'], true)),
                 
                    Forms\Components\Textarea::make('perfil_descriptivo')
                        ->label('Perfil descriptivo')
                        ->rows(4)
                        ->maxLength(5000)
                        ->disabled(fn () => ! (auth()->user()?->hasAnyRole(['admin', 'admin_panel', 'coordinacion', 'coordinador']) ?? false)),

                    Forms\Components\Textarea::make('entrevista_observaciones')
                        ->label('Observaciones de entrevista')
                        ->rows(5)
                        ->maxLength(10000)
                        ->columnSpanFull()
                        ->disabled(fn () => ! (auth()->user()?->hasAnyRole(['admin', 'coordinacion', 'coordinador']) ?? false)),

                    Forms\Components\Checkbox::make('entrevista_recomendado')
                        ->label('Recomendado para revisión prioritaria de gerencia')
                        ->helperText('Marque esta opción si la solicitud debe ser revisada con prioridad por gerencia.')
                        ->disabled(fn () => ! (auth()->user()?->hasAnyRole(['admin', 'coordinacion', 'coordinador']) ?? false)),
                    ])
                    ->columns(1),

                    Forms\Components\Section::make('Observaciones de gerencia')
                        ->schema([
                            Forms\Components\Textarea::make('gerencia_observaciones')
                                ->label('Nota de gerencia')
                                ->rows(4)
                                ->disabled()
                                ->dehydrated(false)
                                ->placeholder('Aún no hay observaciones registradas por gerencia.')
                                ->columnSpanFull(),
                        ])
                        ->visible(fn ($record) => filled($record?->gerencia_observaciones))
                        ->columns(1),


            Forms\Components\Section::make('Documentos')
                ->schema([
                    Forms\Components\FileUpload::make('anexo_foto_documento')
                        ->label('Foto tipo documento')
                        ->disk('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                        ->imageEditor()
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') !== 'renovacion'),

                    Forms\Components\FileUpload::make('anexo_doc_identidad')
                        ->label('Documento de identidad')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') !== 'renovacion'),

                    Forms\Components\FileUpload::make('anexo_certificado_bancario')
                        ->label('Certificado bancario')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->directory('postulaciones/anexos')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') !== 'renovacion' || $get('cuenta_actualizada')),

                    Forms\Components\FileUpload::make('pdf_notas')
                        ->label('PDF Notas')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/notas')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') !== 'renovacion'),

                    Forms\Components\FileUpload::make('pdf_matricula')
                        ->label('PDF Matrícula')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('postulaciones/matricula')
                        ->preserveFilenames()
                        ->openable()
                        ->downloadable(false)
                        ->visible(fn ($get) => $get('tipo_postulacion') !== 'renovacion'),

                ])
                ->columns(2),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        $getPendientes = function ($record): array {
            $tipo = $record->tipo_postulacion ?? 'primer_semestre';
            $pendientes = [];

            if ($tipo === 'renovacion') {
                if (empty($record->anexo_certificado_notas)) {
                    $pendientes[] = 'Certificado de notas';
                }

                if (empty($record->anexo_recibo_matricula)) {
                    $pendientes[] = 'Recibo de matrícula';
                }

                if ($record->cuenta_actualizada && empty($record->anexo_certificado_bancario)) {
                    $pendientes[] = 'Certificado bancario';
                }
            } else {
                if (empty($record->anexo_doc_identidad)) {
                    $pendientes[] = 'Documento de identidad';
                }

                if (empty($record->anexo_foto_documento)) {
                    $pendientes[] = 'Foto tipo documento';
                }

                if (empty($record->anexo_certificado_bancario)) {
                    $pendientes[] = 'Certificado bancario';
                }

                if (empty($record->pdf_notas)) {
                    $pendientes[] = 'Notas académicas';
                }

                if (empty($record->pdf_matricula)) {
                    $pendientes[] = 'Recibo de matrícula';
                }

                if (is_null($record->promedio_carrera)) {
                    $pendientes[] = 'Promedio de carrera';
                }
            }

            return $pendientes;
        };

        $semaforoColor = function (int $count): string {
            if ($count === 0) {
                return 'success';
            }

            if ($count <= 2) {
                return 'warning';
            }

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
                    'Postulado' => 'gray',
                    'En estudio' => 'info',
                    'Aprobado' => 'success',
                    'Rechazado' => 'danger',
                    'Cancelado' => 'gray',
                    default => 'gray',
                }),

                        TextEntry::make('tipo_postulacion')
                            ->label('Tipo')
                            ->formatStateUsing(fn ($state) => match ($state) {
                                'primer_semestre' => 'Ingreso a primer semestre',
                                'otro_semestre' => 'Ingreso a otro semestre',
                                'renovacion' => 'Renovación',
                                default => 'N/D',
                            }),

                        TextEntry::make('updated_at')
                            ->label('Última actualización')
                            ->dateTime('Y-m-d H:i'),

                        TextEntry::make('id')
                            ->label('ID'),
                    ]),
                ]),

            InfoSection::make('Pendientes')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('pendientes_count')
                            ->label('Pendientes')
                            ->state(fn ($record) => count($getPendientes($record)))
                            ->badge()
                            ->color(fn ($state) => $semaforoColor((int) $state))
                            ->formatStateUsing(fn ($state) => (int) $state === 0 ? 'Completo' : $state . ' por completar'),

                        TextEntry::make('pendientes_list')
                            ->label('Detalle')
                            ->state(function ($record) use ($getPendientes) {
                                $items = $getPendientes($record);

                                return empty($items)
                                    ? 'Sin pendientes.'
                                    : implode("\n• ", array_merge([''], $items));
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
                                TextEntry::make('estudiante_nombre')
                                    ->label('Nombre'),

                                TextEntry::make('estudiante_email')
                                    ->label('Email')
                                    ->placeholder('N/D'),

                                TextEntry::make('fecha_nacimiento')
                                    ->label('Fecha de nacimiento')
                                    ->date('Y-m-d')
                                    ->placeholder('N/D'),

                                TextEntry::make('tipo_documento')
                                    ->label('Tipo de documento')
                                    ->placeholder('N/D'),

                                TextEntry::make('documento_identidad')
                                    ->label('Documento')
                                    ->placeholder('N/D'),

                                TextEntry::make('telefono_celular')
                                    ->label('Celular')
                                    ->placeholder('N/D'),

                                TextEntry::make('telefono_fijo')
                                    ->label('Fijo')
                                    ->placeholder('N/D'),

                                TextEntry::make('direccion')
                                    ->label('Dirección')
                                    ->placeholder('N/D'),

                                TextEntry::make('barrio')
                                    ->label('Barrio')
                                    ->placeholder('N/D'),

                                TextEntry::make('genero')
                                    ->label('Género')
                                    ->placeholder('N/D'),
                            ])
                            ->columnSpan(2),

                        ImageEntry::make('anexo_foto_documento')
                            ->label('Foto')
                            ->disk('public')
                            ->visibility('public')
                            ->height(180)
                            ->extraImgAttributes(['class' => 'rounded-md border border-gray-200'])
                            ->columnSpan(1)
                            ->visible(fn ($record) => filled($record->anexo_foto_documento)),
                    ]),
                ]),

            InfoSection::make('Puntajes')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('puntaje_saber')
                            ->label('Puntaje Saber 11')
                            ->badge()
                            ->color(fn ($state) => ((float) $state >= 300) ? 'success' : 'danger')
                            ->placeholder('N/D'),

                        TextEntry::make('promedio_universitario')
                            ->label('Promedio acumulado')
                            ->badge()
                            ->color(fn ($state) => ((float) $state >= 3.8) ? 'success' : 'danger')
                            ->placeholder('N/D'),
                    ]),
                ]),

            InfoSection::make('Acudiente')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('nombre_acudiente')
                            ->label('Nombre')
                            ->placeholder('N/D'),

                        TextEntry::make('telefono_acudiente')
                            ->label('Teléfono')
                            ->placeholder('N/D'),
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
                            ->label('Carrera')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'primer_semestre')
                            ->placeholder('N/D'),

                        TextEntry::make('universidad_actual')
                            ->label('Universidad actual')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                            ->placeholder('N/D'),

                        TextEntry::make('carrera_actual')
                            ->label('Carrera')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                            ->placeholder('N/D'),

                        TextEntry::make('semestre_en_curso')
                            ->label('Semestre en curso')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'otro_semestre')
                            ->placeholder('N/D'),
                    ]),
                ]),

            InfoSection::make('Datos bancarios')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('banco')
                            ->label('Banco')
                            ->placeholder('N/D'),

                        TextEntry::make('titular_cuenta')
                            ->label('Titular')
                            ->placeholder('N/D'),

                        TextEntry::make('tipo_cuenta')
                            ->label('Tipo de cuenta')
                            ->placeholder('N/D'),

                        TextEntry::make('numero_cuenta')
                            ->label('Número de cuenta')
                            ->placeholder('N/D'),

                        IconEntry::make('cuenta_actualizada')
                            ->label('Cuenta actualizada')
                            ->boolean()
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion'),
                    ]),
                ]),

            InfoSection::make('Información adicional')
                ->schema([
                    TextEntry::make('como_encontro')
                        ->label(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion'
                            ? 'Recomendación para la fundación o sugerencia'
                            : '¿Cómo encontró la Fundación?'
                        )
                        ->placeholder('Sin respuesta.')
                        ->columnSpanFull(),
                ]),

            InfoSection::make('Perfil descriptivo')
                ->schema([
                    TextEntry::make('perfil_descriptivo')
                        ->label('')
                        ->placeholder('Aún no hay perfil descriptivo registrado.')
                        ->columnSpanFull(),
                ]),

            InfoSection::make('Entrevista')
                ->schema([
                    Grid::make(2)->schema([
                        IconEntry::make('entrevista_recomendado')
                            ->label('Recomendado')
                            ->boolean(),

               

                        TextEntry::make('entrevista_registrada_en')
                            ->label('Fecha de entrevista')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('N/D'),

                        TextEntry::make('entrevista_observaciones')
                            ->label('Observaciones')
                            ->placeholder('Aún no hay observaciones registradas.')
                            ->columnSpanFull(),
                    ]),
                ])
                ->visible(fn ($record) => filled($record->entrevista_observaciones) || filled($record->entrevista_semaforo)),

                            InfoSection::make('Observaciones de gerencia')
                ->schema([
                    TextEntry::make('gerencia_observaciones')
                        ->label('Nota de gerencia')
                        ->placeholder('Aún no hay observaciones registradas por gerencia.')
                        ->columnSpanFull(),

                    TextEntry::make('gerencia_observaciones_en')
                        ->label('Fecha de registro')
                        ->dateTime('d/m/Y H:i')
                        ->placeholder('N/D'),
                ])
                ->visible(fn ($record) => filled($record->gerencia_observaciones)),


            InfoSection::make('Documentos')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('anexo_doc_identidad')
                            ->label('Documento de identidad')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') !== 'renovacion')
                            ->hintAction(
                                InfolistAction::make('ver_doc_identidad')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->anexo_doc_identidad)
                                        ? Storage::disk('public')->url($record->anexo_doc_identidad)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->anexo_doc_identidad))
                            ),

                        TextEntry::make('anexo_certificado_bancario')
                            ->label('Certificado bancario')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->hintAction(
                                InfolistAction::make('ver_cert_bancario')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->anexo_certificado_bancario)
                                        ? Storage::disk('public')->url($record->anexo_certificado_bancario)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->anexo_certificado_bancario))
                            ),

                        TextEntry::make('pdf_notas')
                            ->label('Notas académicas')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') !== 'renovacion')
                            ->hintAction(
                                InfolistAction::make('ver_pdf_notas')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->pdf_notas)
                                        ? Storage::disk('public')->url($record->pdf_notas)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->pdf_notas))
                            ),

                        TextEntry::make('pdf_matricula')
                            ->label('Recibo de matrícula')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') !== 'renovacion')
                            ->hintAction(
                                InfolistAction::make('ver_pdf_matricula')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->pdf_matricula)
                                        ? Storage::disk('public')->url($record->pdf_matricula)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->pdf_matricula))
                            ),

                        TextEntry::make('anexo_certificado_notas')
                            ->label('Certificado de notas')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion')
                            ->hintAction(
                                InfolistAction::make('ver_notas_renovacion')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->anexo_certificado_notas)
                                        ? Storage::disk('public')->url($record->anexo_certificado_notas)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->anexo_certificado_notas))
                            ),

                        TextEntry::make('anexo_recibo_matricula')
                            ->label('Recibo matrícula')
                            ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No adjuntado')
                            ->visible(fn ($record) => ($record->tipo_postulacion ?? '') === 'renovacion')
                            ->hintAction(
                                InfolistAction::make('ver_matricula_renovacion')
                                    ->label('Ver')
                                    ->url(fn ($record) => filled($record->anexo_recibo_matricula)
                                        ? Storage::disk('public')->url($record->anexo_recibo_matricula)
                                        : null
                                    )
                                    ->openUrlInNewTab()
                                    ->visible(fn ($record) => filled($record->anexo_recibo_matricula))
                            ),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query
                    ->orderByDesc('entrevista_recomendado')
                    ->orderBy('promedio_universitario', 'asc')
                    ->latest();
})

            ->recordClasses(function ($record) {
                    $user = auth()->user();

                    if (
                        $user?->hasAnyRole(['gerencia', 'gerente'])
                        && $record->estado === 'En Estudio'
                        && $record->entrevista_recomendado
                    ) {
                        return 'bg-red-50 hover:bg-red-100';
                    }

                    return null;
                })

                 ->recordUrl(fn ($record) => static::getUrl('view', ['record' => $record]))

            ->headerActions([
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

                Action::make('export_pdf_aprobados')
                    ->label('PDF Aprobados (Contabilidad)')
                    ->icon('heroicon-o-banknotes')
                    ->action(function () {
                        $VALOR_APROBADO = Setting::current()->valor_aprobado;

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
    Tables\Columns\TextColumn::make('documento_identidad')
        ->label('Documento')
        ->searchable()
        ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),

    Tables\Columns\TextColumn::make('tipo_documento')
        ->label('Tipo doc.')
        ->badge()
        ->sortable()
        ->toggleable(isToggledHiddenByDefault: true),

    Tables\Columns\TextColumn::make('estudiante_nombre')
    ->label('Postulante')
    ->searchable()
    ->sortable()
    ->limit(45)
    ->tooltip(fn ($record) => $record->estudiante_nombre)
    ->wrap(false),

    Tables\Columns\TextColumn::make('estudiante_email')
        ->label('Email')
        ->searchable()
        ->toggleable(isToggledHiddenByDefault: true),

    Tables\Columns\TextColumn::make('promedio_universitario')
    ->label('Promedio')
    ->badge()
    ->sortable()
    ->alignCenter()
    ->visible(fn () => auth()->user()?->hasRole('admin') ?? false),

    Tables\Columns\TextColumn::make('puntaje_saber')
    ->label('Saber 11')
    ->badge()
    ->sortable()
    ->alignCenter()
    ->visible(fn () => auth()->user()?->hasRole('admin') ?? false),

    Tables\Columns\TextColumn::make('estado')
    ->label('Estado')
    ->badge()
    ->formatStateUsing(fn (string $state): string => match ($state) {
        'Pendiente aprobación gerencia' => 'Pendiente gerencia',
        default => $state,
    })
    ->color(fn (string $state): string => match ($state) {
        'Postulado' => 'warning',
        'En estudio' => 'info',
        'Pendiente aprobación gerencia' => 'primary',
        'Aprobado' => 'success',
        'Rechazado' => 'danger',
        'Cancelado' => 'gray',
        default => 'gray',
    })
    ->sortable(),

Tables\Columns\TextColumn::make('entrevista_observaciones')
    ->label('Observación admin')
    ->limit(45)
    ->tooltip(fn ($record) => $record->entrevista_observaciones)
    ->placeholder('Sin observación')
    ->visible(fn () => auth()->user()?->hasRole('gerencia') ?? false)
    ->toggleable(),

    Tables\Columns\TextColumn::make('observaciones')
    ->label('Motivo')
    ->limit(35)
    ->tooltip(fn ($record) => $record->observaciones)
    ->placeholder('Sin motivo')
    ->visible(fn () => auth()->user()?->hasRole('admin') ?? false)
    ->toggleable(isToggledHiddenByDefault: true),

Tables\Columns\TextColumn::make('entrevista_registrada_en')
    ->label('Fecha entrevista')
    ->dateTime('d/m/Y H:i')
    ->sortable()
    ->visible(fn () => auth()->user()?->hasRole('admin') ?? false)
    ->toggleable(isToggledHiddenByDefault: true),

Tables\Columns\TextColumn::make('observaciones')
    ->label('Motivo')
    ->limit(35)
    ->tooltip(fn ($record) => $record->observaciones)
    ->placeholder('Sin motivo')
    ->visible(fn () => auth()->user()?->hasAnyRole(['admin', 'gerencia']) ?? false)
    ->toggleable(isToggledHiddenByDefault: true),
])

->filters([
    Tables\Filters\Filter::make('cumple_requisitos')
        ->label('Candidatos aptos')
        ->query(fn (Builder $query) => $query
            ->where('promedio_universitario', '>=', 3.8)
            ->where('puntaje_saber', '>=', 300)
        ),

    Tables\Filters\Filter::make('recomendados')
        ->label('Recomendados')
        ->query(fn (Builder $query) => $query->where('entrevista_recomendado', true)),
])
->actions([

    Tables\Actions\EditAction::make()
    ->label('Editar')
    ->icon('heroicon-o-pencil-square')
    ->iconButton()
    ->tooltip('Editar postulación')
    ->visible(fn ($record) => auth()->user()?->hasRole('admin') && static::canEdit($record)),

    Tables\Actions\Action::make('ver_resumen_gerencia')
    ->label('Ver resumen')
    ->icon('heroicon-o-document-text')
    ->iconButton()
    ->tooltip('Ver resumen de la postulación')
    ->color('gray')
    ->visible(fn () => auth()->user()?->hasAnyRole(['admin', 'gerencia']) ?? false)
    ->modalHeading(fn ($record) => 'Resumen de postulación - ' . $record->estudiante_nombre)
    ->modalWidth('7xl')
    ->modalSubmitAction(false)
    ->modalCancelActionLabel('Cerrar')
    ->modalContent(fn ($record) => view('filament.postulaciones.resumen-gerencia', [
        'postulacion' => $record,
    ])),

    Tables\Actions\Action::make('marcar_en_estudio')
        ->label('Marcar en estudio')
        ->icon('heroicon-o-document-magnifying-glass')
        ->iconButton()
        ->tooltip('Marcar solicitud en estudio')
        ->color('info')
        ->requiresConfirmation()
        ->visible(function ($record) {
            return $record
                && auth()->user()?->hasRole('admin')
                && $record->estado === 'Postulado';
        })
        ->action(function ($record) {
            $record->update([
                'estado' => 'En estudio',
                'estado_actualizado_por' => auth()->id(),
                'estado_actualizado_en' => now(),
            ]);

            Notification::make()
                ->title('Solicitud marcada en estudio')
                ->body('La documentación fue validada y la solicitud queda pendiente de entrevista.')
                ->success()
                ->send();
        }),

    Tables\Actions\Action::make('registrar_entrevista')
        ->label('Registrar entrevista')
        ->icon('heroicon-o-clipboard-document-check')
        ->iconButton()
        ->tooltip('Registrar entrevista')
        ->color('info')
        ->visible(function ($record) {
            return $record
                && auth()->user()?->hasRole('admin')
                && $record->estado === 'En estudio';
        })
        ->form([
            Forms\Components\Textarea::make('entrevista_observaciones')
                ->label('Observaciones de la entrevista')
                ->rows(5)
                ->required()
                ->default(fn ($record) => $record->entrevista_observaciones),

            Forms\Components\Checkbox::make('entrevista_recomendado')
                ->label('Recomendado para revisión prioritaria de gerencia')
                ->helperText('Marque esta opción si la solicitud debe ser revisada con prioridad por gerencia.')
                ->default(fn ($record) => (bool) $record->entrevista_recomendado),
        ])
        ->action(function ($record, array $data) {
            $record->update([
                'entrevista_observaciones' => $data['entrevista_observaciones'],
                'entrevista_recomendado' => $data['entrevista_recomendado'] ?? false,
                'entrevista_registrada_por' => auth()->id(),
                'entrevista_registrada_en' => now(),

                // Después de registrar entrevista, pasa a gerencia.
                'estado' => 'Pendiente aprobación gerencia',
                'estado_actualizado_por' => auth()->id(),
                'estado_actualizado_en' => now(),
            ]);

            Notification::make()
                ->title('Entrevista registrada correctamente')
                ->body('La solicitud quedó pendiente de aprobación por gerencia.')
                ->success()
                ->send();
        }),

    Tables\Actions\Action::make('observaciones_gerencia')
    ->label('Observación gerencia')
    ->icon('heroicon-o-chat-bubble-left-right')
    ->iconButton()
    ->tooltip('Registrar observación de gerencia')
    ->color('warning')
    ->visible(function ($record) {
        return $record
            && auth()->user()?->hasAnyRole([ 'gerencia'])
            && $record->estado === 'Pendiente aprobación gerencia';
    })
    ->form([
        Forms\Components\Textarea::make('gerencia_observaciones')
            ->label('Observaciones de gerencia')
            ->helperText('Campo opcional para dejar comentarios internos antes de aprobar o rechazar la solicitud.')
            ->rows(5)
            ->maxLength(5000)
            ->default(fn ($record) => $record->gerencia_observaciones),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'gerencia_observaciones' => $data['gerencia_observaciones'] ?? null,
            'gerencia_observaciones_por' => auth()->id(),
            'gerencia_observaciones_en' => now(),
        ]);

        Notification::make()
            ->title('Observación de gerencia guardada')
            ->success()
            ->send();
    }),

    Tables\Actions\Action::make('aprobar')
    ->label('Aprobar')
    ->icon('heroicon-o-check-circle')
    ->iconButton()
    ->tooltip('Aprobar postulación')
    ->color('success')
    ->requiresConfirmation()
    ->visible(function ($record) {
        return $record
            && auth()->user()?->hasAnyRole(['admin', 'gerencia'])
            && $record->estado === 'Pendiente aprobación gerencia'
            && filled($record->entrevista_observaciones);
    })
    ->action(function ($record) {
        $record->update([
            'estado' => 'Aprobado',
            'estado_actualizado_por' => auth()->id(),
            'estado_actualizado_en' => now(),
        ]);

        Notification::make()
            ->title('Postulación aprobada')
            ->body('La postulación fue aprobada correctamente.')
            ->success()
            ->send();
    }),

    Tables\Actions\Action::make('rechazar')
    ->label('Rechazar')
    ->icon('heroicon-o-x-circle')
    ->iconButton()
    ->tooltip('Rechazar solicitud')
    ->color('danger')
    ->requiresConfirmation()
    ->visible(function ($record) {
        return $record
            && auth()->user()?->hasAnyRole(['admin', 'gerencia'])
            && $record->estado === 'Pendiente aprobación gerencia';
    })
    ->form([
        Forms\Components\Textarea::make('motivo_rechazo')
            ->label('Motivo del rechazo')
            ->rows(4)
            ->required(),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'estado' => 'Rechazado',
            'observaciones' => $data['motivo_rechazo'],
            'estado_actualizado_por' => auth()->id(),
            'estado_actualizado_en' => now(),
        ]);

        Notification::make()
            ->title('Solicitud rechazada')
            ->body('La solicitud fue rechazada correctamente.')
            ->danger()
            ->send();
    }),

Tables\Actions\Action::make('cancelar')
    ->label('Cancelar')
    ->icon('heroicon-o-no-symbol')
    ->iconButton()
    ->tooltip('Cancelar solicitud')
    ->color('gray')
    ->requiresConfirmation()
    ->modalHeading('Cancelar solicitud')
    ->modalDescription('La solicitud quedará anulada y no continuará el proceso. La información se conservará para trazabilidad.')
    ->visible(function ($record) {
        return $record
            && auth()->user()?->hasRole('admin')
            && in_array($record->estado, [
                'Postulado',
                'En estudio',
                'Pendiente aprobación gerencia',
            ], true);
    })
    ->form([
        Forms\Components\Textarea::make('motivo_cancelacion')
            ->label('Motivo de cancelación')
            ->rows(4)
            ->required(),
    ])
    ->action(function ($record, array $data) {
        $record->update([
            'estado' => 'Cancelado',
            'observaciones' => $data['motivo_cancelacion'],
            'estado_actualizado_por' => auth()->id(),
            'estado_actualizado_en' => now(),
        ]);

        Notification::make()
            ->title('Solicitud cancelada')
            ->body('La solicitud fue marcada como cancelada.')
            ->success()
            ->send();
    }),
])
->recordAction('ver_resumen_gerencia')
->recordUrl(null)
->bulkActions([]);

}
       

    public static function getGloballySearchableAttributes(): array
    {
        return ['estudiante_nombre', 'estudiante_email', 'documento_identidad'];
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