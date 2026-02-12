<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
            color: #111; 
        }

        .header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom: 12px;
        }

        .title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .meta {
            font-size: 10px;
            color:#555;
            text-align:right;
        }

        table {
            width:100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align:left;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
            display:inline-block;
            font-weight: bold;
        }

        .pendiente { background:#FEF3C7; }
        .aprobado { background:#D1FAE5; }
        .rechazado { background:#FECACA; }
        .entregado { background:#DBEAFE; }

        .small {
            font-size: 9px;
            color:#555;
        }

        .footer {
            margin-top:20px;
            font-size:9px;
            color:#777;
            text-align:center;
        }
    </style>
</head>
<body>

<div class="header">
    <div>
        <img src="{{ public_path('brand/logo.png') }}" style="height:48px;">
    </div>

    <div class="meta">
        <div><strong>{{ $titulo }}</strong></div>
        <div>Fecha generación: {{ $fecha->format('Y-m-d H:i') }}</div>
    </div>
</div>

<h1 class="title">{{ $titulo }}</h1>

<p style="margin:6px 0 12px 0; color:#444;">
    Total registros: <strong>{{ $kits->count() }}</strong>
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Colaborador</th>
            <th>Documento</th>
            <th>Niño</th>
            <th>Edad</th>
            <th>Grado</th>
            <th>Institución</th>
            <th>Estado</th>
            <th>Aprobación</th>
        </tr>
    </thead>

    <tbody>
        @foreach($kits as $k)

            @php
                $estado = $k->estado ?? 'Pendiente';

                $badgeClass = match($estado) {
                    'Pendiente' => 'pendiente',
                    'Aprobado' => 'aprobado',
                    'Rechazado' => 'rechazado',
                    'Entregado' => 'entregado',
                    default => '',
                };
            @endphp

            <tr>
                <td>{{ $k->id }}</td>
                <td>{{ $k->colaborador_nombre }}</td>
                <td>{{ $k->colaborador_documento }}</td>
                <td>{{ $k->nino_nombre }}</td>
                <td>{{ $k->edad }}</td>
                <td>{{ $k->grado }}</td>
                <td>{{ $k->institucion }}</td>

                <td>
                    <span class="badge {{ $badgeClass }}">
                        {{ $estado }}
                    </span>
                </td>

                <td class="small">
                    @if($estado === 'Aprobado' || $estado === 'Entregado')
                        <strong>Por:</strong> {{ $k->aprobador->name ?? 'N/A' }}<br>
                        <strong>Fecha:</strong> 
                        {{ optional($k->fecha_aprobacion)->format('d/m/Y H:i') }}
                    @elseif($estado === 'Rechazado')
                        <strong>Motivo:</strong><br>
                        {{ $k->observaciones ?? 'Sin observaciones' }}
                    @else
                        —
                    @endif
                </td>
            </tr>

        @endforeach
    </tbody>
</table>

<div class="footer">
    Fundación Proseguir © {{ date('Y') }} — Documento generado automáticamente por el sistema.
</div>

</body>
</html>
