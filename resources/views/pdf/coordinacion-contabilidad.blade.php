<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom: 10px; }
        .title { font-size: 16px; font-weight: 700; margin: 0; }
        .meta { font-size: 10px; color:#555; text-align:right; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f3f4f6; text-align:left; }
        .sign { margin-top: 22px; width: 100%; }
        .sign td { border: none; padding-top: 28px; }
        .line { border-top: 1px solid #111; width: 90%; }
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

<p style="margin:6px 0 0 0; color:#444;">
    Valor aprobado (fijo): <strong>${{ number_format($VALOR_APROBADO, 0, ',', '.') }}</strong>
</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Banco</th>
        <th>Tipo de cuenta</th>
        <th>Número de cuenta</th>
        <th>Valor aprobado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($postulaciones as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->estudiante_nombre }}</td>
            <td>{{ $p->documento_identidad ?: 'N/D' }}</td>
            <td>{{ $p->banco ?: 'N/D' }}</td>
            <td>{{ $p->tipo_cuenta ?: 'N/D' }}</td>
            <td>{{ $p->numero_cuenta ?: 'N/D' }}</td>
            <td>${{ number_format($VALOR_APROBADO, 0, ',', '.') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="sign">
    <tr>
        <td style="width:50%; text-align:center;">
            <div class="line"></div>
            <div style="margin-top:6px;"><strong>Firma Gerencia</strong></div>
        </td>
        <td style="width:50%; text-align:center;">
            <div class="line"></div>
            <div style="margin-top:6px;"><strong>Firma Coordinación Fundación</strong></div>
        </td>
    </tr>
</table>

</body>
</html>
