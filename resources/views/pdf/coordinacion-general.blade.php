<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom: 12px; }
        .title { font-size: 16px; font-weight: 700; margin: 0; }
        .meta { font-size: 10px; color:#555; text-align:right; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; vertical-align: top; }
        th { background: #f3f4f6; text-align:left; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 10px; display:inline-block; }
        .pendiente { background:#FEF3C7; }
        .entrevista { background:#DBEAFE; }
        .aprobado { background:#D1FAE5; }
        .rechazado { background:#FEE2E2; }
    </style>
</head>
<body>

<div class="header">
    <div>
        <img src="{{ public_path('brand/logo.png') }}" style="height:48px;">
    </div>
    <div class="meta">
        <div><strong>{{ $titulo }}</strong></div>
        <div>Fecha: {{ $fecha->format('Y-m-d H:i') }}</div>
    </div>
</div>

<h1 class="title">{{ $titulo }}</h1>

<p style="margin:6px 0 12px 0; color:#444;">
    Total registros: <strong>{{ $postulaciones->count() }}</strong>
</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Teléfono</th>
        <th>Universidad / Carrera</th>
    </tr>
    </thead>
    <tbody>
    @foreach($postulaciones as $p)
        @php
            $badgeClass = match($p->estado) {
                'Pendiente' => 'pendiente',
                'Entrevista' => 'entrevista',
                'Aprobado' => 'aprobado',
                'Rechazado' => 'rechazado',
                default => '',
            };
            $tipoLabel = match($p->tipo_postulacion) {
                'primer_semestre' => 'Primer semestre',
                'otro_semestre' => 'Otro semestre',
                'renovacion' => 'Renovación',
                default => 'N/D',
            };
            $uniCarr = $p->tipo_postulacion === 'primer_semestre'
                ? trim(($p->universidad_aplica ?? '').' / '.($p->carrera_aplica ?? ''))
                : trim(($p->universidad_actual ?? '').' / '.($p->carrera_actual ?? ''));
        @endphp
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->estudiante_nombre }}</td>
            <td>{{ $p->documento_identidad ?: 'N/D' }}</td>
            <td>{{ $tipoLabel }}</td>
            <td><span class="badge {{ $badgeClass }}">{{ $p->estado }}</span></td>
            <td>{{ $p->telefono_celular ?: 'N/D' }}</td>
            <td>{{ $uniCarr ?: 'N/D' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
