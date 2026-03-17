<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Inscription Tournoi eFootball</title>
<link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        border-bottom: 2px solid #00ff95;
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
        background: linear-gradient(135deg, #00ff95, #00c9ff);
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
        color: #00ff95;
    }

    .pill .btn {
        background: linear-gradient(135deg, #00ff95, #00c9ff);
        color: #000;
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
        box-shadow: 0 8px 20px rgba(0, 201, 255, 0.4);
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
        background: linear-gradient(135deg, rgba(15, 15, 35, 0.9) 0%, rgba(26, 26, 46, 0.8) 50%, rgba(22, 33, 62, 0.9) 100%);
        backdrop-filter: blur(5px);
    }

    .signup-container {
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 40px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.8s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .signup-container h1 {
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 10px;
        background: linear-gradient(90deg, #00ff95, #00c9ff);
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

    .benefits-list {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        border-left: 4px solid #00ff95;
    }

    .benefits-list ul {
        list-style: none;
    }

    .benefits-list li {
        padding: 8px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #e0e0e0;
    }

    .benefits-list li i {
        color: #00ff95;
        font-size: 1.1rem;
        width: 20px;
    }

    /* FORMULAIRE MODERNE */
    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        position: relative;
    }

    input {
        width: 100%;
        padding: 15px 20px;
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
        border-color: #00ff95;
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 20px rgba(0, 255, 149, 0.2);
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
        gap: 5px;
    }

    .error::before {
        content: '⚠️';
        font-size: 0.8rem;
    }

    button[type="submit"] {
        background: linear-gradient(135deg, #00ff95, #00c9ff);
        color: #000;
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
        box-shadow: 0 12px 25px rgba(0, 201, 255, 0.4);
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

    .info {
        text-align: center;
        color: #00ff95;
        margin: 20px 0;
        font-weight: 500;
        background: rgba(0, 255, 149, 0.1);
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(0, 255, 149, 0.2);
    }

    .signup-link {
        text-align: center;
        margin-top: 20px;
    }

    .signup-link a {
        color: #00ff95;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .signup-link a:hover {
        color: #00c9ff;
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
        width: 4px;
        height: 4px;
        background: #00ff95;
        border-radius: 50%;
        animation: float 6s infinite linear;
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
        .signup-container {
            padding: 30px 20px;
            margin: 20px;
        }

        .signup-container h1 {
            font-size: 2rem;
        }

        .topbar-inner {
            padding: 0 15px;
        }

        .logo span:last-child {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 480px) {
        .signup-container {
            padding: 25px 15px;
        }

        .signup-container h1 {
            font-size: 1.8rem;
        }

        input {
            padding: 12px 15px;
        }

        button[type="submit"] {
            padding: 14px 25px;
        }
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
    <div class="signup-container">
        <h1>🎯 INSCRIPTION</h1>
        <p class="slogan">
            Relevez le défi ultime dans le tournoi eFootball 2025 !
        </p>

        <div class="benefits-list">
            <ul>
                <li><i class="fas fa-trophy"></i> Prix exclusifs et merchandising officiel</li>
                <li><i class="fas fa-gamepad"></i> Affrontez les meilleurs joueurs mondiaux</li>
                <li><i class="fas fa-globe"></i> Tournoi 100% en ligne</li>
                <li><i class="fas fa-graduation-cap"></i> Coaching et conseils experts</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('inscrit.store') }}">
            @csrf

            <div class="form-group">
                <input type="text" name="nom" placeholder="Votre nom" required>
                @error('nom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" name="prenom" placeholder="Votre prénom" required>
                @error('prenom')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" name="pseudo" placeholder="Pseudo gaming" required>
                @error('pseudo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="tel" name="telephone" placeholder="Numéro de téléphone" required>
                @error('telephone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Adresse email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" name="pays" placeholder="Pays de résidence" required>
                @error('pays')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Créez un mot de passe" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirmez le mot de passe" required>
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">
                <i class="fas fa-user-plus"></i> REJOINDRE LE TOURNOI
            </button>
        </form>

        {{-- <p class="info">
            <i class="fas fa-users"></i> Déjà 500+ champions nous ont rejoint !
        </p> --}}

        <div class="signup-link">
            <p>Déjà membre ? <a href="{{ route('participant.login') }}">Connectez-vous ici</a></p>
        </div>
    </div>
</section>

<script>
    // Création des particules animées
    function createParticles() {
        const particlesContainer = document.getElementById('particles');
        const particleCount = 20;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';

            // Position aléatoire
            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.animationDelay = Math.random() * 6 + 's';
            particle.style.animationDuration = (3 + Math.random() * 4) + 's';

            // Taille aléatoire
            const size = 2 + Math.random() * 3;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';

            particlesContainer.appendChild(particle);
        }
    }

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        createParticles();

        // Effet de focus sur les inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });

    // Validation en temps réel
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="password_confirmation"]');

            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas !');
                confirmPassword.focus();
            }
        });
    });
</script>

</body>
</html>
