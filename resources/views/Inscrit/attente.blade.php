@extends('create')

@section('content')
<div class="container-fluid py-4">

    <!-- En-tête avec nom du tournoi -->
    @if(isset($tournoi) && $tournoi)
    <div class="alert alert-info">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">🏆 Tournoi : {{ $tournoi->nom }}</h5>
                <p class="mb-0">Participants autorisés pour ce tournoi</p>
            </div>
            <span class="badge bg-primary">ID: {{ $tournoi->id }}</span>
        </div>
    </div>
    @endif

    {{-- Dans inscrit/attente.blade.php --}}
<div class="alert alert-info">
    <strong>DEBUG:</strong><br>
    Tournoi ID: {{ $tournoi->id }}<br>
    Participants trouvés: {{ $inscrits->count() }}<br>
    @foreach($inscrits as $inscrit)
        - {{ $inscrit->pseudo }} (tournoi_id: {{ $inscrit->tournoi_id }})<br>
    @endforeach
</div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>📋 Liste des participants autorisés</h6>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#envoyerModal">
                            <i class="fa fa-paper-plane me-2"></i>Envoyer les classements
                        </button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mx-4 mt-4">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <div class="card-body px-0 pt-0 pb-2">
                    @if($inscrits->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun participant autorisé pour ce tournoi.</p>
                        </div>
                    @else
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prénom</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pseudo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Téléphone</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pays</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscrits as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <h6 class="mb-0 text-sm">#{{ $item->id }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nom }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->prenom }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <span class="badge bg-primary">{{ $item->pseudo }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <i class="fas fa-envelope me-1 text-muted"></i>
                                                {{ $item->email }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                <i class="fas fa-phone me-1 text-muted"></i>
                                                {{ $item->telephone }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-secondary">
                                                <i class="fas fa-flag me-1"></i>{{ $item->pays }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section Génération des Journées -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">📅 Génération des Journées de Tournoi</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card bg-gradient-primary text-white p-4 rounded">
                                <h6 class="text-white">📊 Statistiques du Tournoi</h6>
                                <div class="mt-3">
                                    <p class="mb-1">Nombre de participants: <strong>{{ $inscrits->count() }}</strong></p>
                                    <p class="mb-1">Nombre de journées estimé: <strong>{{ ceil($inscrits->count() / 2) }}</strong></p>
                                    <p class="mb-1">Matchs par journée: <strong>{{ floor($inscrits->count() / 2) }}</strong></p>
                                    <p class="mb-0">Total de matchs: <strong>{{ $inscrits->count() * ($inscrits->count() - 1) / 2 }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center">
                            <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#genererJourneesModal">
                                <i class="fa fa-calendar-alt me-2"></i>Générer les Journées
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour envoyer -->
<div class="modal fade" id="envoyerModal" tabindex="-1" aria-labelledby="envoyerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="envoyerModalLabel">Envoyer les classements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="envoyerForm" action="{{ route('classement.envoyer') }}" method="POST">
                    @csrf
                    <label class="form-label">Message (optionnel)</label>
                    <textarea class="form-control" name="message" rows="3"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button class="btn btn-primary" form="envoyerForm">Envoyer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour générer les journées -->
<div class="modal fade" id="genererJourneesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Générer les Journées</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tournois.generer-journees') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        Sélectionnez un tournoi pour générer son calendrier.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Tournoi *</label>
                            <select class="form-control" name="tournoi_id" required id="tournoiSelect">
                                <option value="">Sélectionnez un tournoi</option>
                                @foreach($tournois as $tournoi)
                                    <option value="{{ $tournoi->id }}" {{ isset($tournoi) && $tournoi->id == $tournoi->id ? 'selected' : '' }}>
                                        {{ $tournoi->nom }} ({{ $tournoi->date }})
                                    </option>
                                @endforeach
                            </select>
                            @if($tournois->isEmpty())
                                <small class="text-warning">Aucun tournoi créé. <a href="{{ route('tournois.create') }}">Créez-en un d'abord</a></small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date de début *</label>
                            <input type="date" class="form-control" name="date_debut" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <!-- Ajoutez ce champ caché pour garder le type championnat -->
                    <input type="hidden" name="type_tournoi" value="championnat">

                    <div class="preview-journees mt-4">
                        <h6>Prévisualisation</h6>
                        <div id="previewContent">
                            <p class="text-muted">Sélectionnez un tournoi pour voir la prévisualisation</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success" id="generateButton" {{ $tournois->isEmpty() ? 'disabled' : '' }}>Générer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tournoiSelect = document.getElementById('tournoiSelect');
    const previewContent = document.getElementById('previewContent');
    const generateButton = document.getElementById('generateButton');

    if (tournoiSelect) {
        tournoiSelect.addEventListener('change', function() {
            const tournoiId = this.value;

            if (tournoiId) {
                // Récupère les informations du tournoi sélectionné
                const selectedOption = this.options[this.selectedIndex];
                const tournoiName = selectedOption.text;

                // Simulation de prévisualisation avec les vraies données
                const participantsCount = {{ $inscrits->count() }};
                const nbJournees = Math.ceil(participantsCount / 2);
                const totalMatchs = participantsCount * (participantsCount - 1) / 2;

                previewContent.innerHTML = `
                    <div class="alert alert-success">
                        <strong>${tournoiName}</strong><br>
                        Participants: ${participantsCount}<br>
                        Nombre de journées: ${nbJournees}<br>
                        Total de matchs: ${totalMatchs}
                    </div>
                `;
                generateButton.disabled = false;
            } else {
                previewContent.innerHTML = '<p class="text-muted">Sélectionnez un tournoi pour voir la prévisualisation</p>';
                generateButton.disabled = true;
            }
        });
    }
});
</script>

<style>
.info-card {
    background: linear-gradient(45deg, #5e72e4, #825ee4);
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
