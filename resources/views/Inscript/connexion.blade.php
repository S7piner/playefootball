    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Connexion Tournoi eFootball</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Inscription.css') }}">
    </head>
    <body>

    <!-- TOP BAR -->
    <header class="topbar">
    <div class="topbar-inner">
        <div class="logo">
            <span class="logo-mark"></span>
            <span>FOCUS<br>eFootball</span>
        </div>

        <nav>
            <!-- <a href="Accueil.html">Accueil</a>
            <a href="#">Nouveautés</a>
            <div class="dropdown">
                <a href="#">Tournois disponibles ▾</a>
                <ul class="dropdown-content">
                    <li><a href="#">Champions League</a></li>
                    <li><a href="#">Europa League</a></li>
                    <li><a href="#">Conference League</a></li>
                </ul>
            </div>
            <a href="#"><strong>Histoire</strong></a> -->
        </nav>

        <div class="pill">
            <a class="btn" href="/">Accueil</a>
        </div>
    </div>
    </header>

    <!-- HERO -->
    <section class="hero" role="img" aria-label="Banishers banner">
        <div class="hero-overlay"></div>

        <div class="signup-container">
            <h1>Connexion Tournoi</h1>
            <p class="slogan">
                Participez au tournoi eFootball 2025 et mesurez-vous aux meilleurs joueurs du monde !
            </p>
            <form method="POST" action="{{ route('login') }}">
                @csrf


                <input type="text" name="email" placeholder="Email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror


                <!-- <input type="file" name="image" class="form-control" accept="image/*" required> -->
                <input type="password" name="password" placeholder="Mot de passe" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit">Connexion</button>
            </form>
            <p class="info">
                Rejoignez déjà plus de 500 joueurs inscrits dans le tournoi eFootball 2025 !
            </p>
            <div class="signup-link">
                <p>Créer un compte ? <a href="{{ route('inscrit.create') }}">S'inscrire</a></p>
            </div>
        </div>
    </section>

    </body>
    </html>
