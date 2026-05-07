<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Vercetti Properties - Listado</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #0a0a0a; color: #ccc; font-family: Helvetica, sans-serif; font-size: 11px; }

    .header {
      background: #0a0a0a;
      padding: 15px 20px;
      border-bottom: 2px solid #c8a84b;
      margin-bottom: 20px;
    }
    .header h1 { color: #c8a84b; font-size: 18px; letter-spacing: 4px; text-align: center; }
    .header p  { color: #888; font-size: 9px; text-align: center; margin-top: 4px; }

    .meta { text-align: right; color: #666; font-size: 9px; margin-bottom: 15px; }

    table { width: 100%; border-collapse: collapse; font-size: 9px; }
    thead { background: #1a1a1a; }
    thead th { padding: 8px 6px; text-align: left; color: #c8a84b; font-size: 8px; letter-spacing: 1px; border: 1px solid #333; }
    tbody tr:nth-child(even) { background: #111; }
    tbody tr:nth-child(odd)  { background: #0d0d0d; }
    tbody td { padding: 6px; color: #bbb; border: 1px solid #222; vertical-align: middle; }

    .resumen {
      margin-top: 20px;
      border-top: 1px solid #c8a84b;
      padding-top: 12px;
    }
    .resumen h2 { color: #c8a84b; font-size: 10px; letter-spacing: 2px; margin-bottom: 8px; }
    .resumen p  { color: #999; font-size: 9px; line-height: 1.8; }

    .footer {
      margin-top: 20px;
      border-top: 1px solid #333;
      padding-top: 8px;
      text-align: center;
      color: #555;
      font-size: 8px;
      font-style: italic;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>VERCETTI PROPERTIES</h1>
    <p>Luxury Real Estate — Vice City</p>
  </div>

  <div class="meta">
    Generado el {{ date('d/m/Y H:i') }} &nbsp;|&nbsp; Total propiedades: {{ count($propiedades) }}
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Título</th>
        <th>Zona</th>
        <th>Tipo</th>
        <th>Precio ($)</th>
        <th>m²</th>
        <th>Hab.</th>
        <th>Amueblada</th>
        <th>Propietario</th>
      </tr>
    </thead>
    <tbody>
      @foreach($propiedades as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->titulo }}</td>
          <td>{{ $p->zona }}</td>
          <td>{{ $p->tipo_inmueble }}</td>
          <td>${{ number_format($p->precio, 0, '.', ',') }}</td>
          <td>{{ $p->metros_cuadrados }}</td>
          <td>{{ $p->num_habitaciones ?? '—' }}</td>
          <td>{{ $p->amueblada ? 'Sí' : 'No' }}</td>
          <td>{{ $p->propietario->nombre }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @php
    $total     = count($propiedades);
    $precios   = $propiedades->pluck('precio');
    $media     = $precios->avg();
    $maximo    = $precios->max();
    $minimo    = $precios->min();
  @endphp

  <div class="resumen">
    <h2>RESUMEN</h2>
    <p>Total propiedades: {{ $total }}</p>
    <p>Precio medio: ${{ number_format($media, 0, '.', ',') }}</p>
    <p>Precio más alto: ${{ number_format($maximo, 0, '.', ',') }}</p>
    <p>Precio más bajo: ${{ number_format($minimo, 0, '.', ',') }}</p>
  </div>

  <div class="footer">
    Todas las propiedades son de adquisición totalmente legítima.
  </div>

</body>
</html>