<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro | Farmacia Azul Fresco</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
    }

    body {
      height: 100vh;
      background: url('farmacia33.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Inter', sans-serif;
    }

    .container {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      padding: 40px 35px;
      border-radius: 20px;
      width: 95%;
      max-width: 420px;
      color: #fff;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    h2 {
      font-size: 2.2rem;
      font-family: 'Roboto Slab', serif;
      color: #0077cc;
      margin-bottom: 25px;
    }

    .switch-buttons {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 25px;
    }

    .switch-buttons button {
      flex: 1;
      padding: 10px;
      border-radius: 30px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      background-color: #cce5ff;
      color: #003366;
      transition: all 0.3s ease;
    }

    .switch-buttons button.active {
      background-color: #007bff;
      color: #fff;
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    form {
      display: none;
      text-align: left;
      margin-top: 10px;
    }

    form.active {
      display: block;
    }

    form input {
      width: 100%;
      padding: 13px 15px;
      margin-bottom: 16px;
      border-radius: 10px;
      border: 2px solid #cce5ff;
      background: rgba(255, 255, 255, 0.85);
      font-size: 15px;
      color: #003366;
      transition: 0.3s ease;
    }

    form input:focus {
      outline: none;
      border-color: #007bff;
      background-color: #eaf5ff;
      box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
    }

    form input::placeholder {
      color: #003366a9;
      font-style: italic;
    }

    form button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 30px;
      background: linear-gradient(to right, #3399ff, #007bff);
      color: #fff;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5);
      transition: all 0.3s ease;
      margin-bottom: 12px;
    }

    form button:hover {
      background: linear-gradient(to right, #007bff, #0056b3);
      transform: scale(1.04);
    }

.regresar {
  background: transparent;
  border: 2px solid #ffffffaa; /* Borde blanco semitransparente */
  color: white;
  padding: 10px 20px;
  margin-top: 15px;
  border-radius: 12px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: all 0.3s ease;
  backdrop-filter: blur(2px); /* Efecto glass */
}

.regresar:hover {
  background: rgba(255, 255, 255, 0.2);
  color: #007bff;
  border-color: #007bff;
  transform: scale(1.05);
}

    @media (max-width: 500px) {
      .container {
        padding: 30px 20px;
      }

      h2 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h2>Registro</h2>

    <div class="switch-buttons">
      <button id="btnUsuario" class="active" onclick="mostrarFormulario('usuario')">Usuario</button>
      <button id="btnFarmacia" onclick="mostrarFormulario('farmacia')">Farmacia</button>
    </div>

    <!-- Formulario Usuario -->
    <form id="formUsuario" class="active" method="post" action="registro_usuario.php">
      <input name="nombre" type="text" placeholder="Nombre completo" required>
      <input name="email" type="email" placeholder="Correo electrónico" required>
      <input name="telefono" type="tel" placeholder="Teléfono" required>
      <input name="password" type="password" placeholder="Contraseña" required>
      <button type="submit">Registrar Usuario</button>
      <button type="button" class="regresar" onclick="location.href='index.php'">Regresar</button>
    </form>

    <!-- Formulario Farmacia -->
<form id="formFarmacia" method="post" action="registro_farmacia.php">
  <input name="nombre" type="text" placeholder="Nombre comercial" required>
  <input name="direccion" type="text" placeholder="Dirección" required>
  <input name="telefono" type="tel" placeholder="Teléfono" required>
  <input name="email" type="email" placeholder="Correo electrónico" required>
  <input name="password" type="password" placeholder="Contraseña" required>
  <input name="codigo_farmacia" type="text" placeholder="Código de verificación" required>
  <button type="submit">Registrar Farmacia</button>
  <button type="button" class="regresar" onclick="location.href='index.php'">Regresar</button>
</form>

  </div>

  <script>
    function mostrarFormulario(tipo) {
      const formUsuario = document.getElementById('formUsuario');
      const formFarmacia = document.getElementById('formFarmacia');
      const btnUsuario = document.getElementById('btnUsuario');
      const btnFarmacia = document.getElementById('btnFarmacia');

      if (tipo === 'usuario') {
        formUsuario.classList.add('active');
        formFarmacia.classList.remove('active');
        btnUsuario.classList.add('active');
        btnFarmacia.classList.remove('active');
      } else {
        formFarmacia.classList.add('active');
        formUsuario.classList.remove('active');
        btnFarmacia.classList.add('active');
        btnUsuario.classList.remove('active');
      }
    }
  </script>

</body>
</html>
