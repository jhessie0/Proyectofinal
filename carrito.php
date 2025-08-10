<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Comprar: descontar stock y limpiar carrito
if (isset($_POST['comprar'])) {
    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        // Consultar stock actual
        $sql_stock = "SELECT stock FROM productos WHERE id = $id_producto";
        $res = $conn->query($sql_stock);
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            if ($row['stock'] >= $cantidad) {
                // Descontar stock
                $nuevo_stock = $row['stock'] - $cantidad;
                $sql_update = "UPDATE productos SET stock = $nuevo_stock WHERE id = $id_producto";
                $conn->query($sql_update);
            } else {
                echo "<script>alert('No hay suficiente stock para algunos productos.');</script>";
                // Opcional: salir para no continuar compra incompleta
                header("Location: carrito.php");
                exit;
            }
        }
    }
    // Vaciar carrito
    $_SESSION['carrito'] = [];
    echo "<script>alert('Compra realizada con éxito.');</script>";
    header("Location: comprar.php");
    exit;
}

// Eliminar producto del carrito
if (isset($_POST['eliminar_id'])) {
    $id_eliminar = intval($_POST['eliminar_id']);
    if (isset($_SESSION['carrito'][$id_eliminar])) {
        unset($_SESSION['carrito'][$id_eliminar]);
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Carrito de Compras</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: #eef6fc;
      max-width: 900px;
      margin: 40px auto;
      padding: 20px;
      color: #333;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      border-radius: 12px;
      background-color: #ffffff;
    }

    h1 {
      color: #0077cc;
      text-align: center;
      font-size: 2.2em;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 15px 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #0077cc;
      color: white;
      font-weight: 600;
    }

    td img {
      max-width: 50px;
      height: auto;
      border-radius: 6px;
      vertical-align: middle;
      margin-right: 8px;
    }

    .btn-eliminar, .btn-comprar {
      padding: 10px 18px;
      border-radius: 8px;
      font-weight: bold;
      border: none;
      cursor: pointer;
      transition: 0.3s ease all;
    }

    .btn-eliminar {
      background-color: #dc3545;
      color: white;
    }

    .btn-eliminar:hover {
      background-color: #c82333;
    }

    .btn-comprar {
      background-color: #28a745;
      color: white;
      float: right;
      margin-top: 20px;
    }

    .btn-comprar:hover {
      background-color: #218838;
    }

    a {
      color: #0077cc;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }

    p {
      text-align: center;
      font-size: 1.1em;
    }

     h2 {
      font-size: 1.1em;
    }

    @media screen and (max-width: 768px) {
      table, thead, tbody, th, td, tr {
        display: block;
      }

      th {
        display: none;
      }

      td {
        position: relative;
        padding-left: 50%;
        border: none;
        border-bottom: 1px solid #eee;
      }

      td:before {
        position: absolute;
        top: 12px;
        left: 12px;
        width: 45%;
        white-space: nowrap;
        font-weight: bold;
        color: #555;
      }

      td:nth-of-type(1):before { content: "Producto"; }
      td:nth-of-type(2):before { content: "Nombre"; }
      td:nth-of-type(3):before { content: "Precio"; }
      td:nth-of-type(4):before { content: "Cantidad"; }
      td:nth-of-type(5):before { content: "Subtotal"; }
      td:nth-of-type(6):before { content: "Acción"; }

      .btn-comprar {
        width: 100%;
        float: none;
      }
    }
  </style>

</head>
<body>

<h1>Carrito de Compras</h1>

<?php
if (empty($_SESSION['carrito'])) {
    echo "<p>Tu carrito está vacío. <a href='comprar.php'>Volver a productos</a></p>";
} else {
    // Obtener detalles de productos en el carrito
    $ids = implode(',', array_keys($_SESSION['carrito']));
    $sql = "SELECT * FROM productos WHERE id IN ($ids)";
    $result = $conn->query($sql);

    $total = 0;

    echo "<form method='post'>";
    echo "<table>";
    echo "<tr><th>Producto</th><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th>Acción</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $foto   = !empty($row['imagen']) ? "<img src='imagenes/" . htmlspecialchars($row['imagen']) . "' style='max-width: 75px;'>" : '';
        $cantidad = $_SESSION['carrito'][$row['id']];
        $subtotal = $row['precio'] * $cantidad;
        $total += $subtotal;

        echo "<tr>";
        echo "<td>{$foto} {$row['imangen']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>\${$row['precio']}</td>";
        echo "<td>{$cantidad}</td>";
        echo "<td>\${$subtotal}</td>";
        echo "<td>
            <button type='submit' name='eliminar_id' value='{$row['id']}' class='btn-eliminar'>Eliminar</button>
        </td>";
        echo "</tr>";
    }
  
    echo "</table>";
    echo "<p><strong>Total a pagar:</strong> \${$total}</p>";
    echo "<button type='submit' name='comprar' class='btn-comprar'>Comprar</button>";
    echo "</form>";
}
?>

<h2><a href="comprar.php">Seguir comprando</a></h2>


</body>
</html>
