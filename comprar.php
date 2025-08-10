<?php
include 'conexion.php';
session_start();

// Cerrar sesión si se presiona "Salir"
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Verificar sesión de usuario
if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'usuario') {
    header('Location: login.php');
    exit();
}

$nombre = $_SESSION['nombre'];
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Compra de Productos</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #f0f8ff;
      color: #333;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #0077cc;
      color: white;
      padding: 15px 20px;
      position: relative;
    }

    .logout-btn {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: 2px solid white;
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    .carrito-link {
      position: absolute;
      right: 130px;
      top: 50%;
      transform: translateY(-50%);
      color: white;
      font-weight: bold;
      text-decoration: none;
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .producto {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
      transition: transform 0.3s ease;
    }

    .producto:hover {
      transform: scale(1.02);
    }

    .producto h3 {
      color: #0077cc;
      margin-bottom: 8px;
    }

    .producto p {
      margin-bottom: 6px;
      color: #555;
    }

    .producto strong {
      display: inline-block;
      margin: 10px 0;
      font-size: 1.2rem;
      color: #28a745;
    }

    .producto .detalle {
      font-size: 0.95rem;
      color: #666;
    }

    .producto img {
      max-width: 150px;
      height: auto;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .agregar-btn {
      background-color: #0077cc;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    .agregar-btn:hover {
      background-color: #005fa3;
    }

    .ver-btn {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      margin-left: 10px;
    }

    #mensaje-flotante {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #d4edda;
      color: #155724;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      display: none;
      z-index: 1000;
    }

.carrusel {
  width: 600px;              /* Ancho fijo más grande para que se vea mejor */
  height: 350px;             /* Alto fijo para imágenes visibles */
  margin: 20px auto;         /* Centrar horizontalmente y separar un poco */
  overflow: hidden;
  position: relative;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  background-color: #fff;
}

.carrusel-imagenes {
  display: flex;
  transition: transform 0.5s ease-in-out;
  height: 100%;
  width: 100%;
}

.carrusel-imagenes a {
  flex-shrink: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carrusel-imagenes img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;   /* Mantiene la proporción y no recorta */
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  user-select: none;     /* Evita que selecciones la imagen al arrastrar */
  pointer-events: none;  /* Evita clicks directos sobre la imagen */
}

/* Botones del carrusel */
.carrusel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0,0,0,0.5);
  border: none;
  color: white;
  font-size: 30px;
  padding: 8px 15px;
  cursor: pointer;
  border-radius: 50%;
  user-select: none;
  transition: background-color 0.3s;
}

.carrusel-btn:hover {
  background-color: rgba(0,0,0,0.8);
}

.carrusel-btn.izquierda {
  left: 10px;
}

.carrusel-btn.derecha {
  right: 10px;
}

  </style>
</head>
<body>

<header>
  Bienvenido → <?= htmlspecialchars($nombre) ?>
  <form method="post" style="display:inline;">
    <button type="submit" name="logout" class="logout-btn">Salir</button>
  </form>
  <a href="carrito.php" class="carrito-link">
    Ver Carrito (<span id="contador-carrito"><?= array_sum($_SESSION['carrito']) ?></span>)
  </a>
</header>
        <div style="text-align:right; margin-top: 10px;">
    <input type="text" id="buscador" placeholder="🔍 Buscar producto..." 
           style="padding: 5px; width:300px; border-radius: 100px; border: 2px solid #ccc;">
</div>
<script>
// --- Buscador ---
const buscador = document.getElementById("buscador");

buscador.addEventListener("input", function () {
    const filtro = buscador.value.toLowerCase();
    const productos = document.querySelectorAll(".producto");

    productos.forEach(prod => {
        const texto = prod.innerText.toLowerCase();
        prod.style.display = texto.includes(filtro) ? "block" : "none";
    });
});
</script>

<!-- carrusel -->
<div class="carrusel">
    <div class="carrusel-imagenes" id="carrusel-imagenes">
        <?php
        // Ahora seleccionamos id e imagen para poder enlazar
        $destacados = $conn->query("SELECT id, imagen FROM productos WHERE stock > 0 LIMIT 100");
        while ($img = $destacados->fetch_assoc()) {
            echo "<a href='producto.php?id=" . intval($img['id']) . "'>";
            echo "<img src='imagenes/" . htmlspecialchars($img['imagen']) . "' alt='Producto'>";
            echo "</a>";
        }
        ?>
    </div>
    <button class="carrusel-btn izquierda" onclick="moverCarrusel(-1)">&#10094;</button>
    <button class="carrusel-btn derecha" onclick="moverCarrusel(1)">&#10095;</button>
</div>

<script>
let indice = 0;

function moverCarrusel(direccion) {
    const carrusel = document.getElementById("carrusel-imagenes");
    const total = carrusel.children.length;
    indice = (indice + direccion + total) % total;
    carrusel.style.transform = `translateX(-${indice * 100}%)`;
}

// Cambio automático cada 5 segundos
setInterval(() => moverCarrusel(1), 5000);
</script>


<!-- productos -->
<div class="container">
<?php
$sql = "SELECT p.*, f.nombre AS farmacia FROM productos p
        JOIN farmacias f ON p.farmacia_id = f.id
        WHERE p.stock > 0
        ORDER BY p.id DESC";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<div class='producto'>";
    if (!empty($row['imagen'])) {
        echo "<img src='imagenes/" . htmlspecialchars($row['imagen']) . "' alt='Imagen del producto'>";
    }
    echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
    echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
    echo "<strong>$" . number_format($row['precio'], 2) . "</strong>";
    echo "<div class='detalle'>Farmacia: " . htmlspecialchars($row['farmacia']) . "</div>";
    echo "<div class='detalle'>Stock: " . intval($row['stock']) . "</div>";

    echo "<button class='agregar-btn' data-id='" . intval($row['id']) . "'>Agregar al carrito</button>";

    echo "<form method='get' action='producto.php' style='display:inline;'>";
    echo "<input type='hidden' name='id' value='" . intval($row['id']) . "'>";
    echo "<button type='submit' class='ver-btn'>Ver detalles y Comentarios</button>";
    echo "</form>";

    echo "</div>";
}
?>
</div>

<div id="mensaje-flotante"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const botones = document.querySelectorAll(".agregar-btn");
    const mensaje = document.getElementById("mensaje-flotante");
    const contador = document.getElementById("contador-carrito");

    botones.forEach(btn => {
        btn.addEventListener("click", () => {
            const idProducto = btn.getAttribute("data-id");

            fetch("agregar_carrito.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id_producto=" + encodeURIComponent(idProducto)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    contador.textContent = data.cantidad_total;
                    mostrarMensaje("✅ Producto agregado al carrito");
                } else {
                    mostrarMensaje("❌ " + (data.message || "Error al agregar"));
                }
            })
            .catch(() => {
                mostrarMensaje("⚠️ Error de red");
            });
        });
    });

    function mostrarMensaje(texto) {
        mensaje.textContent = texto;
        mensaje.style.display = "block";
        setTimeout(() => mensaje.style.display = "none", 3000);
    }
});
</script>

</body>
</html>