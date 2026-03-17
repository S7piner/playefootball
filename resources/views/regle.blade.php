<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règles de Déconnexion - eFootball</title>
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg,
                #0a0a0a 0%,
                #1a1a2e 25%,
                #16213e 50%,
                #0f3460 75%,
                #1b1b2f 100%);
            min-height: 100vh;
            padding: 15px;
            position: relative;
            overflow-x: hidden;
            color: #e0e0e0;
        }

        /* Effets eFootball sombre */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(44, 62, 80, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(231, 76, 60, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(52, 152, 219, 0.2) 0%, transparent 50%);
            animation: float 8s ease-in-out infinite;
        }

        /* Lignes de terrain subtiles sombres */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                linear-gradient(90deg, transparent 99%, rgba(255,255,255,0.02) 99%),
                linear-gradient(0deg, transparent 99%, rgba(255,255,255,0.02) 99%);
            background-size: 40px 40px;
            opacity: 0.3;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(0.2deg); }
        }

        .rules-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(30, 30, 46, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.4);
            overflow: hidden;
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 15s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 8px;
            font-weight: 700;
            position: relative;
            z-index: 2;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
            line-height: 1.3;
        }

        .header .subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
            font-weight: 300;
        }

        .rules-content {
            padding: 25px 20px;
            background: rgba(26, 26, 46, 0.9);
        }

        .rule-card {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-left: 4px solid #e74c3c;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .rule-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        }

        .rule-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #e74c3c, #c0392b);
        }

        .rule-card::after {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(231, 76, 60, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .time-range {
            font-size: 1.1rem;
            font-weight: 600;
            color: #ecf0f1;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            line-height: 1.4;
        }

        .time-range::before {
            content: '⏰';
            margin-right: 8px;
            font-size: 1.3rem;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
            flex-shrink: 0;
        }

        .requirement {
            font-size: 0.95rem;
            color: #bdc3c7;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
        }

        .requirement::before {
            content: '✅';
            margin-right: 8px;
            font-size: 1rem;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.3));
            flex-shrink: 0;
            margin-top: 2px;
        }

        .time-badge {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-left: 8px;
            box-shadow: 0 3px 8px rgba(231, 76, 60, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
        }

        .footer-note {
            text-align: center;
            margin-top: 25px;
            padding: 18px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-radius: 10px;
            font-style: italic;
            color: #95a5a6;
            border-left: 4px solid #e74c3c;
            border: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Effet de lueur subtile */
        .glow {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: radial-gradient(circle at 50% 0%, rgba(231, 76, 60, 0.08), transparent 50%);
            pointer-events: none;
        }

        /* ANIMATIONS RESPONSIVES */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rule-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .rule-card:nth-child(1) { animation-delay: 0.1s; }
        .rule-card:nth-child(2) { animation-delay: 0.2s; }
        .rule-card:nth-child(3) { animation-delay: 0.3s; }
        .rule-card:nth-child(4) { animation-delay: 0.4s; }
        .rule-card:nth-child(5) { animation-delay: 0.5s; }

        /* MEDIA QUERIES POUR MOBILE */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .rules-container {
                margin: 5px;
                border-radius: 12px;
            }

            .header {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 1.5rem;
                margin-bottom: 6px;
            }

            .header .subtitle {
                font-size: 0.85rem;
            }

            .rules-content {
                padding: 20px 15px;
            }

            .rule-card {
                padding: 18px 15px;
                margin-bottom: 12px;
                border-radius: 10px;
            }

            .time-range {
                font-size: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .time-range::before {
                margin-right: 0;
                margin-bottom: 5px;
            }

            .requirement {
                font-size: 0.9rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .requirement::before {
                margin-right: 0;
                margin-bottom: 2px;
            }

            .time-badge {
                margin-left: 0;
                margin-top: 5px;
                padding: 5px 10px;
                font-size: 0.85rem;
            }

            .footer-note {
                margin-top: 20px;
                padding: 15px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.3rem;
            }

            .header .subtitle {
                font-size: 0.8rem;
            }

            .rule-card {
                padding: 15px 12px;
            }

            .time-range {
                font-size: 0.95rem;
            }

            .requirement {
                font-size: 0.85rem;
            }

            .time-badge {
                font-size: 0.8rem;
                padding: 4px 8px;
            }

            body::after {
                background-size: 30px 30px;
            }
        }

        @media (max-width: 360px) {
            .header {
                padding: 15px 12px;
            }

            .header h1 {
                font-size: 1.2rem;
            }

            .rules-content {
                padding: 15px 12px;
            }

            .rule-card {
                padding: 12px 10px;
            }

            .time-range {
                font-size: 0.9rem;
            }

            .requirement {
                font-size: 0.8rem;
            }
        }

        /* Amélioration de l'affichage des badges sur mobile */
        @media (max-width: 768px) {
            .requirement {
                flex-wrap: wrap;
            }

            .time-badge {
                align-self: flex-start;
            }
        }

        /* Support tactile amélioré */
        @media (hover: none) {
            .rule-card:hover {
                transform: none;
                box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            }

            .rule-card:active {
                transform: scale(0.98);
                background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            }
        }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="rules-container">
        <div class="header">
            <h1>🏆 Règles de Déconnexion</h1>
            <div class="subtitle">Tournoi eFootball - Saison 2024</div>
        </div>

        <div class="rules-content">
            <div class="rule-card">
                <div class="time-range">
                    <span>Déconnexion à partir de 20min</span>
                </div>
                <div class="requirement">
                    <span>Partie complète de <span class="time-badge">9 minutes</span> nécessaire</span>
                </div>
            </div>

            <div class="rule-card">
                <div class="time-range">
                    <span>Déconnexion à partir de 30min</span>
                </div>
                <div class="requirement">
                    <span>Partie complète de <span class="time-badge">8 minutes</span> nécessaire</span>
                </div>
            </div>

            <div class="rule-card">
                <div class="time-range">
                    <span>Déconnexion à partir de 50min</span>
                </div>
                <div class="requirement">
                    <span>Partie complète de <span class="time-badge">7 minutes</span> nécessaire</span>
                </div>
            </div>

            <div class="rule-card">
                <div class="time-range">
                    <span>Déconnexion de 60min à 70min</span>
                </div>
                <div class="requirement">
                    <span>Mi-temps de <span class="time-badge">6 minutes</span> à jouer</span>
                </div>
            </div>

            <div class="rule-card">
                <div class="time-range">
                    <span>Déconnexion à partir de 80min+</span>
                </div>
                <div class="requirement">
                    <span>Mi-temps de <span class="time-badge">5 minutes</span> nécessaire</span>
                </div>
            </div>

            <div class="footer-note">
                ⚠️ Toute déconnexion intentionnelle peut entraîner des sanctions supplémentaires
            </div>
        </div>
    </div>
</body>
</html>
