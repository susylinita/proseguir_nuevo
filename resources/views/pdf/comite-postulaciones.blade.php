<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte Comité - Postulaciones</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .h1 { font-size: 18px; font-weight: bold; margin-bottom: 6px; }
        .muted { color: #666; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f3f4f6; text-align: left; }
    </style>
</head>
<body>
    <div class="h1">Reporte Comité - Postulaciones</div>
    <div class="muted">Generado: {{ now()->format('Y-m-d H:i') }}</div>

    <table>
        <thead>
        <tr>
            <th>#</th>
            <th>Postulante</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Saber</th>
            <th>Prom. Univ</th>
            <th>Prom. Carrera</th>
        </tr>
        </thead>
        <tbody>
        @foreach($postulaciones as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->estudiante_nombre }}</td>
                <td>{{ $p->estudiante_email }}</td>
                <td>{{ $p->tipo_postulacion }}</td>
                <td>{{ $p->estado }}</td>
                <td>{{ $p->puntaje_saber }}</td>
                <td>{{ $p->promedio_universitario }}</td>
                <td>{{ $p->promedio_carrera }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
