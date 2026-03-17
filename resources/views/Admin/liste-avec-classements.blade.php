@extends('create')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <h5 class="mb-0"><i class="fa fa-trophy me-2 text-warning"></i>Tournois Disponibles</h5>
                    <p class="mb-0 mt-2 text-sm">Sélectionnez un tournoi pour voir son classement</p>
                </div>

                <div class="card-body">
                    @if($tournois->isEmpty())
                        <div class="text-center py-5">
                            <i class="fa fa-trophy fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">Aucun tournoi disponible pour le moment.</p>
                            <a href="{{ route('tournois.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus me-2"></i>Créer un Tournoi
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($tournois as $tournoi)
                                @php
                                    // Récupère le nombre de participants pour ce tournoi
                                    $nbParticipants = \App\Models\Classement::where('tournoi_id', $tournoi->id)->count();
                                    $nbMatchsJoues = \App\Models\Journer::where('tournoi_id', $tournoi->id)
                                                                        ->where('statut', 'termine')
                                                                        ->count();
                                @endphp

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card tournoi-card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center p-4">
                                            @if($tournoi->image)
                                                <img src="{{ asset('storage/' . $tournoi->image) }}"
                                                     class="tournoi-image mb-3"
                                                     alt="{{ $tournoi->nom }}">
                                            @else
                                                <div class="tournoi-placeholder mb-3">
                                                    <i class="fa fa-trophy text-primary fa-3x"></i>
                                                </div>
                                            @endif

                                            <h5 class="card-title text-dark fw-bold">{{ $tournoi->nom }}</h5>

                                            @if($tournoi->description)
                                                <p class="card-text text-muted small mb-3">
                                                    {{ Str::limit($tournoi->description, 100) }}
                                                </p>
                                            @endif

                                            <div class="tournoi-stats mb-3">
                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <div class="stat-item">
                                                            <div class="stat-number text-primary fw-bold">{{ $nbParticipants }}</div>
                                                            <div class="stat-label text-xs text-muted">Joueurs</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="stat-item">
                                                            <div class="stat-number text-success fw-bold">{{ $nbMatchsJoues }}</div>
                                                            <div class="stat-label text-xs text-muted">Matchs</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="stat-item">
                                                            <div class="stat-number text-warning fw-bold">{{ $tournoi->caution }} F</div>
                                                            <div class="stat-label text-xs text-muted">Caution</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tournoi-date mb-3">
                                                <i class="fa fa-calendar me-1 text-secondary"></i>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($tournoi->date)->format('d/m/Y') }}</small>
                                            </div>

                                            <a href="{{ route('admin.classement', ['tournoi' => $tournoi->id]) }}"
                                               class="btn btn-primary btn-sm w-100">
                                                <i class="fa fa-chart-bar me-2"></i>Voir le Classement
                                            </a>
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
</div>

<style>
.tournoi-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.tournoi-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.tournoi-image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
}

.tournoi-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 3px solid #007bff;
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

.bg-gradient-primary {
    background: linear-gradient(90deg, #007bff, #00b894);
}
</style>
@endsection
