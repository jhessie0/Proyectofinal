<?php
include 'conexion.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$tipo = $_POST['tipo'];

echo "Email: $email<br>";
echo "Tipo: $tipo<br>";

if ($tipo == 'usuario') {
    $sql = "SELECT * FROM usuarios WHERE email = ?";
} else {
    $sql = "SELECT * FROM farmacias WHERE email = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    echo "Usuario encontrado: {$user['nombre']}<br>";

    if (password_verify($password, $user['password'])) {
        $_SESSION['tipo'] = $tipo;
        $_SESSION['id'] = $user['id'];
        $_SESSION['nombre'] = $user['nombre'];

        echo "Login exitoso<br>";
        header("Location:" . ($tipo == 'usuario' ? "comprar.php" : "vender.php"));
        exit();
        } else {
            echo "<script>alert('Correo no Registrado'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Contraseña Incorrecta'); window.location='index.php';</script>";
    }

?>
