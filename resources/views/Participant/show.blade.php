@extends('create')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Détails du Participant
                        </h5>
                        <a href="{{ route('envoyer.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($participant)
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Informations Personnelles</h6>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Nom :</th>
                                        <td>{{ $participant->nom ?? 'Non renseigné' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Prénom :</th>
                                        <td>{{ $participant->prenom ?? 'Non renseigné' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pseudo :</th>
                                        <td>
                                            <span class="badge bg-primary">{{ $participant->pseudo ?? 'Non renseigné' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email :</th>
                                        <td>{{ $participant->email ?? 'Non renseigné' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Téléphone :</th>
                                        <td>{{ $participant->telephone ?? 'Non renseigné' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pays :</th>
                                        <td>{{ $participant->pays ?? 'Non renseigné' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Statistiques</h6>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="card bg-primary text-white text-center">
                                            <div class="card-body py-3">
                                                <h4>{{ $capturesCount }}</h4>
                                                <small>Captures envoyées</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="card bg-success text-white text-center">
                                            <div class="card-body py-3">
                                                <h4>{{ $tournoisCount }}</h4>
                                                <small>Tournois participés</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="text-muted mt-4">Dernières captures</h6>
                                @if($dernieresCaptures->count() > 0)
                                    <div class="list-group">
                                        @foreach($dernieresCaptures as $capture)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong>{{ $capture->tournoi->nom ?? 'Tournoi inconnu' }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ $capture->created_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    </div>
                                                    @if($capture->image)
                                                        <img src="{{ asset('storage/' . $capture->image) }}"
                                                             alt="Capture"
                                                             style="width: 50px; height: 50px; object-fit: cover;"
                                                             class="rounded">
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Aucune capture trouvée</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Participant non trouvé
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
