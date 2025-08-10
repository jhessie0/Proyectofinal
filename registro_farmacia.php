<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'conexion.php';
session_start();

$codigo_valido = "10911"; // Cambia este código si quieres algo más seguro

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $codigo = trim($_POST['codigo_farmacia']);

    // Validación del código secreto
    if ($codigo !== $codigo_valido) {
        echo "<script>alert('Código de farmacia incorrecto. Registro denegado.'); window.history.back();</script>";
        exit;
    }

    // Insertar en la tabla correcta: farmacias
    $sql = "INSERT INTO farmacias (nombre, direccion, telefono, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en prepare(): " . $conn->error);
    }

    $stmt->bind_param("sssss", $nombre, $direccion, $telefono, $correo, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso de farmacia'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Error al registrar: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}
?>
