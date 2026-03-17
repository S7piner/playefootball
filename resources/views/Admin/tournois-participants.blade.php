@extends('create')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-0 text-white"><i class="fa fa-users me-2 text-success"></i>Gestion des Participants</h4>
                    <p class="mb-0 text-light">Sélectionnez un tournoi pour gérer ses participants</p>
                </div>

                @if($tournois->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">Aucun tournoi disponible pour le moment.</p>
                        <a href="{{ route('tournois.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Créer un Tournoi
                        </a>
                    </div>
                @else
                    <div class="row">
                        @foreach($tournois as $tournoi)
                            @php
                                // Statistiques du tournoi - CORRECTION ICI
                                $nbParticipants = \App\Models\Inscrit::where('tournoi_id', $tournoi->id)
                                                    ->where('authorized', true)
                                                    ->count();
                                $nbJourneesGenerees = \App\Models\Journer::where('tournoi_id', $tournoi->id)
                                                    ->distinct()
                                                    ->pluck('numero_journee')
                                                    ->count();
                                $hasJournees = $nbJourneesGenerees > 0;
                            @endphp

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card tournoi-card h-100 border-0 shadow">
                                    <div class="card-body text-center p-4 bg-dark text-white rounded">
                                        @if($tournoi->image)
                                            <img src="{{ asset('storage/' . $tournoi->image) }}"
                                                 class="tournoi-image mb-3"
                                                 alt="{{ $tournoi->nom }}">
                                        @else
                                            <div class="tournoi-placeholder mb-3">
                                                <i class="fa fa-users text-success fa-3x"></i>
                                            </div>
                                        @endif

                                        <h5 class="card-title text-success fw-bold">{{ $tournoi->nom }}</h5>

                                        @if($tournoi->description)
                                            <p class="card-text text-light small mb-3">
                                                {{ Str::limit($tournoi->description, 100) }}
                                            </p>
                                        @endif

                                        <div class="tournoi-stats mb-3">
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <div class="stat-number text-primary fw-bold">{{ $nbParticipants }}</div>
                                                        <div class="stat-label text-xs text-light">Participants</div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <div class="stat-number text-warning fw-bold">{{ $nbJourneesGenerees }}</div>
                                                        <div class="stat-label text-xs text-light">Journées générées</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tournoi-date mb-3">
                                            <i class="fa fa-calendar me-1 text-light"></i>
                                            <small class="text-light">{{ \Carbon\Carbon::parse($tournoi->date)->format('d/m/Y') }}</small>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <a href="{{ route('inscrit.attente', ['tournoi_id' => $tournoi->id]) }}"
                                               class="btn btn-success btn-sm">
                                                <i class="fa fa-cog me-2"></i>Gérer les Participants
                                            </a>

                                            @if($hasJournees)
                                                <a href="{{ route('admin.calendrier', ['tournoi' => $tournoi->id]) }}"
                                                   class="btn btn-info btn-sm">
                                                    <i class="fa fa-calendar-alt me-2"></i>Voir le Calendrier
                                                </a>
                                            @else
                                                <button class="btn btn-outline-warning btn-sm" disabled>
                                                    <i class="fa fa-clock me-2"></i>Calendrier non généré
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.tournoi-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.tournoi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3) !important;
}

.tournoi-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #198754;
}

.tournoi-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(45deg, #343a40, #495057);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 3px solid #198754;
}

.stat-item {
    padding: 5px;
}

.stat-number {
    font-size: 1.2rem;
    line-height: 1;
}

.stat-label {
    font-size: 0.7rem;
    margin-top: 2px;
}
</style>
@endsection
