<?php
include 'conexion.php';
session_start();

// Si ya está logueado como usuario, redirigir a comprar.php
if (isset($_SESSION['id']) && $_SESSION['tipo'] == 'usuario') {
    header("Location: comprar.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio - Productos</title>

  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    /* Puedes copiar los mismos estilos que tienes en comprar.php */
    body {
      font-family: 'Roboto', sans-serif;
      background: #f0f8ff;
      padding: 20px;
    }
    .container {
      max-width: 1000px;
      margin: auto;
    }
    .producto {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }
    .producto h3 {
      color: #0077cc;
    }
    .producto img {
      max-width: 150px;
      border-radius: 8px;
    }
    .login-link {
      display: inline-block;
      margin-top: 10px;
      color: #0077cc;
      font-weight: bold;
    }
  </style>
</head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=TU_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'TU_ID');
</script>

<body>

<div class="container">
  <h2>Bienvenido a Farmacia Virtual</h2>
  🩺 Encuentra tu medicamento sin salir de casa
Consulta en segundos qué farmacias tienen lo que necesitas.
<br>
📍 Ubica tu medicina, compara y elige la más cercana.

Rápido, fácil y sin vueltas.
<br>
💊 Tu salud comienza con una buena búsqueda.
  <p><a href="index1.php" class="login-link">Inicia sesión</a> para poder comprar productos.</p>

  <?php
  $sql = "SELECT p.*, f.nombre AS farmacia FROM productos p
          JOIN farmacias f ON p.farmacia_id = f.id
          WHERE p.stock > 0
          ORDER BY p.id DESC";

  $result = $conn->query($sql);

  while ($row = $result->fetch_assoc()) {
      echo "<div class='producto'>";
      if (!empty($row['imagen'])) {
          echo "<img src='imagenes/" . htmlspecialchars($row['imagen']) . "'><br>";
      }
      echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
      echo "<p>" . htmlspecialchars($row['descripcion']) . "</p>";
      echo "<strong>$" . number_format($row['precio'], 2) . "</strong><br>";
      echo "<p>Farmacia: " . htmlspecialchars($row['farmacia']) . "</p>";
      echo "<p>Stock: " . intval($row['stock']) . "</p>";
      echo "<a href='index1.php' class='login-link'>Inicia sesión para comprar</a>";
      echo "</div>";
  }
  ?>
</div>
<footer>
  <a href="https://facebook.com/tuempresa" target="_blank">Facebook</a> |
  <a href="https://instagram.com/tuempresa" target="_blank">Instagram</a> |

    <a href="contenido.php">Contenido</a> |
    <a href="auditoria.php">Auditoría</a>

</footer>


</body>
</html>
