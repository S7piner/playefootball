@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 flex flex-col items-center justify-center py-10 px-4">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl w-full max-w-lg text-center text-white">
        <h1 class="text-3xl font-bold mb-4 text-green-400">Participation au tournoi</h1>
        <h2 class="text-xl mb-6">{{ $tournoi->nom }}</h2>

        <p class="text-gray-300 mb-4">
            Pour valider votre participation, veuillez effectuer le dépôt de la caution
            sur l’un des numéros ci-dessous :
        </p>

        <div class="bg-gray-700 p-4 rounded-lg mb-6 text-left">
            <p>📞 MTN : <strong>97 45 23 18</strong></p>
            <p>📞 MOOV : <strong>66 22 10 88</strong></p>
            <p>💰 Montant : <strong>{{ $tournoi->caution ?? '500 FCFA' }}</strong></p>
        </div>

        <form action="{{ route('participations.store', $tournoi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label class="block mb-2 font-semibold">📸 Capture d’écran du paiement</label>
                <input type="file" name="capture" accept="image/*"
                       class="w-full border-2 border-gray-600 rounded-lg p-2 bg-gray-900 text-gray-300 focus:border-green-500">
            </div>

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white py-3 px-6 rounded-lg w-full font-bold transition">
                Envoyer la capture 📤
            </button>
        </form>

        <p class="text-gray-400 mt-5 text-sm">
            ⏳ Vous serez ajouté à la liste d’attente après vérification de votre paiement.
        </p>
    </div>
</div>
@endsection
