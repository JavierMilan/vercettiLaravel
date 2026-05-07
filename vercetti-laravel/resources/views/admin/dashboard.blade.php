<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Vercetti Properties</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #0a0a0a; color: #ccc; font-family: 'Raleway', sans-serif; min-height: 100vh; }

    .admin-header {
      background: #111;
      border-bottom: 2px solid #c8a84b;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .admin-header h1 { font-family: 'Cinzel', serif; color: #c8a84b; font-size: 1.3rem; letter-spacing: 3px; }
    .admin-header-right { display: flex; align-items: center; gap: 1.5rem; }
    .admin-header span { color: #888; font-size: 0.9rem; }
    .admin-header span strong { color: #c8a84b; }

    .admin-main { padding: 2rem; max-width: 1400px; margin: 0 auto; }

    .actions-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .actions-bar h2 { font-family: 'Cinzel', serif; color: #fff; font-size: 1.1rem; letter-spacing: 2px; }
    .actions-bar h2 span { color: #c8a84b; }
    .btn-group { display: flex; gap: 0.75rem; flex-wrap: wrap; }

    .btn { padding: 0.6rem 1.2rem; font-family: 'Cinzel', serif; font-size: 0.75rem; letter-spacing: 1px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
    .btn-gold { background: #c8a84b; color: #000; }
    .btn-gold:hover { background: #e0c060; }
    .btn-outline { background: transparent; color: #c8a84b; border: 1px solid #c8a84b; }
    .btn-outline:hover { background: #c8a84b; color: #000; }
    .btn-danger { background: transparent; color: #e74c3c; border: 1px solid #e74c3c; font-size: 0.7rem; padding: 0.4rem 0.8rem; }
    .btn-danger:hover { background: #e74c3c; color: #fff; }
    .btn-edit { background: transparent; color: #c8a84b; border: 1px solid #444; font-size: 0.7rem; padding: 0.4rem 0.8rem; }
    .btn-edit:hover { border-color: #c8a84b; }
    .btn-logout { background: transparent; color: #888; border: 1px solid #333; font-size: 0.7rem; padding: 0.4rem 0.9rem; }
    .btn-logout:hover { color: #e74c3c; border-color: #e74c3c; }

    .table-wrapper { overflow-x: auto; border: 1px solid #222; }
    table { width: 100%; border-collapse: collapse; font-size: 0.88rem; }
    thead { background: #1a1a1a; border-bottom: 2px solid #c8a84b; }
    thead th { padding: 1rem 0.75rem; text-align: left; font-family: 'Cinzel', serif; color: #c8a84b; font-size: 0.75rem; letter-spacing: 1px; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #1a1a1a; transition: background 0.15s; }
    tbody tr:hover { background: #111; }
    tbody td { padding: 0.85rem 0.75rem; color: #bbb; vertical-align: middle; }
    tbody td img { width: 60px; height: 45px; object-fit: cover; border: 1px solid #333; }
    .badge { padding: 0.2rem 0.6rem; font-size: 0.7rem; font-family: 'Cinzel', serif; letter-spacing: 1px; border: 1px solid #333; color: #c8a84b; white-space: nowrap; }
    .td-acciones { display: flex; gap: 0.5rem; align-items: center; }

    .flash { padding: 0.85rem 1.2rem; margin-bottom: 1.5rem; font-size: 0.9rem; border-left: 3px solid; }
    .flash-ok  { background: #0d2b1a; border-color: #2ecc71; color: #2ecc71; }
  </style>
</head>
<body>

<header class="admin-header">
  <h1>PANEL DE ADMINISTRADOR</h1>
  <div class="admin-header-right">
    <span>Bienvenido, <strong>{{ session('admin_usuario') }}</strong></span>
    <a href="{{ route('logout') }}" class="btn btn-logout">SALIR</a>
  </div>
</header>

<main class="admin-main">

  @if(session('ok'))
    <div class="flash flash-ok">
      @php
        $msgs = [
          'creada'    => '✔ Propiedad creada correctamente.',
          'editada'   => '✔ Propiedad actualizada correctamente.',
          'eliminada' => '✔ Propiedad eliminada correctamente.',
        ];
      @endphp
      {{ $msgs[session('ok')] ?? 'Operación realizada.' }}
    </div>
  @endif

  <div class="actions-bar">
    <h2>PROPIEDADES <span>({{ count($propiedades) }})</span></h2>
    <div class="btn-group">
      <a href="{{ route('admin.crear') }}" class="btn btn-gold">+ NUEVA PROPIEDAD</a>
      <a href="{{ route('admin.pdf') }}" class="btn btn-outline">⬇ EXPORTAR PDF</a>
    </div>
  </div>

  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Imagen</th>
          <th>Título</th>
          <th>Zona</th>
          <th>Tipo</th>
          <th>Precio</th>
          <th>m²</th>
          <th>Hab.</th>
          <th>Propietario</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($propiedades as $p)
          <tr>
            <td>{{ $p->id }}</td>
            <td><img src="{{ asset($p->imagen) }}" alt="{{ $p->titulo }}"></td>
            <td>{{ $p->titulo }}</td>
            <td>{{ $p->zona }}</td>
            <td><span class="badge">{{ $p->tipo_inmueble }}</span></td>
            <td>${{ number_format($p->precio, 0, '.', ',') }}</td>
            <td>{{ $p->metros_cuadrados }}</td>
            <td>{{ $p->num_habitaciones ?? '—' }}</td>
            <td>{{ $p->propietario->nombre }}</td>
            <td>
              <div class="td-acciones">
                <a href="{{ route('admin.editar', $p->id) }}" class="btn btn-edit">EDITAR</a>
                <form method="POST" action="{{ route('admin.destroy', $p->id) }}"
                      onsubmit="return confirm('¿Eliminar esta propiedad?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">ELIMINAR</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10" style="text-align:center; padding:2rem; color:#555;">
              No hay propiedades en la base de datos.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</main>
</body>
</html>