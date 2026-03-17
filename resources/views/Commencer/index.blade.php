@extends('create')

@section('content')
<div class="container">
    <h1 class="title">Captures des Participations ⚽</h1>

    <div class="grid">
        @foreach($commencers as $commencer)
        <div class="card">
            <h3>{{ $commencer->inscrit->nom }} {{ $commencer->inscrit->prenom }}</h3>
            <p><strong>Tournoi :</strong> {{ $commencer->tournoi->nom ?? 'Inconnu' }}</p>
            <p><strong>Status :</strong> {{ $commencer->status }}</p>
            <img src="{{ asset($commencer->image) }}" alt="Capture" class="capture">
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
<style>
.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px 20px;
}

.title {
    text-align: center;
    color: #00ff88;
    font-size: 36px;
    margin-bottom: 40px;
    text-shadow: 0 0 10px #00ff88;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.card {
    background: rgba(30,30,30,0.85);
    border: 2px solid #00ff88;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 0 20px rgba(0,255,136,0.5);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 30px rgba(0,255,136,0.8);
}

.card h3 {
    color: #00ff88;
    margin-bottom: 10px;
}

.card p {
    color: #cbd5e1;
    margin-bottom: 10px;
    font-size: 14px;
}

.capture {
    width: 100%;
    border-radius: 12px;
    margin-top: 10px;
}
</style>
@endpush
