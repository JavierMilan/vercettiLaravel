<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | Vercetti Properties</title>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: #0a0a0a;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      font-family: 'Raleway', sans-serif;
    }
    .login-box {
      background: #111;
      border: 1px solid #c8a84b;
      padding: 2.5rem 3rem;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    .login-box h1 {
      color: #c8a84b;
      font-family: 'Cinzel', serif;
      font-size: 1.4rem;
      margin-bottom: 0.3rem;
    }
    .login-box p {
      color: #888;
      font-size: 0.85rem;
      margin-bottom: 2rem;
    }
    .login-box input {
      width: 100%;
      padding: 0.75rem 1rem;
      margin-bottom: 1rem;
      background: #1a1a1a;
      border: 1px solid #333;
      color: #fff;
      font-size: 1rem;
    }
    .login-box input:focus { outline: none; border-color: #c8a84b; }
    .login-box button {
      width: 100%;
      padding: 0.85rem;
      background: #c8a84b;
      color: #000;
      font-family: 'Cinzel', serif;
      font-weight: 700;
      font-size: 1rem;
      border: none;
      cursor: pointer;
      letter-spacing: 2px;
    }
    .login-box button:hover { background: #e0c060; }
    .error {
      background: #3a1a1a;
      border: 1px solid #c0392b;
      color: #e74c3c;
      padding: 0.75rem;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>VERCETTI PROPERTIES</h1>
    <p>Acceso restringido — Solo personal autorizado</p>

    @if($errors->has('login'))
      <div class="error">{{ $errors->first('login') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <input type="text" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}">
      <input type="password" name="password" placeholder="Contraseña">
      <button type="submit">ENTRAR</button>
    </form>
  </div>
</body>
</html>