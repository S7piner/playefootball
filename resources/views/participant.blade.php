<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tournoi eFootball</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/Participant.css') }}">
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">
  <style>
        #avatarPreview {
        transition: all 0.3s ease-in-out;
        opacity: 0;
    }
    #avatarPreview.show {
        opacity: 1;
    }

    /* 🟩 Bloc principal */
    .card {
        background: #1a1f25;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        margin-bottom: 30px;
        color: #fff;
    }

    /* 🔥 Fade-in animation */
    .fade-in {
        animation: fadeIn 0.8s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* 🔥 Header */
    .header-block {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .icon-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .icon {
        width: 40px;
        height: 40px;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: bold;
        color: #3ecf8e;
    }

    /* 🔘 Boutons */
    .btn {
        padding: 8px 15px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .btn.primary {
        background: #3ecf8e;
        color: #0d1117;
    }
    .btn.primary:hover {
        background: #32b777;
    }

    .btn.wa {
        background: #25D366;
        color: #fff;
    }
    .btn.wa:hover {
        background: #1ebe5a;
    }

    /* 🏆 Podium */
    .podium {
        display: flex;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .rank {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #232a32;
        padding: 15px;
        border-radius: 14px;
        width: 100%;
        animation: fadeIn 1s ease;
    }

    .rank img {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #3ecf8e;
    }

    .medal {
        font-size: 25px;
    }

    .gold { color: gold; }
    .silver { color: silver; }

    .info .name {
        font-size: 1.1rem;
        font-weight: 600;
    }

    .info .small {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .info .wins {
        margin-top: 5px;
        font-size: 0.85rem;
        color: #3ecf8e;
    }

    /* 📱 WhatsApp */
    .wa-block {
        margin-top: 15px;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .wa-block svg {
        width: 45px;
        height: 45px;
        color: #25D366;
    }

    .wa-content .note {
        margin-top: 5px;
        font-size: 0.85rem;
        opacity: 0.7;
    }

    .mt { margin-top: 25px; }


  </style>
</head>
<body>
  <div class="container">
    <!-- HEADER -->
    <div class="header">
      <div class="brand">
        <span class="dot"></span>
        <h1>Centre des tournois eFootball</h1>
      </div>
     <form action="/participant/logout" method="POST" style="display:inline">
        @csrf
        <button type="submit" class="cta" style="background: red; border: none; color: white">Déconnexion</button>
     </form>

      <a class="cta" href="/regle">Règlement du tournoi</a>
    </div>

    <!-- GRID -->
    <div class="grid">
      <!-- COL 1 : PROFIL -->
      <section class="card fade-in">
        <div style="display:flex;align-items:center;gap:8px">
  <h3 style="margin:0">Bienvenue {{ $user->nom }}</h3>

  <form id="avatarForm" method="POST" action="{{ route('inscrit.avatar') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none">
    <button type="button" id="avatarBtn" class="btn">Ajouter image</button>
  </form>

  <img id="avatarPreview" src="{{ $user->avatar ?? 'https://i.pravatar.cc/160?img=12' }}"
     alt="Avatar"
     style="width:40px; height:40px; border-radius:50%;">

</div>
        <hr class="sep">
        <div class="profile">
          <div class="avatar">
            @if ($user->avatar)
              <img src="{{ $user->avatar }}" alt="Avatar">
            @else
              <img src="https://i.pravatar.cc/160?img=12" alt="">
            @endif
          </div>
          <div>
            <div style="font-weight:700">{{ $user->pseudo }}</div>
            <div class="small">WhatsApp : {{ $user->telephone }}</div>
            {{-- <div class="gain">Gain : 0 FCFA</div> --}}
          </div>
        </div>
        <hr class="sep">

        <div class="tabs">
          <div class="tab active" data-tab="infos">Mes infos</div>
          <div class="tab" data-tab="tournois">Mes tournois</div>
        </div>

        <div class="tab-content active" id="infos">
          <ul class="info-list">
            <li><span>Prenom</span><strong>{{ $user->prenom }}</strong></li>
            <li><span>Pseudo in-game</span><strong>{{ $user->pseudo }}</strong></li>
            <li><span>Téléphone</span><strong>{{ $user->telephone }}</strong></li>
            <li><span>Email</span><strong>{{ $user->email }}</strong></li>
          </ul>
        </div>

        {{-- <div class="tab-content" id="tournois">
          <p class="small">Historique de participation disponible bientôt...</p>
        </div> --}}

        <div class="stats">
          <div class="stat">
            <div class="big">{{ $tournois }}</div>
            <div class="label">Tournois</div>
          </div>
          {{-- <div class="stat">
            <div class="big">6</div>
            <div class="label">Victoires</div>
          </div>
          <div class="stat">
            <div class="big">0</div>
            <div class="label">Perdu</div>
          </div> --}}
        </div>
      </section>

      <!-- COL 2 : TOURNOIS DISPO -->
      <section class="card available fade-in">
        <h3 class="section-title">Tournois disponibles</h3>

        <div class="banner">
          <img src="main_page_1.png" alt="">
          <div class="big-title">TOURNOI<br>2026</div>
        </div>

        <div class="row">
          {{-- <div class="pill"><div class="k">Équipes</div><div class="v">32</div></div>
          <div class="pill"><div class="k">Tournois</div><div class="v">3</div></div>
          <div class="pill"><div class="k">Caution</div><div class="v">500</div></div> --}}
        </div>

        <h3 class="section-title mt">Règlement du tournoi</h3>
        <ul class="conditions">
          <li>Tournois disponibles</li>
          <li>Tout le monde peut participer</li>
          <li>Règles officielles eFootball</li>
          <li>Respect des adversaires</li>
          <li>Connexion stable</li>
          <li>Respect des horaires</li>
        </ul>

        <a href="{{ route('participant.tournois') }}" class="btn" style="display:block;text-align:center;">Participer</a>
      </section>


      <section class="card contact fade-in">

    <!-- 🔥 HEADER TOURNOI -->
    <div class="header-block">
        <div class="icon-title">
            <img src="tournoi.png" alt="Icône" class="icon">
            <h3 class="section-title">Informations supplémentaires</h3>
        </div>

        {{-- <a class="btn primary" href="#" target="_blank">Voir le classement</a> --}}
    </div>
    <h3 class="section-title mt">Envoyer la capture des matchs ici</h3>

    <div class="wa-block">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 2a10 10 0 0 0-8.66 15.01L2 22l5.12-1.33A10 10 0 1 0 12 2Z" stroke="currentColor" stroke-width="1.2" />
            <path d="M9.5 8.8c0 3.1 2.4 5.6 5.3 5.6.5 0 1.1-.1 1.5-.3l-1-1c-.1-.1-.3-.1-.5 0-.3.2-.7.3-1 .3-1.7 0-3-1.4-3-3.1 0-.4.1-.8.3-1.1 0-.2 0-.4-.1-.5l-1-1a3.2 3.2 0 0 0-.4 1.1Z" fill="currentColor"/>
        </svg>

        <div class="wa-content">
            <a class="btn wa" href="https://chat.whatsapp.com/Ja5ZPR16abl92XsCqirHBf?mode=hqrc" target="_blank">Rejoindre</a>
            <div class="note">Après avoir joué un match, veuillez envoyer vos captures de matchs dans ce groupe.</div>
        </div>
    </div>

    <!-- 🏆 PODIUM -->
    {{-- <div class="podium">

        <div class="rank rank-1">
            <div class="medal gold">🥇</div>
            <img src="https://i.pravatar.cc/120?img=20" alt="">
            <div class="info">
                <div class="name">1er du Tournoi</div>
                <div class="small">Pseudo eFootball</div>
                <div class="wins">12 victoires</div>
            </div>
        </div>

        <div class="rank rank-2">
            <div class="medal silver">🥈</div>
            <img src="https://i.pravatar.cc/120?img=32" alt="">
            <div class="info">
                <div class="name">2ème du Tournoi</div>
                <div class="small">Fracdanfort</div>
                <div class="wins">3 victoires</div>
            </div>
        </div>

    </div> --}}

    <!-- 🔥 WHATSAPP -->
    <h3 class="section-title mt">Joindre le groupe WhatsApp</h3>

    <div class="wa-block">
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 2a10 10 0 0 0-8.66 15.01L2 22l5.12-1.33A10 10 0 1 0 12 2Z" stroke="currentColor" stroke-width="1.2" />
            <path d="M9.5 8.8c0 3.1 2.4 5.6 5.3 5.6.5 0 1.1-.1 1.5-.3l-1-1c-.1-.1-.3-.1-.5 0-.3.2-.7.3-1 .3-1.7 0-3-1.4-3-3.1 0-.4.1-.8.3-1.1 0-.2 0-.4-.1-.5l-1-1a3.2 3.2 0 0 0-.4 1.1Z" fill="currentColor"/>
        </svg>

        <div class="wa-content">
            <a class="btn wa" href="https://chat.whatsapp.com/J4w9EzfmsVl0FGtMz6nW0V" target="_blank">Rejoindre</a>
            <div class="note">Discuter avec les participants</div>
        </div>
    </div>

</section>

    </div>
  </div>

  <script src="{{ asset('js/Participant.js') }}"></script>
  <script>
        const avatarBtn = document.getElementById('avatarBtn');
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarForm = document.getElementById('avatarForm');

        avatarBtn.addEventListener('click', () => {
        avatarInput.click();
        });

        avatarInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if(file){
            // Prévisualisation
            const reader = new FileReader();
            reader.onload = (e) => {
            avatarPreview.src = e.target.result;
            avatarPreview.style.display = 'inline-block';
            avatarBtn.style.display = 'none';
            }
            reader.readAsDataURL(file);

            // Auto submit du formulaire
            avatarForm.submit();
        }
        });

        avatarPreview.onload = () => avatarPreview.classList.add('show');

</script>

</body>
</html>
