<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Innovante</title>
    <link rel="stylesheet" href="{{asset('css/colis.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="bubbles">

    </div>

    <div class="login-container">
        <div class="logo">
            <i class="fas fa-rocket"></i>
            <h2>Bienvenue Administracteur</h2>
        </div>

        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="input-group"><input class="form-control" type="email" name="email" placeholder="Votre email"></div>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="input-group"><input class="form-control" type="password" name="password" placeholder="Mot de passe"></div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            <div class="options">
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>
                <div class="forgot-password">
                    <a href="#">Mot de passe oublié ?</a>
                </div>
            </div>

            <div class="mb-3">

            </div>
            <div class="mb-3"><button class="login-btn" type="submit">Connexion</button></div>

            <div class="social-login">
                <p>Ou connectez-vous avec</p>
                <div class="social-icons">
                    <div class="social-icon facebook">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="social-icon twitter">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <div class="social-icon google">
                        <i class="fab fa-google"></i>
                    </div>
                </div>
            </div>

            <div class="signup-link">
                {{-- <p>Pas encore membre ? <a href=" /client-login ">S'inscrire</a></p> --}}
            </div>
        </form>
    </div>
</body>
</html>
