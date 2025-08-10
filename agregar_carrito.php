<?php
session_start();
include 'conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'usuario') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

if (!isset($_POST['id_producto'])) {
    echo json_encode(['success' => false, 'message' => 'ID no válido']);
    exit;
}

$id_producto = intval($_POST['id_producto']);

// Obtener información del producto
$sql = "SELECT stock FROM productos WHERE id = $id_producto";
$resultado = $conn->query($sql);

if (!$resultado || $resultado->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    exit;
}

$producto = $resultado->fetch_assoc();
$stock_disponible = intval($producto['stock']);

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Verificar si ya está en el carrito
$cantidad_en_carrito = isset($_SESSION['carrito'][$id_producto]) ? $_SESSION['carrito'][$id_producto] : 0;

if ($cantidad_en_carrito >= $stock_disponible) {
    echo json_encode(['success' => false, 'message' => 'No hay más stock disponible']);
    exit;
}

// Agregar al carrito
$_SESSION['carrito'][$id_producto] = $cantidad_en_carrito + 1;

// Calcular total actualizado
$cantidad_total = array_sum($_SESSION['carrito']);

echo json_encode(['success' => true, 'cantidad_total' => $cantidad_total]);
