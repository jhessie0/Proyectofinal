<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id']) && $_SESSION['tipo'] == 'usuario') {
    $producto_id = intval($_POST['producto_id']);
    $usuario_id = $_SESSION['id'];
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $calificacion = intval($_POST['calificacion']);

    if ($calificacion >= 1 && $calificacion <= 5) {
        $sql = "INSERT INTO comentarios (producto_id, usuario_id, comentario, calificacion)
                VALUES ($producto_id, $usuario_id, '$comentario', $calificacion)";
        $conn->query($sql);
    }

    header("Location: producto.php?id=$producto_id");
    exit;
} else {
    header("Location: comprar.php");
    exit;
}
?>
