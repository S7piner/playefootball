<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Connexion Tournoi eFootball</title>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
        color: #fff;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* TOP BAR AMÉLIORÉE */
    .topbar {
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(20px);
        padding: 15px 0;
        border-bottom: 2px solid #ff6b6b;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .topbar-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo-mark {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-mark::after {
        content: '⚽';
        font-size: 1.2rem;
    }

    .logo span:last-child {
        font-family: 'Press Start 2P', cursive;
        font-size: 0.8rem;
        line-height: 1.2;
        color: #ff6b6b;
    }

    .pill .btn {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: #fff;
        padding: 12px 25px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .pill .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
    }

    /* HERO SECTION MODERNE */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 100px 20px 50px;
        position: relative;
        background: url("{{ asset('img/efo.jpg') }}") center/cover no-repeat fixed;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(15, 15, 35, 0.95) 0%, rgba(26, 26, 46, 0.85) 50%, rgba(22, 33, 62, 0.95) 100%);
        backdrop-filter: blur(5px);
    }

    .login-container {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 50px 40px;
        max-width: 450px;
        width: 100%;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        animation: slideIn 0.8s ease-out;
        border-top: 4px solid #ff6b6b;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
    }

    .login-icon i {
        font-size: 2rem;
        color: #fff;
    }

    .login-container h1 {
        font-size: 2.2rem;
        margin-bottom: 10px;
        background: linear-gradient(90deg, #ff6b6b, #ee5a24);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Press Start 2P', cursive;
    }

    .slogan {
        text-align: center;
        color: #b0b0b0;
        margin-bottom: 30px;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    /* FORMULAIRE MODERNE */
    form {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .form-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    input {
        width: 100%;
        padding: 15px 15px 15px 50px;
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    input:focus {
        outline: none;
        border-color: #ff6b6b;
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 20px rgba(255, 107, 107, 0.3);
    }

    input:focus + .input-icon {
        color: #ff6b6b;
    }

    input::placeholder {
        color: #888;
    }

    .error {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: rgba(255, 107, 107, 0.1);
        border-radius: 6px;
        border-left: 3px solid #ff6b6b;
    }

    .error::before {
        content: '⚠';
        font-size: 0.9rem;
    }

    button[type="submit"] {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: #fff;
        padding: 16px 30px;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        position: relative;
        overflow: hidden;
    }

    button[type="submit"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(255, 107, 107, 0.4);
    }

    button[type="submit"]::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    button[type="submit"]:hover::before {
        left: 100%;
    }

    .forgot-password {
        text-align: right;
        margin-top: -10px;
    }

    .forgot-password a {
        color: #b0b0b0;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .forgot-password a:hover {
        color: #ff6b6b;
        text-decoration: underline;
    }

    .info {
        text-align: center;
        color: #4ecdc4;
        margin: 25px 0;
        font-weight: 500;
        background: rgba(78, 205, 196, 0.1);
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(78, 205, 196, 0.2);
    }

    .signup-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .signup-link p {
        color: #b0b0b0;
    }

    .signup-link a {
        color: #4ecdc4;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .signup-link a:hover {
        color: #ff6b6b;
        text-decoration: underline;
    }

    /* PARTICULES ANIMÉES */
    .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .particle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: #ff6b6b;
        border-radius: 50%;
        animation: float 8s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .login-container {
            padding: 40px 25px;
            margin: 20px;
        }

        .login-container h1 {
            font-size: 1.8rem;
        }

        .login-icon {
            width: 70px;
            height: 70px;
        }

        .topbar-inner {
            padding: 0 15px;
        }

        .logo span:last-child {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .login-container {
            padding: 30px 20px;
        }

        .login-container h1 {
            font-size: 1.6rem;
        }

        input {
            padding: 12px 12px 12px 45px;
        }

        button[type="submit"] {
            padding: 14px 25px;
        }

        .login-icon {
            width: 60px;
            height: 60px;
        }

        .login-icon i {
            font-size: 1.5rem;
        }
    }

    /* EFFET PULSE SUR LE BOUTON */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(255, 107, 107, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(255, 107, 107, 0);
        }
    }

    .pulse {
        animation: pulse 2s infinite;
    }
</style>
</head>
<body>

<!-- TOP BAR -->
<header class="topbar">
    <div class="topbar-inner">
        <div class="logo">
            <span class="logo-mark"></span>
            <span>FOCUS<br>eFootball</span>
        </div>

        <div class="pill">
            <a class="btn" href="/">
                <i class="fas fa-home"></i> Accueil
            </a>
        </div>
    </div>
</header>

<!-- PARTICULES -->
<div class="particles" id="particles"></div>

<!-- HERO -->
<section class="hero" role="img" aria-label="Bannière eFootball">
    <div class="login-container">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-sign-in-alt"></i>
            </div>
            <h1>CONNEXIONx</h1>
            <p class="slogan">
                Accédez à votre espace joueur et préparez-vous pour la compétition !
            </p>
        </div>

        <form method="POST" action="{{ route('participant.login') }}">
            @csrf

            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Adresse email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" placeholder="Mot de passe" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="forgot-password">
                <a href="#">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="pulse">
                <i class="fas fa-rocket"></i> SE CONNECTER
            </button>
        </form>

        {{-- <p class="info">
            <i class="fas fa-users"></i> Rejoignez les 500+ champions déjà connectés !
        </p> --}}

        <div class="signup-link">
            <p>Nouveau joueur ? <a href="{{ route('inscrit.create') }}">Créer un compte</a></p>
        </div>
    </div>
</section>

<script>
    // Création des particules animées
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 15;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';

            // Position aléatoire
            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.animationDelay = Math.random() * 8 + 's';
            particle.style.animationDuration = (4 + Math.random() * 6) + 's';

            // Taille et couleur aléatoires
            const size = 2 + Math.random() * 4;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';

            // Couleurs aléatoires dans la palette rouge/orange
            const colors = ['#ff6b6b', '#ee5a24', '#ff8e6b', '#ff5252'];
            particle.style.background = colors[Math.floor(Math.random() * colors.length)];

            particlesContainer.appendChild(particle);
        }
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        createParticles();

        // Effet de focus amélioré sur les inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Effet de saisie en temps réel
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.style.background = 'rgba(255, 255, 255, 0.12)';
                } else {
                    this.style.background = 'rgba(255, 255, 255, 0.08)';
                }
            });
        });
    });

    // Validation du formulaire
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const email = form.querySelector('input[name="email"]');
        const password = form.querySelector('input[name="password"]');

        if (!email.value || !password.value) {
            e.preventDefault();
            // Ajouter un effet shake sur les champs vides
            if (!email.value) {
                email.style.animation = 'shake 0.5s';
                setTimeout(() => email.style.animation = '', 500);
            }
            if (!password.value) {
                password.style.animation = 'shake 0.5s';
                setTimeout(() => password.style.animation = '', 500);
            }
        }
    });

    // Animation shake
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
</script>

</body>
</html>
