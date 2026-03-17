@extends('create')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 mb-4">
                <div>
                    {{-- Bouton Lancer Phase Finale --}}
                    <a href="{{ route('admin.phase-finale', ['tournoi' => $tournoi->id]) }}" class="btn btn-warning me-2">
                        <i class="fa fa-sitemap me-2"></i>Phase Finale
                    </a>

                    {{-- Bouton Réinitialiser --}}
                    <button class="btn btn-danger" onclick="confirmReset()">
                        <i class="fa fa-trash me-2"></i>Réinitialiser
                    </button>

                    {{-- <a href="{{ route('admin.calendrier') }}" class="btn btn-success ms-2">
                        <i class="fa fa-calendar me-2"></i>Calendrier
                    </a>

                    <a href="{{ route('participant.index') }}" class="btn btn-light text-dark ms-2">
                        <i class="fa fa-arrow-left me-2"></i>Retour
                    </a> --}}
                </div>

                <div class="card-header bg-gradient-primary text-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-trophy me-2 text-warning"></i>Classement du Tournoi</h5>
                    <div>
                        {{-- <a href="{{ route('admin.calendrier') }}" class="btn btn-success me-2">
                            <i class="fa fa-calendar me-2"></i>Calendrier
                        </a>
                        <a href="{{ route('participant.index') }}" class="btn btn-light text-dark">
                            <i class="fa fa-arrow-left me-2"></i>Retour
                        </a> --}}
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if($classements->isEmpty())
                        <div class="text-center py-5">
                            <p class="text-muted mb-3">Aucun classement disponible.</p>
                            <a href="{{ route('participant.index') }}" class="btn btn-primary">
                                <i class="fa fa-sync me-2"></i>Générer les Journées
                            </a>
                        </div>
                    @else
                        @php
                            $maxPoints = $classements->max('points') ?? 0;
                            if ($maxPoints == 0) $maxPoints = 1;
                        @endphp

                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Position</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joueur</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">MJ</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">G</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">N</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">P</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">BP</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">BC</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Dif</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Points</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($classements as $index => $classement)
                                        @php
                                            $rank = $index + 1;
                                            $progress = $maxPoints > 0 ? ($classement->points / $maxPoints) * 100 : 0;
                                            $colors = [
                                                1 => 'linear-gradient(90deg, #ffd700, #ffcc33)', // or
                                                2 => 'linear-gradient(90deg, #c0c0c0, #e0e0e0)', // argent
                                                3 => 'linear-gradient(90deg, #cd7f32, #d88a3f)', // bronze
                                            ];
                                            // Calculer la différence si elle n'existe pas
                                            $dif = $classement->dif ?? ($classement->bp - $classement->bc);
                                        @endphp
                                        <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s;">
                                            <td class="align-middle text-center">
                                                @if($rank <= 3)
                                                    <span class="badge text-dark px-3 py-2" style="background: {{ $colors[$rank] }};">
                                                        🏆 {{ $rank }}{{ $rank == 1 ? 'er' : 'e' }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2">{{ $rank }}e</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 text-sm fw-bold text-dark">{{ $classement->inscrit->pseudo }}</h6>
                                                        <p class="text-xs text-muted mb-0">{{ $classement->inscrit->nom }} {{ $classement->inscrit->prenom }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-dark fw-bold">{{ $classement->mj }}</td>
                                            <td class="align-middle text-center text-success fw-bold">{{ $classement->g }}</td>
                                            <td class="align-middle text-center text-warning fw-bold">{{ $classement->n }}</td>
                                            <td class="align-middle text-center text-danger fw-bold">{{ $classement->p }}</td>
                                            <td class="align-middle text-center text-primary fw-bold">{{ $classement->bp }}</td>
                                            <td class="align-middle text-center text-danger fw-bold">{{ $classement->bc }}</td>
                                            <td class="align-middle text-center fw-bold {{ $dif > 0 ? 'text-success' : ($dif < 0 ? 'text-danger' : 'text-warning') }}">
                                                {{ $dif > 0 ? '+' : '' }}{{ $dif }}
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="position-relative w-100" style="min-width:100px;">
                                                    <div class="progress bg-light" style="height: 10px; border-radius: 10px;">
                                                        <div class="progress-bar bg-success"
                                                             role="progressbar"
                                                             style="width: {{ $progress }}%;"
                                                             aria-valuenow="{{ $classement->points }}" aria-valuemin="0" aria-valuemax="{{ $maxPoints }}">
                                                        </div>
                                                    </div>
                                                    <small class="fw-bold text-dark d-block mt-1">{{ $classement->points }} pts</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 px-3">
                            <h6 class="mb-3"><i class="fa fa-info-circle me-2 text-primary"></i>Système de points :</h6>
                            <ul class="list-unstyled text-sm text-muted">
                                <li>✅ Victoire : <strong>3 points</strong></li>
                                <li>⚖️ Match nul : <strong>1 point</strong></li>
                                <li>❌ Défaite : <strong>0 point</strong></li>
                                <li>🎯 Différence de buts : <strong>BP - BC</strong> (départage en cas d'égalité)</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmReset() {
        if (confirm("Voulez-vous vraiment réinitialiser tout le tournoi ?")) {
            window.location.href = "{{ route('tournois.reset') }}";
        }
    }
    </script>
</div>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.2s ease;
}
.avatar:hover {
    transform: scale(1.1);
}

.table tbody tr {
    transition: background-color 0.2s ease, transform 0.2s ease;
}
.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: scale(1.01);
}

.progress-bar {
    transition: width 0.8s ease;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.bg-gradient-primary {
    background: linear-gradient(90deg, #007bff, #00b894);
}
</style>
@endsection
