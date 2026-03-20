<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Banishers — Hero Repro</title>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ secure_asset('css/Accueil.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">

<style>
    .hero{
    background:url("{{ secure_asset('img/efo.jpg') }}") center / cover no-repeat fixed;
  }

  /* NOUVEAU FOOTER MODERNE */
  .footer {
      background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #16213e 100%);
      color: #fff;
      padding: 60px 0 0;
      position: relative;
      overflow: hidden;
      border-top: 3px solid #00ff95;
  }

  .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1.5fr;
      gap: 40px;
  }

  .footer-logo {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
  }

  .footer-logo .logo-footer {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
  }

  .footer-logo .logo-icon {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #00ff95, #00c9ff);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .footer-logo .logo-text h3 {
      color: #fff;
      margin: 0;
      font-size: 1.5rem;
  }

  .footer-logo .logo-text p {
      color: #00ff95;
      margin: 0;
      font-size: 0.9rem;
  }

  .footer-tagline {
      color: #b0b0b0;
      font-size: 1.1rem;
      margin-bottom: 25px;
      line-height: 1.6;
  }

  .social-icons {
      display: flex;
      gap: 15px;
  }

  .social-icons a {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
  }

  .social-icons a:hover {
      background: linear-gradient(135deg, #00ff95, #00c9ff);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 201, 255, 0.3);
  }

  .social-icons i {
      color: #fff;
      font-size: 1.2rem;
  }

  .footer-section h4 {
      color: #fff;
      font-size: 1.3rem;
      margin-bottom: 20px;
      position: relative;
      padding-bottom: 10px;
  }

  .footer-section h4::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 2px;
      background: linear-gradient(90deg, #00ff95, #00c9ff);
  }

  .footer-section ul {
      list-style: none;
      padding: 0;
  }

  .footer-section ul li {
      margin-bottom: 12px;
  }

  .footer-section ul li a {
      color: #b0b0b0;
      text-decoration: none;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
  }

  .footer-section ul li a:hover {
      color: #00ff95;
      transform: translateX(5px);
  }

  .footer-section p {
      color: #b0b0b0;
      line-height: 1.6;
      margin-bottom: 10px;
  }

  .footer-section a {
      color: #b0b0b0;
      text-decoration: none;
      transition: color 0.3s ease;
  }

  .footer-section a:hover {
      color: #00ff95;
  }

  .contact-info {
      display: flex;
      flex-direction: column;
      gap: 12px;
  }

  .contact-item {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #b0b0b0;
  }

  .contact-item i {
      color: #00ff95;
      width: 20px;
      font-size: 1.1rem;
  }

  .newsletter {
      display: flex;
      flex-direction: column;
  }

  .newsletter form {
      display: flex;
      flex-direction: column;
      gap: 12px;
  }

  .newsletter input {
      padding: 12px 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      background: rgba(255, 255, 255, 0.05);
      border-radius: 8px;
      color: #fff;
      font-size: 1rem;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
  }

  .newsletter input:focus {
      outline: none;
      border-color: #00ff95;
      box-shadow: 0 0 15px rgba(0, 255, 149, 0.2);
  }

  .newsletter button {
      padding: 12px 20px;
      background: linear-gradient(135deg, #00ff95, #00c9ff);
      color: #000;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
  }

  .newsletter button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 201, 255, 0.4);
  }

  .footer-bottom {
      margin-top: 60px;
      padding: 25px 0;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
      background: rgba(0, 0, 0, 0.3);
  }

  .footer-bottom p {
      color: #888;
      margin: 0;
      font-size: 0.9rem;
  }

  .footer-bottom a {
      color: #888;
      text-decoration: none;
      transition: color 0.3s ease;
  }

  .footer-bottom a:hover {
      color: #00ff95;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
      .footer-container {
          grid-template-columns: 1fr 1fr;
          gap: 30px;
      }
  }

  @media (max-width: 768px) {
      .footer {
          padding: 40px 0 0;
      }

      .footer-container {
          grid-template-columns: 1fr;
          gap: 30px;
          text-align: center;
      }

      .footer-logo {
          align-items: center;
      }

      .social-icons {
          justify-content: center;
      }

      .footer-section h4::after {
          left: 50%;
          transform: translateX(-50%);
      }
  }

  @media (max-width: 480px) {
      .footer-container {
          padding: 0 15px;
      }

      .social-icons a {
          width: 40px;
          height: 40px;
      }

      .footer-section h4 {
          font-size: 1.1rem;
      }
  }
</style>
</head>
<body>

<header class="topbar">
  <div class="topbar-inner">
    <div class="logo">
      <span class="logo-mark"></span>
      <span>FOCUS<br>eFootball</span>
    </div>

    <div class="hamburger" onclick="toggleMenu(this)">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <nav id="mainNav">
      <a href="#">Événements</a>
      <a href="#">Nouveautés</a>
      <div class="dropdown">
        <a href="javascript:void(0)">Tournois disponibles ▾</a>
        <ul class="dropdown-content">
          <li><a href="#">Champions League</a></li>
          <li><a href="#">Europa League</a></li>
          <li><a href="#">Conference League</a></li>
        </ul>
      </div>
      <a href="#">Info</a>
      <a href="#"><strong>Histoire</strong></a>
    </nav>
  </div>
</header>

<section class="hero" role="img" aria-label="Banishers banner">
  <div class="title">
    <h1>efootball</h1>
    <h2>Le tournoi en ligne le plus explosif de l'année</h2><br>
    <div class="pill">
      <a class="btn buy" href="{{ route('participant.login') }}">Participer</a>
    </div>
  </div>
</section>

<!-- NOUVEAU FOOTER AMÉLIORÉ -->
<footer class="footer">
  <div class="footer-container">

    <!-- Logo + réseaux sociaux -->
    <div class="footer-logo">
      <div class="logo-footer">
        <div class="logo-icon">
          <i class="fas fa-futbol"></i>
        </div>
        <div class="logo-text">
          <h3>FOCUS eFootball</h3>
          <p>Tournois Professionnels</p>
        </div>
      </div>

      <p class="footer-tagline">
        Rejoignez la communauté gaming la plus compétitive.
        Des tournois épiques, des rewards incroyables.
      </p>

      <div class="social-icons">
        <a href="#" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" aria-label="Twitter">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="#" aria-label="WhatsApp">
          <i class="fab fa-whatsapp"></i>
        </a>
      </div>
    </div>

    <!-- Services -->
    <div class="footer-section">
      <h4>Nos Services</h4>
      <ul>
        <li><a href="#"><i class="fas fa-trophy"></i> Organisation de tournois</a></li>
        <li><a href="#"><i class="fas fa-calendar-star"></i> Événements exclusifs</a></li>
        <li><a href="#"><i class="fas fa-ranking-star"></i> Classements en ligne</a></li>
        <li><a href="/login"><i class="fas fa-user-shield"></i> Espace Administrateur</a></li>
      </ul>
    </div>

    <!-- Contact -->
    <div class="footer-section">
      <h4>Contacts</h4>
      <div class="contact-info">
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>Bénin, Cotonou</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <a href="mailto:wilsonzannou7@gmail.com">wilsonzannou7@gmail.com</a>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+229 0152739802</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <span>+229 0160778076</span>
        </div>
        <div class="contact-item">
          <i class="fas fa-clock"></i>
          <span>Support 7j/7</span>
        </div>
      </div>
    </div>

    <!-- Newsletter -->
    {{-- <div class="footer-section newsletter">
      <h4>Newsletter</h4>
      <p>Restez informé des prochains tournois et événements.</p>
      <form>
        <input type="email" placeholder="Votre email" required>
        <button type="submit">
          <i class="fas fa-paper-plane"></i> S'inscrire
        </button>
      </form>
    </div> --}}

  </div>

  <div class="footer-bottom">
    <p>
      © 2025 <strong style="color: #00ff95;">FOCUS eFootball</strong>
      — Tous droits réservés
      |
      <a href="#">Mentions légales</a>
      •
      <a href="#">Confidentialité</a>
    </p>
  </div>
</footer>

<script>
function toggleMenu(hamburger){
  const nav = document.getElementById('mainNav');
  nav.classList.toggle('show');
}
const dropdowns = document.querySelectorAll('.dropdown');
dropdowns.forEach(dd => {
  const link = dd.querySelector('a');
  link.addEventListener('click', function(e){
    if(window.innerWidth <= 720){
      e.preventDefault();
      const menu = dd.querySelector('.dropdown-content');
      menu.classList.toggle('show-mobile');
    }
  });
});
</script>

</body>
</html>
