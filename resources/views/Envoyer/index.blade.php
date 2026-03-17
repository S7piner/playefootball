@extends('create')

@section('content')
<div class="container-fluid py-4">

    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3">
                    <i class="fas fa-images me-2"></i>Gestion des Captures
                </h1>
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Retour
                </a>
            </div>
            <p class="text-muted">Gérez toutes les captures d'écran envoyées pour les tournois</p>
        </div>
    </div>

    <!-- Alertes -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Cartes de statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">{{ $envoyers->count() }}</h4>
                        <p class="card-text">Total Captures</p>
                    </div>
                    <i class="fas fa-image fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">{{ $envoyers->unique('tournoi_id')->count() }}</h4>
                        <p class="card-text">Tournois Actifs</p>
                    </div>
                    <i class="fas fa-trophy fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">{{ $envoyers->unique('inscrit_id')->count() }}</h4>
                        <p class="card-text">Participants</p>
                    </div>
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">{{ $envoyers->where('created_at', '>=', now()->subDays(7))->count() }}</h4>
                        <p class="card-text">Cette semaine</p>
                    </div>
                    <i class="fas fa-calendar-week fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des captures -->
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Liste des Captures</h5>
            <span class="badge bg-light text-dark">{{ $envoyers->count() }} enregistrement(s)</span>
        </div>

        <div class="card-body p-0">
            @if($envoyers->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="80">#ID</th>
                                <th width="120">Image</th>
                                <th>Tournoi</th>
                                <th>Participant</th>
                                <th width="150">Date d'envoi</th>
                                <th width="150" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($envoyers as $envoyer)
                                <tr>
                                    <td class="fw-bold">#{{ $envoyer->id }}</td>
                                    <td>
                                        @if($envoyer->image)
                                            <img src="{{ asset('storage/' . $envoyer->image) }}"
                                                 alt="Capture {{ $envoyer->id }}"
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                 data-bs-toggle="modal"
                                                 data-bs-target="#imageModal{{ $envoyer->id }}"
                                                 role="button">
                                        @else
                                            <span class="badge bg-secondary">Aucune image</span>
                                        @endif
                                    </td>
                                    <td>{{ $envoyer->tournoi->nom ?? 'Tournoi inconnu' }}<br>
                                        <small class="text-muted">ID: {{ $envoyer->tournoi_id }}</small>
                                    </td>
                                    <td>{{ $envoyer->inscrit->pseudo ?? 'Participant inconnu' }}<br>
                                        <small class="text-muted">ID: {{ $envoyer->inscrit_id }}</small>
                                    </td>
                                    <td>
                                        {{ $envoyer->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
    <div class="btn-group" role="group">
        <!-- CORRECTION ICI : Redirection vers la page de gestion des participants du tournoi -->
        <form action="{{ route('inscrits.authorize-direct') }}" method="POST" class="d-inline">
    @csrf
    <input type="hidden" name="inscrit_id" value="{{ $envoyer->inscrit_id }}">
    <input type="hidden" name="tournoi_id" value="{{ $envoyer->tournoi_id }}">

    <!-- Debug visuel -->
    <small class="text-muted d-block">
        Inscrit: {{ $envoyer->inscrit_id }}, Tournoi: {{ $envoyer->tournoi_id }}
    </small>

    <button type="submit" class="btn btn-success mt-1">Participer</button>
</form>

        <button type="button"
                class="btn btn-sm btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#imageModal{{ $envoyer->id }}"
                title="Voir l'image">
            <i class="fas fa-eye"></i>
        </button>

        @if($envoyer->image)
            <a href="{{ asset('storage/' . $envoyer->image) }}"
               class="btn btn-sm btn-outline-success"
               download="capture_{{ $envoyer->id }}.jpg"
               title="Télécharger">
                <i class="fas fa-download"></i>
            </a>
        @endif
    </div>
</td>
                                </tr>

                                <!-- Modal pour l'image -->
                                <div class="modal fade" id="imageModal{{ $envoyer->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    Capture #{{ $envoyer->id }} - {{ $envoyer->tournoi->nom ?? 'Tournoi' }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                @if($envoyer->image)
                                                    <img src="{{ asset('storage/' . $envoyer->image) }}"
                                                         alt="Capture {{ $envoyer->id }}"
                                                         class="img-fluid rounded"
                                                         style="max-height: 70vh;">
                                                @else
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        Aucune image disponible
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <small class="text-muted me-auto">
                                                    Envoyé le {{ $envoyer->created_at->format('d/m/Y à H:i') }}
                                                    par {{ $envoyer->inscrit->pseudo ?? 'Participant inconnu' }}
                                                </small>
                                                @if($envoyer->image)
                                                    <a href="{{ asset('storage/' . $envoyer->image) }}"
                                                       class="btn btn-success"
                                                       download="capture_{{ $envoyer->id }}.jpg">
                                                        <i class="fas fa-download me-1"></i>Télécharger
                                                    </a>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Fermer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune capture trouvée</h4>
                    <p class="text-muted">Aucune capture d'écran n'a été envoyée pour le moment.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Voir les tournois
                    </a>
                </div>
            @endif
        </div>

        @if($envoyers->isNotEmpty())
            <div class="card-footer bg-light d-flex justify-content-between">
                <small class="text-muted">Dernière mise à jour : {{ now()->format('d/m/Y à H:i') }}</small>
                <small class="text-muted">Affichage de {{ $envoyers->count() }} capture(s)</small>
            </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    .btn-participer {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
    }
    .btn-participer:hover {
        background: linear-gradient(135deg, #218838, #1e9e8a);
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-fermeture des alertes après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            });
        }, 5000);
    });
</script>
@endpush
@endsection
