<?php
include 'conexion.php';
session_start();

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$farmacia_id = $_SESSION['id'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, stock, farmacia_id)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $farmacia_id);
$stmt->execute();

header("Location: vender.php");
?>
