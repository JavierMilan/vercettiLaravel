<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Propiedad | Vercetti Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #0a0a0a; color: #ccc; font-family: 'Raleway', sans-serif; min-height: 100vh; }
    .admin-header { background: #111; border-bottom: 2px solid #c8a84b; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
    .admin-header h1 { font-family: 'Cinzel', serif; color: #c8a84b; font-size: 1.3rem; letter-spacing: 3px; }
    .btn { padding: 0.6rem 1.2rem; font-family: 'Cinzel', serif; font-size: 0.75rem; letter-spacing: 1px; font-weight: 700; border: none; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
    .btn-outline { background: transparent; color: #c8a84b; border: 1px solid #c8a84b; }
    .btn-outline:hover { background: #c8a84b; color: #000; }
    .btn-gold { background: #c8a84b; color: #000; }
    .btn-gold:hover { background: #e0c060; }

    .form-container { max-width: 800px; margin: 2.5rem auto; padding: 0 2rem; }
    .form-container h2 { font-family: 'Cinzel', serif; color: #fff; font-size: 1.1rem; letter-spacing: 2px; margin-bottom: 2rem; }
    .form-container h2 span { color: #c8a84b; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 0.78rem; color: #888; letter-spacing: 1px; text-transform: uppercase; }
    .form-group label span { color: #e74c3c; }
    .form-group input,
    .form-group select,
    .form-group textarea { background: #1a1a1a; border: 1px solid #333; color: #fff; padding: 0.7rem 1rem; font-family: 'Raleway', sans-serif; font-size: 0.95rem; }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus { outline: none; border-color: #c8a84b; }
    .form-group textarea { resize: vertical; min-height: 100px; }
    .form-check { display: flex; align-items: center; gap: 0.75rem; margin-top: 0.3rem; }
    .form-check input { width: 18px; height: 18px; accent-color: #c8a84b; }
    .form-check label { font-size: 0.9rem; color: #ccc; text-transform: none; letter-spacing: 0; }
    .form-actions { margin-top: 2rem; display: flex; gap: 1rem; }
    .error-msg { color: #e74c3c; font-size: 0.78rem; margin-top: 0.2rem; }
  </style>
</head>
<body>

<header class="admin-header">
  <h1>PANEL DE ADMINISTRADOR</h1>
  <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">← VOLVER</a>
</header>

<div class="form-container">
  <h2>EDITAR <span>PROPIEDAD</span></h2>

  <form method="POST" action="{{ route('admin.update', $propiedad->id) }}">
    @csrf
    @method('PUT')
    <div class="form-grid">

      <div class="form-group full">
        <label>Título <span>*</span></label>
        <input type="text" name="titulo" value="{{ old('titulo', $propiedad->titulo) }}">
        @error('titulo') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Zona <span>*</span></label>
        <select name="zona">
          <option value="">Seleccionar...</option>
          @foreach(['Ocean Beach','Washington Beach','Vice Point','Downtown','Little Havana','Little Haiti','Starfish Island','Prawn Island','Vice Port','Leaf Links'] as $zona)
            <option value="{{ $zona }}" {{ old('zona', $propiedad->zona) === $zona ? 'selected' : '' }}>{{ $zona }}</option>
          @endforeach
        </select>
        @error('zona') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Tipo de inmueble <span>*</span></label>
        <select name="tipo_inmueble">
          <option value="">Seleccionar...</option>
          @foreach(['Casa','Edificio','Local','Garage'] as $tipo)
            <option value="{{ $tipo }}" {{ old('tipo_inmueble', $propiedad->tipo_inmueble) === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
          @endforeach
        </select>
        @error('tipo_inmueble') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Precio ($) <span>*</span></label>
        <input type="number" name="precio" min="0" value="{{ old('precio', $propiedad->precio) }}">
        @error('precio') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Metros cuadrados <span>*</span></label>
        <input type="number" name="metros_cuadrados" min="0" value="{{ old('metros_cuadrados', $propiedad->metros_cuadrados) }}">
        @error('metros_cuadrados') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Habitaciones</label>
        <input type="number" name="num_habitaciones" min="0" value="{{ old('num_habitaciones', $propiedad->num_habitaciones) }}">
      </div>

      <div class="form-group">
        <label>Fecha de construcción <span>*</span></label>
        <input type="date" name="fecha_construccion" value="{{ old('fecha_construccion', $propiedad->fecha_construccion) }}">
        @error('fecha_construccion') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group">
        <label>Propietario <span>*</span></label>
        <select name="propietario_id">
          <option value="">Seleccionar...</option>
          @foreach($propietarios as $prop)
            <option value="{{ $prop->id }}" {{ old('propietario_id', $propiedad->propietario_id) == $prop->id ? 'selected' : '' }}>
              {{ $prop->nombre }}
            </option>
          @endforeach
        </select>
        @error('propietario_id') <span class="error-msg">{{ $message }}</span> @enderror
      </div>

      <div class="form-group full">
        <label>Ruta de imagen</label>
        <input type="text" name="imagen" placeholder="imagenes/propiedadesVC/nombre.jpg"
               value="{{ old('imagen', $propiedad->imagen) }}">
      </div>

      <div class="form-group full">
        <label>Descripción</label>
        <textarea name="descripcion">{{ old('descripcion', $propiedad->descripcion) }}</textarea>
      </div>

      <div class="form-group full">
        <div class="form-check">
          <input type="checkbox" name="amueblada" id="amueblada" value="1"
            {{ old('amueblada', $propiedad->amueblada) ? 'checked' : '' }}>
          <label for="amueblada">Amueblada</label>
        </div>
      </div>

    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-gold">GUARDAR CAMBIOS</button>
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">CANCELAR</a>
    </div>
  </form>
</div>

</body>
</html>