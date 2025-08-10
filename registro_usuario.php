<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Primero verificamos si el email ya existe
$sql_check = "SELECT id FROM usuarios WHERE email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // El email ya está registrado, mostrar alerta y redirigir
    echo "<script>alert('El correo ya está registrado. Por favor usa otro.'); window.location.href='registro.php';</script>";
    exit;
}

$sql = "INSERT INTO usuarios (nombre, email, telefono, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $email, $telefono, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registro exitoso.'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Error al registrar. Intenta nuevamente.'); window.location.href='registro.php';</script>";
}
?>
