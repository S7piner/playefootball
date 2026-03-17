@extends('create')

@section('content')
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tournois->nom }} - Détails du Tournoi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at top, #0a0a20, #050512);
            color: white;
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: linear-gradient(to bottom, rgba(0,0,0,0.6), rgba(5,5,15,1)),
                        url('{{ asset('storage/'.$tournois->image) }}');
            background-size: cover;
            background-position: center;
            height: 55vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero h1 {
            font-size: 3rem;
            color: #00ff9d;
            text-shadow: 0 0 15px #00ff9d;
        }
        .info-card {
            background: linear-gradient(145deg, #111132, #0a0a20);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,255,150,0.15);
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: scale(1.02);
        }
        .btn-primary {
            background: linear-gradient(90deg, #00ff9d, #00c9ff);
            color: #0b0b1f;
            font-weight: bold;
        }
        .btn-primary:hover {
            transform: scale(1.05);
            background: linear-gradient(90deg, #00c9ff, #00ff9d);
        }
        .btn-secondary {
            border: 1px solid #00ff9d;
            color: #00ff9d;
        }
        .btn-secondary:hover {
            background: #00ff9d;
            color: #0a0a20;
        }
    </style>
</head>
<body>

    <!-- 🏁 Section image principale -->
    <div class="hero">
        <h1>{{ $tournois->nom }}</h1>
    </div>

    <!-- 🧩 Contenu principal -->
    <div class="container mx-auto px-6 py-10">

        <div class="grid md:grid-cols-2 gap-10">
            <!-- 🖼️ Image du tournoi -->
            <div>
                <img src="{{ asset('storage/'.$tournois->image) }}"
                     alt="{{ $tournois->nom }}"
                     class="rounded-2xl shadow-lg w-full object-cover h-80">
            </div>

            <!-- 📋 Détails du tournoi -->
            <div class="info-card p-8">
                <h2 class="text-2xl font-bold text-green-400 mb-4">Détails du Tournoi</h2>

                <ul class="space-y-3 text-gray-300">
                    <li><strong class="text-green-400">🏆 Nom :</strong> {{ $tournois->nom }}</li>
                    <li><strong class="text-green-400">📅 Date :</strong> {{ \Carbon\Carbon::parse($tournois->date)->format('d/m/Y') }}</li>
                    <li><strong class="text-green-400">💰 Caution :</strong> {{ $tournois->caution }} FCFA</li>
                    <li><strong class="text-green-400">📍 Lieu :</strong> {{ $tournois->lieu ?? 'Non spécifié' }}</li>
                </ul>

                <hr class="my-5 border-gray-700">

                <h3 class="text-xl font-semibold text-green-400 mb-2">Description :</h3>
                <p class="text-gray-400 leading-relaxed">
                    {{ $tournois->description ?? 'Aucune description disponible pour ce tournoi.' }}
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('tournois.index') }}"
                       class="btn-secondary px-5 py-2 rounded-lg transition text-sm">
                       ⬅️ Retour
                    </a>

                    <a href="#"
                       class="btn-primary px-6 py-2 rounded-lg transition text-sm">
                       ⚔️ Participer maintenant
                    </a>
                </div>
            </div>
        </div>

        <!-- ⚙️ Informations additionnelles -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-center text-green-400 mb-6">Informations supplémentaires</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="info-card p-6">
                    <h4 class="text-lg font-semibold text-green-400 mb-2">🎮 Type de match</h4>
                    <p class="text-gray-400">1 vs 1 en ligne ou sur console locale (selon les conditions du tournoi).</p>
                </div>
                <div class="info-card p-6">
                    <h4 class="text-lg font-semibold text-green-400 mb-2">🏅 Récompense</h4>
                    <p class="text-gray-400">Prix pour les 3 premiers : trophée, manette, et bonus cash.</p>
                </div>
                <div class="info-card p-6">
                    <h4 class="text-lg font-semibold text-green-400 mb-2">📞 Contact</h4>
                    <p class="text-gray-400">Pour plus d'informations : <a href="mailto:contact@efootball.com" class="text-green-400 hover:underline">contact@efootball.com</a></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@endsection
