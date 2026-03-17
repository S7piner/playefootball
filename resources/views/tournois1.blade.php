<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ligue des Champions eFootball</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: "Poppins", sans-serif;
      background: url("eo.jpg") center / cover no-repeat fixed;
      min-height: 100vh;
      color: white;
      position: relative;
    }
    body::before {
      content: "";
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.75);
      backdrop-filter: blur(2px);
      z-index: -1;
    }

    header {
      background: rgba(0,0,0,0.8);
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.7);
    }
    header h2 {
      font-size: 1.8rem;
      background: linear-gradient(90deg, #ffcc00, #ff6f00);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    header a {
      color: #ffcc00;
      text-decoration: none;
      border: 2px solid #ffcc00;
      padding: 0.5rem 1rem;
      border-radius: 10px;
      transition: 0.3s;
      font-weight: 600;
    }
    header a:hover {
      background: #ffcc00;
      color: #000;
    }

    .content {
      max-width: 950px;
      margin: 4rem auto;
      background: rgba(20, 20, 20, 0.85);
      padding: 2.5rem 3rem;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.7);
      animation: fadeIn 1s ease forwards;
    }
    @keyframes fadeIn { from { opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }

    /* Onglets */
    .tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 2rem;
      gap: 1rem;
    }
    .tab {
      padding: 0.8rem 2rem;
      background: rgba(255,255,255,0.05);
      border: 2px solid #00a867;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
      transition: 0.3s;
    }
    .tab.active {
      background: #00a867;
      border-color: #007a5a;
      color: #fff;
    }

    /* Sections */
    .section { display: none; }
    .section.active { display: block; }

    /* Cartes info */
    .info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
    }
    .card {
      background: linear-gradient(145deg, #111, #222);
      border: 2px solid #00a867;
      border-radius: 15px;
      padding: 1.5rem;
      text-align: center;
      transition: 0.4s;
      box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    }
    .card:hover { transform: translateY(-5px); box-shadow:0 8px 25px rgba(0,0,0,0.8);}
    .card strong { display:block; font-size:1.2rem; color:#00a867; margin-bottom:0.5rem;}
    .card span { color:#fff; font-size:1rem; }

    .btn {
      display: inline-block;
      margin: 2.5rem auto 0;
      background: linear-gradient(90deg, #00a867, #007a5a);
      color: white;
      padding: 0.9rem 2rem;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      font-size: 1.1rem;
      text-align: center;
      transition: 0.4s;
      box-shadow: 0 4px 15px rgba(0,0,0,0.5);
    }
    .btn:hover {
      background: linear-gradient(90deg, #007a5a, #00593b);
      transform: scale(1.05);
      box-shadow: 0 6px 20px rgba(0,0,0,0.7);
    }
  </style>
</head>
<body>

<header>
  <h2>Ligue des Champions eFootball</h2>
  <a href="index.html">← Retour</a>
</header>

<div class="content">
  <h1>Détails du Tournoi</h1>

  <!-- Onglets -->
  <div class="tabs">
    <div class="tab active" data-target="tournoi">TOURNOI</div>
    <div class="tab" data-target="standen">STANDEN</div>
    <div class="tab" data-target="schema">SCHEMA</div>
  </div>

  <!-- Sections -->
  <div id="tournoi" class="section active">
    <p>
      Bienvenue dans la <strong>Ligue des Champions eFootball</strong> ! Ce tournoi rassemble
      les meilleurs clubs virtuels d’Europe pour une compétition pleine d’intensité et de stratégie.
      Les joueurs s’affrontent dans une série de matchs éliminatoires jusqu’à la grande finale.
    </p>
    <div class="info">
      <div class="card">
        <strong>📅 Dates</strong>
        <span>20 - 30 Octobre 2025</span>
      </div>
      <div class="card">
        <strong>🏟️ Lieu</strong>
        <span>En ligne (serveurs européens)</span>
      </div>
      <div class="card">
        <strong>💰 Récompense</strong>
        <span>5000 € + Trophée officiel</span>
      </div>
      <div class="card">
        <strong>🎮 Format</strong>
        <span>Phase de groupes + élimination directe</span>
      </div>
    </div>
    <a href="#" class="btn">Participer</a>
  </div>

  <div id="standen" class="section">
    <p style="text-align:center; color:#ffcc00; font-weight:600; font-size:1.2rem;">Classement à venir...</p>
  </div>

  <div id="schema" class="section">
    <p style="text-align:center; color:#ffcc00; font-weight:600; font-size:1.2rem;">Schéma des matchs à venir...</p>
  </div>

</div>

<script>
  const tabs = document.querySelectorAll('.tab');
  const sections = document.querySelectorAll('.section');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      sections.forEach(sec => sec.classList.remove('active'));
      document.getElementById(tab.dataset.target).classList.add('active');
    });
  });
</script>

</body>
</html>
    card.innerHTML = `
        <img src="${tournoi.image}" alt="${tournoi.nom}" style="width:100%; border-radius:10px; margin-bottom:1rem;">
        <h3>${tournoi.nom}</h3>
        <p><strong>Date:</strong> ${tournoi.date}</p>
        <p>${tournoi.description}</p>
        <a href="${tournoi.lien}" class="btn">Voir Détails</a>
      `;
      container.appendChild(card);
    });
  </script>
</body>
</html>
<div class="tournois-container" id="tournois"></div>
  </main>
