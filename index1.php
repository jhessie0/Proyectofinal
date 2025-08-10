<?php include 'conexion.php'; session_start(); 


?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Login Farmacia</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('farmacia.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .login-box {
      background: #fff;
      padding: 50px;
      border-radius: 150px;
      box-shadow: 0 8px 25px rgba(0, 123, 255, 0.2); /* azul suave */
      width: 340px;
      text-align: center;
      position: relative;
    }

    .login-box::before {
      content: "💊";
      font-size: 50px;
      position: absolute;
      top: -25px;
      left: calc(50% - 40px);
      background-color: #ffffff;
      border-radius: 50%;
      padding: 10px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .login-box h2 {
      margin-bottom: 30px;
      font-weight: 700;
      font-size: 26px;
      color: #007bff; /* azul fuerte */
      letter-spacing: 1px;
    }

    .login-box select,
    .login-box input[type="email"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 14px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      transition: border-color 0.3s ease;
    }

    .login-box input[type="email"]:focus,
    .login-box input[type="password"]:focus {
      outline: none;
      border-color: #007bff;
    }

    .login-box input[type="submit"] {
      width: 100%;
      background-color: #007bff;
      border: none;
      padding: 14px;
      border-radius: 30px;
      font-size: 17px;
      font-weight: bold;
      color: white;
      cursor: pointer;
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .login-box input[type="submit"]:hover {
      background-color: #0056b3;
      box-shadow: 0 8px 20px rgba(0, 91, 179, 0.5);
      animation: pulse 1s infinite;
      transform: scale(1.05);
    }

    .crear-cuenta-btn {
      display: block;
      margin-top: 20px;
      font-size: 15px;
      font-weight: 600;
      text-decoration: none;
      color: #007bff;
      border: 2px solid #007bff;
      padding: 12px 0;
      border-radius: 30px;
      transition: background-color 0.3s ease, color 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }

    .crear-cuenta-btn:hover {
      background-color: #007bff;
      color: white;
      box-shadow: 0 6px 15px rgba(0, 123, 255, 0.5);
    }

    .cambio-usuario {
      margin-top: 15px;
      font-size: 14px;
    }

    .cambio-usuario a {
      color: #007bff;
      font-weight: bold;
      text-decoration: none;
    }

    .cambio-usuario a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Ingreso Farmacia</h2>
    <form action="login.php" method="post">
      <select name="tipo" aria-label="Tipo de usuario" required>
        <option value="usuario">Usuario</option>
        <option value="farmacia" selected>Farmacia</option>
      </select>

      <input name="email" type="email" placeholder="Correo electrónico" required autocomplete="username" />
      <input name="password" type="password" placeholder="Contraseña" required autocomplete="current-password" />

      <input type="submit" value="Ingresar">
    </form>

    <a href="registro.php" class="crear-cuenta-btn">Registrarse</a>

    <div class="cambio-usuario">
    </div>
  </div>
</body>
</html>