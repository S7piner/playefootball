
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournois eFootball</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">

    <style>
        body {
            background: radial-gradient(circle at top, #0b0b1f, #050510);
            font-family: 'Poppins', sans-serif;
        }
        header {
            background: rgba(15, 15, 40, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .tournament-card {
            background: linear-gradient(145deg, #111132, #0a0a20);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease-in-out;
        }
        .tournament-card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 255, 150, 0.3);
        }
        .btn-primary {
            background: linear-gradient(90deg, #00ff95, #00c9ff);
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #00c9ff, #00ff95);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- 🌐 Entête / Navbar -->
    <header class="fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-green-400">eFootball Arena</h1>
            <nav class="space-x-6 hidden md:flex">
                <a href="{{ route('participant') }}" class="text-gray-300 hover:text-green-400 transition">Accueil</a>
                {{-- <a href="{{ route('tournois.create') }}" class="text-gray-300 hover:text-green-400 transition">Créer un tournoi</a>
                <a href="#" class="text-gray-300 hover:text-green-400 transition">Classement</a> --}}
            </nav>
            <button class="md:hidden text-white text-2xl">&#9776;</button>
        </div>
    </header>

    <!-- 🏆 Section principale -->
    <div class="pt-28 container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-green-400 mb-10">Tournois disponibles</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($tournois as $tournois)
                <div class="tournament-card rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/'.$tournois->image) }}"
                         alt="{{ $tournois->nom }}"
                         class="w-full h-56 object-cover">

                    <div class="p-5 text-white">
                        <h3 class="text-xl font-bold text-green-400 mb-2">{{ $tournois->nom }}</h3>
                        <p class="text-gray-400 text-sm mb-4">{{ Str::limit($tournois->description, 100) }}</p>

                        <div class="flex justify-between items-center text-sm text-gray-400 mb-4">
                            <span>📅 {{ $tournois->date }}</span>
                            <span>Caution {{ $tournois->caution }} FCFA</span>
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('participant.tournois.show', $tournois->id) }}"
                               class="w-1/2 text-center py-2 rounded-lg font-semibold text-gray-900 btn-primary transition">
                                Voir détail
                            </a>
                            <a href="{{ route('participant.journees', $tournois->id) }}"
   class="w-1/2 text-center py-2 rounded-lg font-semibold text-gray-900 btn-primary transition">
   Journées
</a>


                            {{-- <form action="{{ route('tournois.destroy', $tournois->id) }}" method="GET" class="w-1/2">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Supprimer ce tournoi ?')"
                                        class="w-full bg-red-600 text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition">
                                    Supprimer
                                </button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-400 text-lg">
                    Aucun tournoi disponible pour le moment 😔
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
