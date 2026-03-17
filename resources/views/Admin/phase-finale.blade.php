@extends('create')

@section('content')
<div class="container-fluid py-4">
    <!-- EN-TÊTE -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="text-warning fw-bold mb-2">🏆 CHAMPIONS LEAGUE</h1>
            <h3 class="text-white">TABLEAU FINAL</h3>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('admin.classement', ['tournoi' => $tournoi_id ?? 1]) }}" class="btn btn-outline-light">
                    <i class="fa fa-arrow-left me-2"></i>Retour
                </a>
                @if(isset($quarters) && $quarters->isEmpty() && $top8->count() >= 8)
                <form action="{{ route('phase-finale.generate', $tournoi_id ?? 1) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-play me-2"></i>Départ de la Phase Finale
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($top8->count() < 8)
        <div class="alert alert-warning text-center py-4">
            <i class="fa fa-users fa-2x mb-3"></i>
            <h5>Phase Finale Impossible</h5>
            <p class="mb-0">Il faut 8 joueurs classés pour lancer la phase finale.</p>
            <p>Actuellement: {{ $top8->count() }}/8 joueurs</p>
        </div>
    @else
        <!-- BOUTON LANCER PHASE FINALE -->
        @if(isset($quarters) && $quarters->isEmpty())
            <div class="text-center mb-5 p-4 bg-light rounded">
                <h5 class="text-success mb-3">✅ 8 joueurs qualifiés pour la phase finale !</h5>
                <form action="{{ route('phase-finale.generate', $tournoi_id ?? 1) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-play me-2"></i>Départ de la Phase Finale
                    </button>
                </form>
                <small class="text-muted d-block mt-2">Cliquez pour générer l'arbre des matchs</small>
            </div>
        @endif

        <!-- TABLEAU PRINCIPAL -->
        <div class="tournament-bracket">

            <!-- QUARTS DE FINALE -->
            <div class="bracket-column">
                <div class="bracket-header">
                    <h4 class="text-primary">RESULTAT DES QUARTS</h4>
                </div>

                @if(!isset($quarters) || $quarters->isEmpty())
                    <!-- AFFICHAGE DES QUALIFIÉS -->
                    @for ($i = 0; $i < 8; $i += 2)
                    <div class="matchup">
                        <div class="match-preview">
                            <div class="team team-left">
                                <span class="seed">#{{ $i+1 }}</span>
                                <span class="name">{{ $top8[$i]->inscrit->pseudo }}</span>
                            </div>
                            <div class="vs">VS</div>
                            <div class="team team-right">
                                <span class="name">{{ $top8[$i+1]->inscrit->pseudo }}</span>
                                <span class="seed">#{{ $i+2 }}</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                @else
                    <!-- MATCHS AVEC SCORES -->
                    @foreach($quarters as $match)
                    <div class="matchup">
                        <form action="{{ route('phase-finale.validate', $match->id) }}" method="POST" class="match-form">
                            @csrf
                            <div class="team team-left {{ $match->winner_id == $match->player1_id ? 'winner' : '' }}">
                                <span class="name">{{ $match->player1->pseudo }}</span>
                                <div class="score-inputs">
                                    <input type="number" name="score1_aller" class="score-input"
                                           value="{{ $match->score1_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score1_retour" class="score-input"
                                           value="{{ $match->score1_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                </div>
                            </div>

                            <div class="match-center">
                                <div class="vs">VS</div>
                                @if($match->winner_id)
                                <div class="total-score">
                                    {{ $match->score_total1 ?? 0 }} - {{ $match->score_total2 ?? 0 }}
                                </div>
                                @endif
                            </div>

                            <div class="team team-right {{ $match->winner_id == $match->player2_id ? 'winner' : '' }}">
                                <div class="score-inputs">
                                    <input type="number" name="score2_aller" class="score-input"
                                           value="{{ $match->score2_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score2_retour" class="score-input"
                                           value="{{ $match->score2_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                </div>
                                <span class="name">{{ $match->player2->pseudo }}</span>
                            </div>

                            @if(!$match->winner_id)
                            <button type="submit" class="btn-validate">
                                <i class="fa fa-check"></i> Valider
                            </button>
                            @else
                            <div class="winner-badge">
                                <i class="fa fa-trophy"></i>
                            </div>
                            @endif
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- DEMI-FINALES -->
            <div class="bracket-column">
                <div class="bracket-header">
                    <h4 class="text-success">DEMI-FINALES</h4>
                </div>

                @if(!isset($semis) || $semis->isEmpty())
                    <!-- PLACEHOLDER -->
                    @for ($i = 0; $i < 2; $i++)
                    <div class="matchup">
                        <div class="match-preview">
                            <div class="team team-left">
                                <span class="name placeholder">Vainqueur Q{{ ($i*2)+1 }}</span>
                            </div>
                            <div class="vs">VS</div>
                            <div class="team team-right">
                                <span class="name placeholder">Vainqueur Q{{ ($i*2)+2 }}</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                @else
                    <!-- MATCHS DEMI-FINALES -->
                    @foreach($semis as $match)
                    <div class="matchup">
                        <form action="{{ route('phase-finale.validate', $match->id) }}" method="POST" class="match-form">
                            @csrf
                            <div class="team team-left {{ $match->winner_id == $match->player1_id ? 'winner' : '' }}">
                                <span class="name">{{ $match->player1->pseudo }}</span>
                                <div class="score-inputs">
                                    <input type="number" name="score1_aller" class="score-input"
                                           value="{{ $match->score1_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score1_retour" class="score-input"
                                           value="{{ $match->score1_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                </div>
                            </div>

                            <div class="match-center">
                                <div class="vs">VS</div>
                                @if($match->winner_id)
                                <div class="total-score">
                                    {{ $match->score_total1 ?? 0 }} - {{ $match->score_total2 ?? 0 }}
                                </div>
                                @endif
                            </div>

                            <div class="team team-right {{ $match->winner_id == $match->player2_id ? 'winner' : '' }}">
                                <div class="score-inputs">
                                    <input type="number" name="score2_aller" class="score-input"
                                           value="{{ $match->score2_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score2_retour" class="score-input"
                                           value="{{ $match->score2_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $match->winner_id ? 'disabled' : 'required' }}>
                                </div>
                                <span class="name">{{ $match->player2->pseudo }}</span>
                            </div>

                            @if(!$match->winner_id)
                            <button type="submit" class="btn-validate">
                                <i class="fa fa-check"></i> Valider
                            </button>
                            @else
                            <div class="winner-badge">
                                <i class="fa fa-trophy"></i>
                            </div>
                            @endif
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- FINALE -->
            <div class="bracket-column">
                <div class="bracket-header">
                    <h4 class="text-warning">FINALE</h4>
                </div>

                @if(!isset($final) || !$final)
                    <!-- PLACEHOLDER FINALE -->
                    <div class="matchup final-match">
                        <div class="match-preview">
                            <div class="team team-left">
                                <span class="name placeholder">Vainqueur D1</span>
                            </div>
                            <div class="vs final-vs">🏆 FINALE 🏆</div>
                            <div class="team team-right">
                                <span class="name placeholder">Vainqueur D2</span>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- FINALE -->
                    <div class="matchup final-match">
                        <form action="{{ route('phase-finale.validate', $final->id) }}" method="POST" class="match-form">
                            @csrf
                            <div class="team team-left {{ $final->winner_id == $final->player1_id ? 'winner' : '' }}">
                                <span class="name">{{ $final->player1->pseudo }}</span>
                                <div class="score-inputs">
                                    <input type="number" name="score1_aller" class="score-input"
                                           value="{{ $final->score1_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $final->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score1_retour" class="score-input"
                                           value="{{ $final->score1_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $final->winner_id ? 'disabled' : 'required' }}>
                                </div>
                            </div>

                            <div class="match-center">
                                <div class="vs final-vs">🏆 FINALE 🏆</div>
                                @if($final->winner_id)
                                <div class="total-score final-total">
                                    {{ $final->score_total1 ?? 0 }} - {{ $final->score_total2 ?? 0 }}
                                </div>
                                @endif
                            </div>

                            <div class="team team-right {{ $final->winner_id == $final->player2_id ? 'winner' : '' }}">
                                <div class="score-inputs">
                                    <input type="number" name="score2_aller" class="score-input"
                                           value="{{ $final->score2_aller ?? '' }}"
                                           placeholder="A" min="0" {{ $final->winner_id ? 'disabled' : 'required' }}>
                                    <input type="number" name="score2_retour" class="score-input"
                                           value="{{ $final->score2_retour ?? '' }}"
                                           placeholder="R" min="0" {{ $final->winner_id ? 'disabled' : 'required' }}>
                                </div>
                                <span class="name">{{ $final->player2->pseudo }}</span>
                            </div>

                            @if(!$final->winner_id)
                            <button type="submit" class="btn-validate-final">
                                <i class="fa fa-trophy me-2"></i>Déclarer Champion
                            </button>
                            @else
                            <div class="champion-announcement">
                                <h4 class="text-gold">👑 CHAMPION 👑</h4>
                                <h5 class="text-white">{{ $final->winner->pseudo }}</h5>
                            </div>
                            @endif
                        </form>
                    </div>
                @endif

                <!-- TROPHEE -->
                <div class="trophy-container">
                    <div class="trophy">🏆</div>
                </div>
            </div>

        </div>
    @endif
</div>

<style>
/* FOND ET GÉNÉRAL */
body {
    background: linear-gradient(135deg, #0b1736 0%, #1a2b5f 50%, #0d1b3a 100%);
    min-height: 100vh;
    color: white;
}

.container-fluid {
    background: transparent;
}

/* TABLEAU PRINCIPAL */
.tournament-bracket {
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    gap: 30px;
    padding: 20px;
    min-height: 600px;
}

.bracket-column {
    flex: 1;
    max-width: 400px;
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.bracket-header {
    text-align: center;
    padding: 15px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    border: 2px solid;
    margin-bottom: 10px;
}

.bracket-header h4 {
    margin: 0;
    font-weight: bold;
}

.bracket-header .text-primary {
    border-color: #0d6efd;
}

.bracket-header .text-success {
    border-color: #198754;
}

.bracket-header .text-warning {
    border-color: #ffc107;
}

/* MATCHS */
.matchup {
    background: linear-gradient(135deg, rgba(13, 23, 54, 0.9), rgba(26, 43, 95, 0.9));
    border: 2px solid #1e90ff;
    border-radius: 12px;
    padding: 20px;
    position: relative;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}

.matchup:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.4);
}

.final-match {
    border-color: #ffd700;
    background: linear-gradient(135deg, rgba(214, 158, 46, 0.9), rgba(183, 121, 31, 0.9));
    transform: scale(1.05);
}

/* ÉQUIPES */
.team {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin: 8px 0;
    background: rgba(255,255,255,0.08);
    border-radius: 8px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.team.winner {
    background: rgba(72, 187, 120, 0.2);
    border-color: #48bb78;
}

.team-left {
    text-align: left;
}

.team-right {
    text-align: right;
    flex-direction: row-reverse;
}

.team-right .score-inputs {
    margin-left: 10px;
    margin-right: 0;
}

.name {
    font-weight: 600;
    font-size: 1rem;
    color: white;
    flex: 1;
}

.name.placeholder {
    opacity: 0.6;
    font-style: italic;
}

.seed {
    background: #e2b13c;
    color: #1a365d;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: bold;
    margin: 0 8px;
}

/* SCORES */
.score-inputs {
    display: flex;
    gap: 8px;
    margin: 0 10px;
}

.score-input {
    width: 45px;
    height: 35px;
    border: 2px solid #cbd5e0;
    border-radius: 6px;
    background: white;
    text-align: center;
    font-weight: bold;
    color: #2d3748;
}

.score-input:focus {
    border-color: #4299e1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
}

.score-input::placeholder {
    color: #a0aec0;
    font-size: 0.8rem;
}

/* CENTRE DU MATCH */
.match-center {
    text-align: center;
    margin: 10px 0;
}

.vs {
    color: #cbd5e0;
    font-weight: bold;
    font-size: 0.9rem;
    margin: 5px 0;
}

.final-vs {
    color: #ffd700;
    font-size: 1.1rem;
    font-weight: bold;
}

.total-score {
    background: rgba(72, 187, 120, 0.2);
    color: #48bb78;
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: bold;
    font-size: 0.9rem;
    margin-top: 5px;
    display: inline-block;
}

.final-total {
    background: rgba(255, 215, 0, 0.2);
    color: #ffd700;
    font-size: 1rem;
}

/* BOUTONS */
.btn-validate {
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    background: #4299e1;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    gap: 5px;
}

.btn-validate:hover {
    background: #3182ce;
    transform: translateX(-50%) scale(1.05);
}

.btn-validate-final {
    width: 100%;
    background: linear-gradient(135deg, #ecc94b, #d69e2e);
    color: #1a365d;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.btn-validate-final:hover {
    background: linear-gradient(135deg, #d69e2e, #b7791f);
    transform: translateY(-2px);
}

/* INDICATEURS DE VAINQUEUR */
.winner-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    background: #48bb78;
    color: white;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.champion-announcement {
    text-align: center;
    padding: 15px;
    background: rgba(255, 215, 0, 0.2);
    border-radius: 10px;
    border: 2px solid #ffd700;
    margin-top: 15px;
}

.text-gold {
    color: #ffd700;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

/* TROPHEE */
.trophy-container {
    text-align: center;
    margin-top: 30px;
}

.trophy {
    font-size: 100px;
    animation: bounce 2s infinite;
    filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.5));
}

@keyframes bounce {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-10px) scale(1.1); }
}

/* PREVIEW MATCH */
.match-preview {
    text-align: center;
    padding: 15px;
}

/* BOUTON DÉPART */
.bg-light {
    background: rgba(255,255,255,0.9) !important;
    border-radius: 15px;
}

/* RESPONSIVE */
@media (max-width: 1200px) {
    .tournament-bracket {
        flex-direction: column;
        align-items: center;
        gap: 40px;
    }

    .bracket-column {
        width: 100%;
        max-width: 500px;
    }

    .final-match {
        transform: scale(1);
    }
}

@media (max-width: 768px) {
    .team {
        flex-direction: column;
        text-align: center;
        gap: 8px;
    }

    .team-right {
        flex-direction: column;
    }

    .score-inputs {
        margin: 5px 0;
        justify-content: center;
    }

    .name {
        order: -1;
    }

    .tournament-bracket {
        padding: 10px;
    }

    .bracket-column {
        gap: 25px;
    }
}

/* ALERTES */
.alert {
    border-radius: 10px;
    border: none;
}

.alert-success {
    background: rgba(72, 187, 120, 0.9);
    color: white;
}

.alert-danger {
    background: rgba(245, 101, 101, 0.9);
    color: white;
}

.alert-warning {
    background: rgba(237, 137, 54, 0.9);
    color: white;
}
</style>
@endsection
