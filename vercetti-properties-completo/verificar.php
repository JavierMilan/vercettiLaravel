<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación del Proyecto - Vercetti Properties</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
        }
        h1 {
            color: #FF6B9D;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        .check-item {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #ccc;
            background: #f9f9f9;
        }
        .check-item.success {
            background: #d4edda;
            border-left-color: #28a745;
        }
        .check-item.error {
            background: #f8d7da;
            border-left-color: #dc3545;
        }
        .check-item.warning {
            background: #fff3cd;
            border-left-color: #ffc107;
        }
        .icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
        .summary {
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            text-align: center;
        }
        .summary h2 { margin-bottom: 10px; }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #FF6B9D;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn:hover { background: #ff8fa3; }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificación del Proyecto</h1>
        <p class="subtitle">Vercetti Properties - Vice City Real Estate</p>

        <?php
        $checks = [];
        $errors = 0;
        $warnings = 0;
        $success = 0;

        // 1. Verificar archivos PHP principales
        $php_files = ['index.php', 'resultados.php', 'propiedades.php', 'detalle.php'];
        foreach ($php_files as $file) {
            if (file_exists($file)) {
                $checks[] = ['success', "✅ Archivo <code>$file</code> existe"];
                $success++;
            } else {
                $checks[] = ['error', "❌ Archivo <code>$file</code> NO encontrado"];
                $errors++;
            }
        }

        // 2. Verificar archivos CSS
        $css_files = ['styles.css', 'cabecera.css', 'hall.css', 'formulario.css', 'resultados.css', 'detalle.css'];
        foreach ($css_files as $file) {
            if (file_exists($file)) {
                $checks[] = ['success', "✅ CSS <code>$file</code> existe"];
                $success++;
            } else {
                $checks[] = ['warning', "⚠️ CSS <code>$file</code> NO encontrado"];
                $warnings++;
            }
        }

        // 3. Verificar conexión
        if (file_exists('config/conexion.php')) {
            $checks[] = ['success', "✅ Archivo <code>config/conexion.php</code> existe"];
            $success++;
            
            // Intentar conectar
            try {
                require_once 'config/conexion.php';
                $checks[] = ['success', "✅ Conexión a base de datos exitosa"];
                $success++;
                
                // Verificar tablas
                $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                if (in_array('propiedades', $tables) && in_array('propietarios', $tables)) {
                    $checks[] = ['success', "✅ Tablas <code>propiedades</code> y <code>propietarios</code> existen"];
                    $success++;
                    
                    // Contar registros
                    $count_prop = $pdo->query("SELECT COUNT(*) FROM propiedades")->fetchColumn();
                    $count_owners = $pdo->query("SELECT COUNT(*) FROM propietarios")->fetchColumn();
                    
                    if ($count_prop >= 30) {
                        $checks[] = ['success', "✅ Base de datos contiene $count_prop propiedades (mínimo: 30)"];
                        $success++;
                    } else {
                        $checks[] = ['error', "❌ Solo hay $count_prop propiedades (se requieren 30 mínimo)"];
                        $errors++;
                    }
                    
                    $checks[] = ['success', "✅ Base de datos contiene $count_owners propietarios"];
                    $success++;
                    
                } else {
                    $checks[] = ['error', "❌ Las tablas no existen. Importa <code>database.sql</code>"];
                    $errors++;
                }
                
            } catch (PDOException $e) {
                $checks[] = ['error', "❌ Error de conexión: " . $e->getMessage()];
                $checks[] = ['warning', "⚠️ Verifica las credenciales en <code>config/conexion.php</code>"];
                $errors++;
                $warnings++;
            }
        } else {
            $checks[] = ['error', "❌ Archivo <code>config/conexion.php</code> NO encontrado"];
            $errors++;
        }

        // 4. Verificar carpeta de imágenes
        if (is_dir('imagenes')) {
            $checks[] = ['success', "✅ Carpeta <code>imagenes/</code> existe"];
            $success++;
            
            $img_files = ['vercettiLogo.png', 'logoVice.png', 'fondoVice1080.png'];
            foreach ($img_files as $img) {
                if (file_exists("imagenes/$img")) {
                    $checks[] = ['success', "✅ Imagen <code>$img</code> encontrada"];
                    $success++;
                } else {
                    $checks[] = ['warning', "⚠️ Imagen <code>$img</code> NO encontrada"];
                    $warnings++;
                }
            }
            
            if (is_dir('imagenes/propiedadesVC')) {
                $prop_images = count(glob('imagenes/propiedadesVC/*'));
                if ($prop_images > 0) {
                    $checks[] = ['success', "✅ Carpeta <code>propiedadesVC/</code> contiene $prop_images imágenes"];
                    $success++;
                } else {
                    $checks[] = ['warning', "⚠️ Carpeta <code>propiedadesVC/</code> está vacía"];
                    $warnings++;
                }
            } else {
                $checks[] = ['warning', "⚠️ Carpeta <code>imagenes/propiedadesVC/</code> NO existe"];
                $warnings++;
            }
        } else {
            $checks[] = ['error', "❌ Carpeta <code>imagenes/</code> NO existe"];
            $errors++;
        }

        // 5. Verificar carpeta de fuentes
        if (is_dir('fonts')) {
            $checks[] = ['success', "✅ Carpeta <code>fonts/</code> existe"];
            $success++;
            
            if (file_exists('fonts/rageitalic.ttf')) {
                $checks[] = ['success', "✅ Fuente <code>rageitalic.ttf</code> encontrada"];
                $success++;
            } else {
                $checks[] = ['warning', "⚠️ Fuente <code>rageitalic.ttf</code> NO encontrada"];
                $warnings++;
            }
        } else {
            $checks[] = ['warning', "⚠️ Carpeta <code>fonts/</code> NO existe"];
            $warnings++;
        }

        // 6. Verificar .htaccess
        if (file_exists('.htaccess')) {
            $checks[] = ['success', "✅ Archivo <code>.htaccess</code> existe"];
            $success++;
        } else {
            $checks[] = ['warning', "⚠️ Archivo <code>.htaccess</code> NO encontrado (opcional)"];
            $warnings++;
        }

        // Mostrar resultados
        foreach ($checks as $check) {
            echo "<div class='check-item {$check[0]}'>{$check[1]}</div>";
        }
        ?>

        <div class="summary">
            <h2>📊 Resumen de Verificación</h2>
            <p style="font-size: 1.2rem; margin: 15px 0;">
                <strong><?php echo $success; ?></strong> exitosas | 
                <strong><?php echo $warnings; ?></strong> advertencias | 
                <strong><?php echo $errors; ?></strong> errores
            </p>
            
            <?php if ($errors == 0 && $warnings == 0): ?>
                <p style="font-size: 1.3rem; margin-top: 15px;">
                    🎉 <strong>¡Perfecto! Tu proyecto está listo.</strong>
                </p>
                <a href="index.php" class="btn">Ir a la Página Principal →</a>
            <?php elseif ($errors == 0): ?>
                <p style="font-size: 1.1rem;">
                    ✅ El proyecto funciona, pero hay advertencias menores.
                </p>
                <a href="index.php" class="btn">Probar el Proyecto →</a>
            <?php else: ?>
                <p style="font-size: 1.1rem;">
                    ❌ Hay errores que debes corregir antes de continuar.
                </p>
                <p style="margin-top: 10px;">
                    Consulta <strong>INSTALACION-RAPIDA.md</strong> para ayuda.
                </p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 10px;">
            <h3 style="color: #333; margin-bottom: 15px;">📚 Próximos Pasos:</h3>
            <ol style="line-height: 2; color: #555;">
                <li>Revisa los errores y advertencias arriba</li>
                <li>Copia las carpetas <code>imagenes/</code> y <code>fonts/</code> de tu proyecto anterior</li>
                <li>Verifica que <code>database.sql</code> esté importado en phpMyAdmin</li>
                <li>Ajusta las credenciales en <code>config/conexion.php</code></li>
                <li>Recarga esta página para verificar de nuevo</li>
                <li>Si todo está ✅, elimina este archivo (<code>verificar.php</code>) por seguridad</li>
            </ol>
        </div>
    </div>
</body>
</html>
