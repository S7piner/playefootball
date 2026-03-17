@extends('create')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-0 text-white"><i class="fa fa-calendar me-2 text-info"></i>Tournois - Calendriers</h4>
                    <p class="mb-0 text-light">Sélectionnez un tournoi pour voir son calendrier</p>
                </div>

                @if($tournois->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">Aucun tournoi disponible pour le moment.</p>
                        <a href="{{ route('tournois.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus me-2"></i>Créer un Tournoi
                        </a>
                    </div>
                @else
                    <div class="row">
                        @foreach($tournois as $tournoi)
                            @php
                                // CORRECTION : Compter correctement les journées distinctes
                                $numerosJournees = \App\Models\Journer::where('tournoi_id', $tournoi->id)
                                                    ->distinct()
                                                    ->pluck('numero_journee')
                                                    ->toArray();

                                $nbJournees = count($numerosJournees);
                                $nbMatchsTotal = \App\Models\Journer::where('tournoi_id', $tournoi->id)->count();
                                $nbMatchsJoues = \App\Models\Journer::where('tournoi_id', $tournoi->id)
                                                                    ->where('statut', 'termine')
                                                                    ->count();
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
                                                <i class="fa fa-calendar text-info fa-3x"></i>
                                            </div>
                                        @endif

                                        <h5 class="card-title text-info fw-bold">{{ $tournoi->nom }}</h5>

                                        @if($tournoi->description)
                                            <p class="card-text text-light small mb-3">
                                                {{ Str::limit($tournoi->description, 100) }}
                                            </p>
                                        @endif

                                        <div class="tournoi-stats mb-3">
                                            <div class="row text-center">
                                                <div class="col-4">
                                                    <div class="stat-item">
                                                        <div class="stat-number text-primary fw-bold">{{ $nbJournees }}</div>
                                                        <div class="stat-label text-xs text-light">Journées</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="stat-item">
                                                        <div class="stat-number text-success fw-bold">{{ $nbMatchsJoues }}/{{ $nbMatchsTotal }}</div>
                                                        <div class="stat-label text-xs text-light">Matchs</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="stat-item">
                                                        <div class="stat-number text-warning fw-bold">{{ $tournoi->caution }} F</div>
                                                        <div class="stat-label text-xs text-light">Caution</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tournoi-date mb-3">
                                            <i class="fa fa-calendar me-1 text-light"></i>
                                            <small class="text-light">{{ \Carbon\Carbon::parse($tournoi->date)->format('d/m/Y') }}</small>
                                        </div>

                                        <a href="{{ route('admin.calendrier', ['tournoi' => $tournoi->id]) }}"
                                           class="btn btn-info btn-sm w-100 text-dark">
                                            <i class="fa fa-calendar-alt me-2"></i>Voir le Calendrier
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
    border: 3px solid #0dcaf0;
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
    border: 3px solid #0dcaf0;
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
