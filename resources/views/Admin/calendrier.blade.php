@extends('create')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <!-- Card Calendrier -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6>Calendrier du Tournoi</h6>
                    <div>
                        {{-- <a href="{{ route('admin.classement') }}" class="btn btn-info me-2">
                            <i class="fa fa-trophy me-1"></i>Voir le Classement
                        </a>
                        <a href="{{ route('participant.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i>Retour
                        </a> --}}
                    </div>
                </div>

                <!-- Messages -->
                @if(session('success'))
                    <div class="alert alert-success mx-4 mt-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mx-4 mt-4">{{ session('error') }}</div>
                @endif

                <!-- Contenu calendrier -->
                <div class="card-body px-0 pt-0 pb-2">
                    @if($journees->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted">Aucune journée générée pour le moment.</p>
                            <a href="{{ route('participant.index') }}" class="btn btn-primary">Générer les Journées</a>
                        </div>
                    @else
                        <!-- Onglets Journées -->
                        <ul class="nav nav-tabs mb-3" id="journeesTab" role="tablist">
                            @foreach($journees as $numeroJournee => $matches)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-journee-{{ $numeroJournee }}"
                                            data-bs-toggle="tab" data-bs-target="#journee-{{ $numeroJournee }}"
                                            type="button" role="tab" aria-controls="journee-{{ $numeroJournee }}"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        Journée {{ $numeroJournee }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Contenu Onglets -->
                        <div class="tab-content">
                            @foreach($journees as $numeroJournee => $matches)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="journee-{{ $numeroJournee }}" role="tabpanel">
                                <div class="row">
                                    @foreach($matches as $match)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card shadow-sm match-card {{ $match->statut == 'termine' ? 'border-success' : 'border-secondary' }}">
                                                <div class="card-body p-3">
                                                    <div class="text-center mb-2">
                                                        <small class="badge bg-dark">ID: {{ $match->id }}</small>
                                                        <small class="badge bg-{{ $match->statut == 'termine' ? 'success' : 'secondary' }} ms-1">
                                                            {{ $match->statut }}
                                                        </small>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Joueur 1 -->
                                                        <div class="text-center flex-fill">
                                                            <h6 class="mb-1">{{ $match->joueur1->pseudo ?? 'BYE' }}</h6>
                                                            <small class="text-muted">{{ $match->joueur1->nom ?? '' }}</small>
                                                        </div>

                                                        <!-- Score / VS -->
                                                        <div class="score-section mx-3 text-center">
                                                            @if($match->statut == 'termine')
                                                                <span class="badge bg-success fs-6">{{ $match->score_joueur1 }} - {{ $match->score_joueur2 }}</span>
                                                                <small class="d-block text-success mt-1">Terminé</small>
                                                            @elseif(!$match->joueur1 || !$match->joueur2)
                                                                <span class="badge bg-warning fs-6">BYE</span>
                                                                <small class="d-block text-warning mt-1">Match annulé</small>
                                                            @else
                                                                <span class="badge bg-secondary">VS</span>
                                                                <small class="text-muted d-block mt-1">Programmé</small>
                                                            @endif
                                                        </div>

                                                        <!-- Joueur 2 -->
                                                        <div class="text-center flex-fill">
                                                            <h6 class="mb-1">{{ $match->joueur2->pseudo ?? 'BYE' }}</h6>
                                                            <small class="text-muted">{{ $match->joueur2->nom ?? '' }}</small>
                                                        </div>
                                                    </div>

                                                    <!-- Bouton saisie score -->
                                                    @if($match->joueur1 && $match->joueur2)
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-sm btn-primary w-100"
                                                                onclick="ouvrirModal({{ $match->id }}, '{{ $match->joueur1->pseudo }}', '{{ $match->joueur2->pseudo }}', {{ $numeroJournee }}, {{ $match->score_joueur1 ?? 0 }}, {{ $match->score_joueur2 ?? 0 }})">
                                                            <i class="fa fa-edit me-1"></i>{{ $match->statut == 'termine' ? 'Modifier le score' : 'Saisir le score' }}
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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

<!-- Modal Score -->
<div class="modal fade" id="scoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Saisir le score</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="scoreForm" method="POST">
                @csrf
                <input type="hidden" name="match_id" id="matchIdInput">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 id="matchInfo"></h6>
                    </div>
                    <div class="row">
                        <div class="col-5 text-center">
                            <label class="form-label" id="labelJ1"></label>
                            <input type="number" class="form-control text-center" name="score_joueur1" id="scoreJ1" value="0" min="0" required>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-center">
                            <span class="fs-4">-</span>
                        </div>
                        <div class="col-5 text-center">
                            <label class="form-label" id="labelJ2"></label>
                            <input type="number" class="form-control text-center" name="score_joueur2" id="scoreJ2" value="0" min="0" required>
                        </div>
                    </div>
                    <div class="mt-3 p-2 border rounded bg-light">
                        <small>🔧 Match ID: <span id="debugId" class="badge bg-primary">-</span></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Ouvrir modal
function ouvrirModal(matchId, joueur1, joueur2, journee, score1 = 0, score2 = 0) {
    document.getElementById('matchIdInput').value = matchId;
    document.getElementById('matchInfo').textContent = `${joueur1} vs ${joueur2} (Journée ${journee})`;
    document.getElementById('labelJ1').textContent = joueur1;
    document.getElementById('labelJ2').textContent = joueur2;
    document.getElementById('scoreJ1').value = score1;
    document.getElementById('scoreJ2').value = score2;
    document.getElementById('debugId').textContent = matchId;
    document.getElementById('modalTitle').textContent = score1 || score2 ? 'Modifier le score' : 'Saisir le score';
    new bootstrap.Modal(document.getElementById('scoreModal')).show();
}

// Soumission AJAX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('scoreForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-1"></i>Sauvegarde...';

        fetch("{{ route('admin.sauvegarder-score') }}", {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: new URLSearchParams(new FormData(form))
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) location.reload();
            else { alert(data.message || 'Erreur inconnue'); submitBtn.disabled = false; submitBtn.innerHTML = 'Sauvegarder'; }
        })
        .catch(err => { alert('Erreur de connexion'); submitBtn.disabled = false; submitBtn.innerHTML = 'Sauvegarder'; });
    });
});
</script>

<style>
.match-card:hover { transform: translateY(-2px); transition: transform 0.2s; cursor: pointer; }
.tab-content { margin-top: 1rem; }
</style>
@endsection
