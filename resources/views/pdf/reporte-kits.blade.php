<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Entregas - Fundación Proseguir</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2 f2 f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fundación Proseguir</h1>
        <h2>Reporte General de Entrega de Kits Escolares</h2>
        <p>Fecha de generación: {{ $fecha }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Grado</th>
                <th>Tipo de Kit</th>
                <th>Fecha de Entrega</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kits as $kit)
            <tr>
                <td>{{ $kit->nombre_estudiante }}</td>
                <td>{{ $kit->grado_escolar }}</td>
                <td>{{ $kit->tipo_kit }}</td>
                <td>{{ $kit->fecha_entrega }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>