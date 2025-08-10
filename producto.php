<?php

include 'conexion.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: comprar.php");
    exit;
}

$id_producto = intval($_GET['id']);

// Obtener producto
$sql = "SELECT p.*, f.nombre AS farmacia FROM productos p 
        JOIN farmacias f ON p.farmacia_id = f.id 
        WHERE p.id = $id_producto";
$res = $conn->query($sql);

if ($res->num_rows == 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($producto['nombre']) ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .producto-ficha {
            background: #fff;
            max-width: 900px;
            margin: 40px auto 30px auto;
            border-radius: 14px;
            box-shadow: 0 2px 14px rgba(0,0,0,0.09);
            display: flex;
            gap: 36px;
            padding: 38px 38px 28px 38px;
        }
        .img-area {
            flex: 1;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            background: #f3f6fa;
            border-radius: 10px;
            padding: 28px 0;
            min-width: 300px;
        }
        .img-area img {
            max-width: 300px;
            max-height: 300px;
            border-radius: 10px;
            border: 1px solid #e0e4ea;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.3s;
            cursor: zoom-in;
            background: #fff;
        }
        .img-area img:hover {
            transform: scale(1.12);
            cursor: zoom-out;
        }
#modalZoom {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

#modalZoom img {
    width: auto;
    height: auto;
    max-width: 95vw;
    max-height: 95vh;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.5);
    background: #fff;
}



        .info-area {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .titulo-producto {
            font-size: 2rem;
            color: #1a2537;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .calificacion-producto {
            margin-bottom: 8px;
        }
        .estrella {
            color: #f7b500;
            font-size: 19px;
            margin-right: 1px;
        }
        .precio-producto {
            font-size: 1.7rem;
            color: #2b4ec0ff;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .stock-producto {
            font-size: 1.05rem;
            margin-bottom: 8px;
        }
        .stock-bajo {
            color: #d32f2f;
            font-weight: bold;
        }
        .desc-producto {
            font-size: 1.05rem;
            color: #222;
            margin-bottom: 14px;
        }
        .farmacia-producto {
            font-size: 1rem;
            color: #555;
            margin-bottom: 8px;
        }
        .botones-compra {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }
        .botones-compra button {
            background: #4ef7b0ff;
            color: #222;
            padding: 12px 26px;
            border: 1px solid #4dffacff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.05rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
            transition: background 0.2s, border 0.2s;
        }
        .botones-compra button:hover {
            background: #4ef7b0ff;
            border-color: #4dffacff;
        }
        .comentarios {
            margin-top: 32px;
            background: #f8fafc;
            padding: 18px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        .comentarios h3 {
            font-size: 19px;
            color: #1a2537;
            border-bottom: 2px solid #e3e6e6;
            padding-bottom: 7px;
            margin-bottom: 15px;
        }
        .comentarios p {
            background: #fff;
            border: 1px solid #e3e6e6;
            padding: 11px 14px;
            margin-bottom: 13px;
            border-radius: 9px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .comentarios p:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.07);
        }
        .comentarios p strong {
            color: #2d7cb8;
            display: block;
            margin-bottom: 4px;
            font-size: 15px;
        }
        .comentarios em {
            color: #666;
        }
        form {
            margin-top: 22px;
            background: #f8f9fa;
            padding: 13px;
            border-radius: 8px;
            border: 1px solid #e3e6e6;
        }
        textarea, input[type=number] {
            width: 100%;
            padding: 9px;
            margin-top: 5px;
            margin-bottom: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-family: inherit;
        }
        button.regresar {
            background: #e3e6e6;
            color: #232f3e;
            margin-left: 10px;
        }
        button.regresar:hover {
            background: #d5dbdb;
        }
    </style>
</head>
<body>

<div class="producto-ficha">
<div class="img-area">
    <?php if (!empty($producto['imagen'])): ?>
        <img id="imgProducto" 
             src="imagenes/<?= htmlspecialchars($producto['imagen']) ?>" 
             alt="<?= htmlspecialchars($producto['nombre']) ?>" 
             style="cursor: zoom-in; border-radius: 10px;">
    <?php endif; ?>
</div>

<!-- Modal para zoom -->
<div id="modalZoom">
    <img id="imgZoom" src="">
</div>


    <div class="info-area">
        <div class="titulo-producto"><?= htmlspecialchars($producto['nombre']) ?></div>
        <div class="calificacion-producto">
            <?php
            // Calcular promedio de calificaciones
            $sql_com = "SELECT calificacion FROM comentarios WHERE producto_id = $id_producto";
            $res_com = $conn->query($sql_com);
            $suma = 0;
            $total = 0;
            if ($res_com->num_rows > 0) {
                while ($c = $res_com->fetch_assoc()) {
                    $suma += $c['calificacion'];
                    $total++;
                }
                $promedio = round($suma / $total, 1);
                echo mostrarEstrellas($promedio) . " ($promedio)";
            } else {
                echo "<span style='color:#888'>Sin calificaciones</span>";
            }
            ?>
        </div>
        <div class="precio-producto">$<?= number_format($producto['precio'], 2) ?></div>
        <div class="stock-producto">
            <?php if ($producto['stock'] > 0): ?>
                <span style="color:#007600;font-weight:bold;">En stock</span>
            <?php else: ?>
                <span class="stock-bajo">Sin stock disponible</span>
            <?php endif; ?>
            <span style="margin-left:10px;"><strong>Stock:</strong> <?= intval($producto['stock']) ?></span>
        </div>
        <div class="desc-producto"><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></div>
        <div class="farmacia-producto"><strong>Farmacia:</strong> <?= htmlspecialchars($producto['farmacia']) ?></div>
        <div class="botones-compra">
            <?php if ($producto['stock'] > 0): ?>
                <form action="carrito.php" method="post" style="display:inline;">
                    <input type="hidden" name="producto_id" value="<?= $id_producto ?>">
                    <?php echo "<button class='agregar-btn' data-id='" . intval($row['id']) . "'>Agregar al carrito</button>";?>
                </form>
                <form action="comprar.php" method="post" style="display:inline;">
                    <input type="hidden" name="producto_id" value="<?= $id_producto ?>">
                    <button type="submit" name="accion" value="comprar">Comprar ahora</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="comentarios">
    <h3>Comentarios y Calificaciones</h3>
    <?php
    $sql_com = "SELECT c.*, u.nombre FROM comentarios c
                JOIN usuarios u ON c.usuario_id = u.id
                WHERE c.producto_id = $id_producto
                ORDER BY c.fecha DESC";
    $res_com = $conn->query($sql_com);

    $suma = 0;
    $total = 0;

    if ($res_com->num_rows > 0) {
        while ($c = $res_com->fetch_assoc()) {
            $suma += $c['calificacion'];
            $total++;
            echo "<p><strong>" . htmlspecialchars($c['nombre']) . "</strong> ";
            echo mostrarEstrellas($c['calificacion']);
            echo "<br>" . htmlspecialchars($c['comentario']) . "</p>";
        }

        $promedio = round($suma / $total, 1);
    } else {
        echo "<p>No hay comentarios todavía.</p>";
    }

    function mostrarEstrellas($valor) {
        $html = '';
        $entero = floor($valor);
        $decimal = $valor - $entero;

        for ($i = 0; $i < 5; $i++) {
            if ($i < $entero) {
                $html .= "<span class='estrella'>&#9733;</span>";
            } elseif ($i == $entero && $decimal >= 0.5) {
                $html .= "<span class='estrella' style='position: relative; display: inline-block; color: #ccc;'>
                            &#9733;
                            <span style='position: absolute; left: 0; top: 0; width: 50%; overflow: hidden; color: #f7b500;'>&#9733;</span>
                          </span>";
            } else {
                $html .= "<span class='estrella' style='color:#ccc'>&#9733;</span>";
            }
        }
        return $html;
    }
    ?>
</div>

<?php if (isset($_SESSION['id']) && $_SESSION['tipo'] == 'usuario'): ?>
    <div style="max-width:700px;margin:30px auto;">
        <h3>Agregar comentario</h3>
        <form action="guardar_comentario.php" method="post">
            <input type="hidden" name="producto_id" value="<?= $id_producto ?>">
            <label>Comentario:</label><br>
            <textarea name="comentario" required></textarea><br>
            <label>Calificación (1 a 5):</label><br>
            <input type="number" name="calificacion" min="1" max="5" required><br>
            <button type="submit">Enviar</button>
            <button type="button" class="regresar" onclick="location.href='comprar.php'">Regresar</button>
        </form>
    </div>
<?php else: ?>
    <div style="max-width:700px;margin:30px auto;">
        <p><em>Inicia sesión como usuario para comentar.</em></p>
    </div>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const imgProducto = document.getElementById("imgProducto");
    const modalZoom = document.getElementById("modalZoom");
    const imgZoom = document.getElementById("imgZoom");

    imgProducto.addEventListener("click", () => {
        imgZoom.src = imgProducto.src;
        modalZoom.style.display = "flex";
    });

    modalZoom.addEventListener("click", () => {
        modalZoom.style.display = "none";
        imgZoom.src = "";
    });
});
</script>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'ok'): ?>
    <div style="max-width:700px;margin:10px auto;color:green;font-weight:bold;">
        ¡Comentario guardado correctamente!
    </div>
<?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
    <div style="max-width:700px;margin:10px auto;color:red;font-weight:bold;">
        Error al guardar el comentario.
    </div>
<?php endif; ?>
</body>
</html>