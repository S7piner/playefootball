<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commencer le Tournoi ⚽</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    color: #fff;
}

.container {
    width: 100%;
    max-width: 500px;
    padding: 20px;
}

.card {
    background: rgba(30,30,30,0.85);
    border: 2px solid #00ff88;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 0 30px rgba(0,255,136,0.5);
    animation: fadeIn 0.8s ease;
}

.card h2 {
    text-align: center;
    font-size: 28px;
    color: #00ff88;
    margin-bottom: 15px;
    text-shadow: 0 0 10px #00ff88, 0 0 20px #00d4ff;
}

.card p {
    text-align: center;
    color: #cbd5e1;
    font-size: 14px;
    margin-bottom: 25px;
    line-height: 1.6;
}

.info-box {
    background: rgba(0,255,136,0.05);
    border: 1px solid #00ff88;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    transition: transform 0.3s;
}

.info-box:hover {
    transform: scale(1.03);
}

.info-box h4 {
    color: #00ff88;
    margin-bottom: 10px;
    text-shadow: 0 0 5px #00ff88;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 5px;
}

input[type="file"] {
    background: rgba(255,255,255,0.05);
    border: 1px solid #00ff88;
    border-radius: 10px;
    padding: 12px;
    color: #cbd5e1;
    cursor: pointer;
    transition: 0.3s;
}
input[type="file"]:hover {
    background: rgba(0,255,136,0.1);
}

button {
    background: linear-gradient(90deg, #00ff88, #00d4ff);
    color: #0d0d0d;
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.3s;
    text-shadow: 0 0 5px #000;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 20px rgba(0,255,136,0.7);
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    color: #94a3b8;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
}

.back-link:hover {
    color: #00ff88;
    text-shadow: 0 0 5px #00ff88;
}

.alert {
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
}

.alert-success {
    background: rgba(0,255,136,0.1);
    border: 1px solid #00ff88;
    color: #00ff88;
}

.alert-danger {
    background: rgba(255,0,0,0.1);
    border: 1px solid #ff4d4d;
    color: #ff4d4d;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 600px) {
    .card {
        padding: 20px;
    }
}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Commencer le Tournoi ⚽</h2>
        <p>
            Pour valider votre participation, effectuez un dépôt sur l’un des numéros ci-dessous puis téléversez la capture d’écran du paiement.
        </p>

        <div class="info-box">
            <h4>Informations de Paiement 💳</h4>
            <p><strong>MTN Money :</strong> 61000000</p>
            <p><strong>Moov Money :</strong> 97000000</p>
            <p><strong>Montant :</strong>{{ $tournoi->caution }} FCFA</p>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data">
            <label for="capture">Capture d’écran du paiement</label>
            <input type="file" id="capture" name="capture" accept="image/*" required>

            <button type="submit">Envoyer ma capture</button>
        </form>

        <a href="#" class="back-link">← Retour au tournoi</a>
    </div>
</div>
</body>
</html>
