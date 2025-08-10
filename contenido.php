
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nova Salud - Farmacias</title>
  <!-- Tipografía + Íconos -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-K5VYHq0+Mbv8D9Nsp0Cz1ZjQH7lX+Y9MJw5pzEw9kV9+4+2vXKcq0f5F8Xr5BpA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --bg: #f3f2f4;
      --dark: #0f0f10;
      --muted: #666;
      --accent: #009688;
      --card: #ffffff;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--bg); color: #111; }

    .hero {
      background: linear-gradient(180deg, rgba(0,0,0,0.95), rgba(0,0,0,0.88));
      color: white;
      padding: 48px 20px 60px;
      text-align: center;
    }

    .container {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .title {
      font-family: 'Montserrat', sans-serif;
      font-size: 28px;
      letter-spacing: 1px;
      margin-bottom: 10px;
    }

    .subtitle {
      color: #d7d7d8;
      font-size: 15px;
      max-width: 820px;
      margin: 0 auto 20px;
    }

    .pointer {
      margin-top: 8px;
      animation: bounce 1.8s infinite;
      width: 28px;
      height: 28px;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,.4));
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 28px;
      margin-top: 32px;
    }

    .card img {
      width: 100%;
      height: 190px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    }

    main {
      margin-top: 44px;
      padding: 48px 20px 80px;
    }

    .section-title {
      text-align: center;
      font-size: 20px;
      margin-bottom: 18px;
      color: #222;
    }

    .video-wrap {
      max-width: 860px;
      margin: 0 auto;
      background: var(--card);
      border-radius: 14px;
      padding: 14px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .video-wrap iframe {
      width: 100%;
      height: 420px;
      border: 0;
    }

    .social {
      text-align: center;
      margin-top: 60px;
    }

    .social h3 {
      font-size: 18px;
      color: #333;
      margin-bottom: 12px;
    }

    .social-icons a {
      margin: 0 10px;
      font-size: 30px;
      color: var(--accent);
      text-decoration: none;
      transition: transform 0.3s ease, color 0.3s;
    }

    .social-icons a:hover {
      color: #004d40;
      transform: scale(1.2);
    }

    footer {
      text-align: center;
      padding: 18px 12px;
      color: var(--muted);
      font-size: 13px;
    }

    @media (max-width: 640px) {
      .video-wrap iframe { height: 220px; }
    }
    .logo {
  height: 100px;
  margin-bottom: 20px;
}

  </style>
</head>
<body>

  <header class="hero">
    <div class="container">
        <h1> Nova Salud</h1>
      <img src="baston_de_hermes.png" alt="Nova Salud Logo" class="logo" />
      <p class="subtitle">Aplicamos tecnología para que encuentres tus medicamentos sin salir de casa</p>
      <div class="pointer">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
          <path d="M12 2c.55 0 1 .45 1 1v6h2c.83 0 1.5.67 1.5 1.5V18a3 3 0 0 1-3 3H8.5A2.5 2.5 0 0 1 6 18.5V13a1 1 0 0 1 2 0v4.5c0 .28.22.5.5.5H13a1 1 0 0 0 1-1V10.5c0-.28.22-.5.5-.5H17V3a1 1 0 0 0-1-1h-4z" fill="#ff44a1"/>
        </svg>
      </div>

      <div class="cards">
  <div class="card">
    <img src="clasificacion-de-medicamentos.jpg" alt="Dashboard médico">
  </div>
  <div class="card">
    <img src="images.jpeg" alt="Gráficas de farmacia">
  </div>
  <div class="card">
    <img src="1500x844-metricas.jpg" alt="Tecnología en salud">
  </div>
</div>

  </header>

  <main class="container">
    <h2 class="section-title">Descubre cómo la tecnología impulsa el control de asistencias</h2>
    <div class="video-wrap">
      <iframe src="https://www.youtube.com/embed/zx5B0LzAE6M" title="Video Nova Salud" allowfullscreen></iframe>
    </div>

    <div class="social">
      <h3>Síguenos en redes sociales Nova Salud</h3>
      <div class="social-icons">
        <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
        <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://wa.me/5210000000000" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
  </main>

  <footer>
    © <span id="year"></span> Nova Salud — Todos los derechos reservados.
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>

</body>
</html>