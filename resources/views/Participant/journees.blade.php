<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournoi - {{ $tournoi->nom }}</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('img/efo.jpg')}}">

    <style>
        body {
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .neon-glow {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .neon-purple {
            box-shadow: 0 0 25px rgba(168, 85, 247, 0.5);
        }

        .neon-blue {
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.5);
        }

        .gradient-text {
            background: linear-gradient(90deg, #00ff95, #00c9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-champions {
            background: linear-gradient(90deg, #0046ad, #d52b1e, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .nav-btn:hover::before {
            left: 100%;
        }

        .match-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .match-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #00ff95, #00c9ff);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .match-card:hover::before {
            transform: scaleX(1);
        }

        .champions-card {
            background: linear-gradient(135deg, rgba(0, 70, 173, 0.1), rgba(213, 43, 30, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .winner {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .loser {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .draw {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            box-shadow: 0 4px 15px rgba(156, 163, 175, 0.3);
        }

        .pending {
            background: linear-gradient(135deg, #374151, #4b5563);
            box-shadow: 0 4px 15px rgba(75, 85, 99, 0.3);
        }

        .dropdown-menu {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .champions-trophy {
            background: linear-gradient(135deg, #66ff00, #ffed4e);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.4);
        }

        /* Styles responsives améliorés */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column !important;
            }

            .mobile-center {
                text-align: center !important;
                justify-content: center !important;
            }

            .mobile-padding {
                padding: 1rem !important;
            }

            .mobile-text-sm {
                font-size: 0.875rem !important;
            }

            .mobile-text-lg {
                font-size: 1.125rem !important;
            }

            .mobile-grid {
                grid-template-columns: 1fr !important;
            }

            .mobile-space-y > * + * {
                margin-top: 1rem;
            }

            .mobile-compact {
                padding: 0.75rem !important;
            }

            .mobile-table {
                font-size: 0.75rem;
            }

            .mobile-table th,
            .mobile-table td {
                padding: 0.5rem 0.25rem;
            }

            .mobile-hidden {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .mobile-xs-text {
                font-size: 0.75rem !important;
            }

            .mobile-xs-padding {
                padding: 0.5rem !important;
            }
        }
    </style>
</head>
<body class="text-white">

<div class="max-w-7xl mx-auto py-4 md:py-8 px-3 sm:px-4 lg:px-8">

    <!-- Header avec animation -->
    <header class="text-center mb-6 md:mb-12 fade-in mobile-padding">
        <div class="inline-block">
            <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold gradient-champions mb-3 md:mb-4">
                🏆 {{ $tournoi->nom }}
            </h1>
            <div class="h-1 w-16 md:w-20 bg-gradient-to-r from-blue-600 via-red-500 to-white mx-auto rounded-full"></div>
        </div>
        <p class="text-gray-400 mt-3 md:mt-4 text-sm md:text-lg">Suivez le tournoi en direct</p>
    </header>

    <!-- Navigation améliorée pour mobile -->
    <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 md:space-x-6 mb-8 md:mb-12 relative mobile-padding">
        <!-- Bouton Journées avec dropdown -->
        <div class="relative w-full sm:w-auto">
            <button id="btn-journees" class="nav-btn w-full sm:w-auto px-4 md:px-8 py-3 rounded-xl font-bold text-base md:text-lg glass-card active-tab neon-glow flex items-center justify-center">
                <i class="fas fa-calendar-alt mr-2"></i>Journées
                <i class="fas fa-chevron-down ml-2 text-sm"></i>
            </button>

            <!-- Dropdown des journées -->
            <div id="journee-dropdown" class="absolute top-full left-0 right-0 sm:left-auto sm:right-auto mt-2 w-full sm:w-56 glass-card rounded-xl p-2 dropdown-menu z-10 hidden">
                @foreach($journees as $numero => $matches)
                    <button class="dropdown-item w-full text-left px-3 md:px-4 py-2 md:py-3 rounded-lg mb-1 last:mb-0 flex items-center justify-between mobile-text-sm"
                            onclick="showJournee({{ $numero }})">
                        <span class="flex items-center">
                            <i class="fas fa-calendar-day mr-2 md:mr-3 text-blue-400"></i>
                            Journée {{ $numero }}
                        </span>
                        <span class="text-green-400 text-xs md:text-sm bg-green-900 px-2 py-1 rounded">{{ count($matches) }} matchs</span>
                    </button>
                @endforeach
            </div>
        </div>

        <button id="btn-phase-finale" class="nav-btn w-full sm:w-auto px-4 md:px-8 py-3 rounded-xl font-bold text-base md:text-lg glass-card inactive-tab flex items-center justify-center">
            <i class="fas fa-flag-checkered mr-2"></i>Phase Finale
        </button>

        <button id="btn-classement" class="nav-btn w-full sm:w-auto px-4 md:px-8 py-3 rounded-xl font-bold text-base md:text-lg glass-card inactive-tab flex items-center justify-center">
            <i class="fas fa-trophy mr-2"></i>Classement
        </button>
    </div>

    <!-- Section Journées (contenu dynamique) -->
    <section id="section-journees" class="fade-in block">
        <div id="journee-content" class="glass-card rounded-2xl p-4 md:p-6 lg:p-8">
            <div class="text-center text-gray-500 py-8 md:py-12">
                <i class="fas fa-calendar-day text-4xl md:text-6xl mb-3 md:mb-4 opacity-50"></i>
                <h3 class="text-xl md:text-2xl font-bold mb-2">Sélectionnez une journée</h3>
                <p class="text-sm md:text-base">Choisissez une journée dans le menu déroulant pour voir les matchs</p>
            </div>
        </div>
    </section>

    <!-- Section Phase Finale - DESIGN CHAMPIONS LEAGUE -->
    <section id="section-phase-finale" class="hidden fade-in">
        <div class="champions-card rounded-2xl p-4 md:p-6 lg:p-8 neon-blue relative overflow-hidden">
            <!-- En-tête Phase Finale -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8 space-y-4 md:space-y-0 relative z-10">
                <div class="flex items-center justify-center md:justify-start space-x-3 md:space-x-4">
                    <div class="w-10 h-10 md:w-14 md:h-14 champions-trophy rounded-full flex items-center justify-center">
                        <i class="fas fa-trophy text-gray-900 text-lg md:text-xl"></i>
                    </div>
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl md:text-3xl font-bold gradient-champions">
                            Phase Finale
                        </h3>
                        <p class="text-gray-400 text-xs md:text-sm">UEFA Champions League Style</p>
                    </div>
                </div>
                <div class="text-blue-400 font-semibold bg-blue-900 px-3 md:px-4 py-1 md:py-2 rounded-full text-center">
                    Tableau Final
                </div>
            </div>

            @if(count($phaseFinale['quarts']) > 0 || count($phaseFinale['demis']) > 0 || count($phaseFinale['finale']) > 0)

            <!-- Arbre de la phase finale -->
            <div class="relative z-10">
                <!-- QUARTS DE FINALE -->
                @if(count($phaseFinale['quarts']) > 0)
                <div class="mb-8 md:mb-12">
                    <h4 class="text-xl md:text-2xl font-bold text-blue-400 mb-6 md:mb-8 flex items-center justify-center">
                        <i class="fas fa-chess-queen mr-2 md:mr-3"></i>
                        Quarts de Finale
                        <span class="ml-2 md:ml-3 text-xs md:text-sm bg-blue-900 px-2 md:px-3 py-1 rounded-full">{{ count($phaseFinale['quarts']) }} matchs</span>
                    </h4>

                    <div class="grid grid-cols-1 gap-4 md:gap-6">
                        @foreach($phaseFinale['quarts'] as $match)
                            @php
                                $scoreTotal1 = $match->score_total1 ?? 0;
                                $scoreTotal2 = $match->score_total2 ?? 0;

                                if ($scoreTotal1 > 0 || $scoreTotal2 > 0) {
                                    if ($scoreTotal1 > $scoreTotal2) {
                                        $colorA = "winner";
                                        $colorB = "loser";
                                    } elseif ($scoreTotal1 < $scoreTotal2) {
                                        $colorA = "loser";
                                        $colorB = "winner";
                                    } else {
                                        $colorA = $colorB = "draw";
                                    }
                                } else {
                                    $colorA = $colorB = "pending";
                                }
                            @endphp

                            <div class="match-card glass-card rounded-xl p-4 md:p-6 hover:neon-blue border-l-4 border-blue-500">
                                <div class="flex items-center justify-between mb-3 md:mb-4 mobile-stack mobile-space-y">
                                    <div class="text-center flex-1">
                                        <div class="font-bold text-white text-sm md:text-lg mb-1 md:mb-2 bg-blue-900 px-2 md:px-3 py-1 rounded mobile-text-sm">
                                            {{ $match->player1->pseudo ?? 'Joueur ' . $match->player1_id }}
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold {{ $colorA }} px-3 md:px-4 py-1 md:py-2 rounded-lg mobile-text-lg">
                                            {{ $scoreTotal1 ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="mx-2 md:mx-4">
                                        <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-red-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-xs md:text-sm">VS</span>
                                        </div>
                                    </div>

                                    <div class="text-center flex-1">
                                        <div class="font-bold text-white text-sm md:text-lg mb-1 md:mb-2 bg-red-900 px-2 md:px-3 py-1 rounded mobile-text-sm">
                                            {{ $match->player2->pseudo ?? 'Joueur ' . $match->player2_id }}
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold {{ $colorB }} px-3 md:px-4 py-1 md:py-2 rounded-lg mobile-text-lg">
                                            {{ $scoreTotal2 ?: '-' }}
                                        </div>
                                    </div>
                                </div>

                                @if($scoreTotal1 > 0 || $scoreTotal2 > 0)
                                    <div class="text-center mt-3 md:mt-4 text-xs md:text-sm text-gray-300 bg-gray-800 rounded p-2 mobile-text-sm">
                                        <div class="flex flex-col md:flex-row justify-center space-y-1 md:space-y-0 md:space-x-4">
                                            <span>Aller: <strong>{{ $match->score1_aller ?? '0' }} - {{ $match->score2_aller ?? '0' }}</strong></span>
                                            <span class="hidden md:inline">|</span>
                                            <span>Retour: <strong>{{ $match->score1_retour ?? '0' }} - {{ $match->score2_retour ?? '0' }}</strong></span>
                                        </div>
                                        <div class="text-base md:text-lg font-bold text-blue-300 mt-1 md:mt-2">
                                            Total: <span class="text-white">{{ $scoreTotal1 }} - {{ $scoreTotal2 }}</span>
                                        </div>
                                    </div>

                                    @if($match->winner_id)
                                        <div class="text-center mt-2 md:mt-3">
                                            <span class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-bold mobile-text-sm">
                                                🏆 Vainqueur: {{ $match->winner_id == $match->player1_id ? ($match->player1->pseudo ?? 'Joueur ' . $match->player1_id) : ($match->player2->pseudo ?? 'Joueur ' . $match->player2_id) }}
                                            </span>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center mt-3 md:mt-4 text-yellow-400 bg-yellow-900 rounded p-2 md:p-3 mobile-text-sm">
                                        <i class="fas fa-clock mr-1 md:mr-2"></i>
                                        <strong>Match à venir</strong>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- DEMI-FINALES -->
                @if(count($phaseFinale['demis']) > 0)
                <div class="mb-8 md:mb-12">
                    <h4 class="text-xl md:text-2xl font-bold text-purple-400 mb-6 md:mb-8 flex items-center justify-center">
                        <i class="fas fa-chess-knight mr-2 md:mr-3"></i>
                        Demi-Finales
                        <span class="ml-2 md:ml-3 text-xs md:text-sm bg-purple-900 px-2 md:px-3 py-1 rounded-full">{{ count($phaseFinale['demis']) }} matchs</span>
                    </h4>

                    <div class="grid grid-cols-1 gap-4 md:gap-6">
                        @foreach($phaseFinale['demis'] as $match)
                            @php
                                $scoreTotal1 = $match->score_total1 ?? 0;
                                $scoreTotal2 = $match->score_total2 ?? 0;

                                if ($scoreTotal1 > 0 || $scoreTotal2 > 0) {
                                    if ($scoreTotal1 > $scoreTotal2) {
                                        $colorA = "winner";
                                        $colorB = "loser";
                                    } elseif ($scoreTotal1 < $scoreTotal2) {
                                        $colorA = "loser";
                                        $colorB = "winner";
                                    } else {
                                        $colorA = $colorB = "draw";
                                    }
                                } else {
                                    $colorA = $colorB = "pending";
                                }
                            @endphp

                            <div class="match-card glass-card rounded-xl p-4 md:p-6 hover:neon-blue border-l-4 border-purple-500">
                                <div class="flex items-center justify-between mb-3 md:mb-4 mobile-stack mobile-space-y">
                                    <div class="text-center flex-1">
                                        <div class="font-bold text-white text-sm md:text-lg mb-1 md:mb-2 bg-purple-900 px-2 md:px-3 py-1 rounded mobile-text-sm">
                                            {{ $match->player1->pseudo ?? 'Joueur ' . $match->player1_id }}
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold {{ $colorA }} px-3 md:px-4 py-1 md:py-2 rounded-lg mobile-text-lg">
                                            {{ $scoreTotal1 ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="mx-2 md:mx-4">
                                        <div class="w-8 h-8 md:w-12 md:h-12 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center">
                                            <span class="text-white font-bold text-xs md:text-sm">VS</span>
                                        </div>
                                    </div>

                                    <div class="text-center flex-1">
                                        <div class="font-bold text-white text-sm md:text-lg mb-1 md:mb-2 bg-pink-900 px-2 md:px-3 py-1 rounded mobile-text-sm">
                                            {{ $match->player2->pseudo ?? 'Joueur ' . $match->player2_id }}
                                        </div>
                                        <div class="text-xl md:text-2xl font-bold {{ $colorB }} px-3 md:px-4 py-1 md:py-2 rounded-lg mobile-text-lg">
                                            {{ $scoreTotal2 ?: '-' }}
                                        </div>
                                    </div>
                                </div>

                                @if($scoreTotal1 > 0 || $scoreTotal2 > 0)
                                    <div class="text-center mt-3 md:mt-4 text-xs md:text-sm text-gray-300 bg-gray-800 rounded p-2 mobile-text-sm">
                                        <div class="flex flex-col md:flex-row justify-center space-y-1 md:space-y-0 md:space-x-4">
                                            <span>Aller: <strong>{{ $match->score1_aller ?? '0' }} - {{ $match->score2_aller ?? '0' }}</strong></span>
                                            <span class="hidden md:inline">|</span>
                                            <span>Retour: <strong>{{ $match->score1_retour ?? '0' }} - {{ $match->score2_retour ?? '0' }}</strong></span>
                                        </div>
                                        <div class="text-base md:text-lg font-bold text-purple-300 mt-1 md:mt-2">
                                            Total: <span class="text-white">{{ $scoreTotal1 }} - {{ $scoreTotal2 }}</span>
                                        </div>
                                    </div>

                                    @if($match->winner_id)
                                        <div class="text-center mt-2 md:mt-3">
                                            <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 md:px-4 py-1 md:py-2 rounded-full text-xs md:text-sm font-bold mobile-text-sm">
                                                🏆 Vainqueur: {{ $match->winner_id == $match->player1_id ? ($match->player1->pseudo ?? 'Joueur ' . $match->player1_id) : ($match->player2->pseudo ?? 'Joueur ' . $match->player2_id) }}
                                            </span>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center mt-3 md:mt-4 text-yellow-400 bg-yellow-900 rounded p-2 md:p-3 mobile-text-sm">
                                        <i class="fas fa-clock mr-1 md:mr-2"></i>
                                        <strong>Match à venir</strong>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- FINALE -->
                @if(count($phaseFinale['finale']) > 0)
                <div class="champions-trophy rounded-2xl p-4 md:p-6 lg:p-8 border-4 border-yellow-400 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 opacity-10"></div>

                    <div class="relative z-10">
                        <h4 class="text-2xl md:text-3xl font-bold text-yellow-400 mb-4 md:mb-6 flex items-center justify-center">
                            <i class="fas fa-crown mr-2 md:mr-3"></i>
                            Grande Finale
                            <span class="ml-2 md:ml-3 text-base md:text-lg bg-yellow-600 px-3 md:px-4 py-1 rounded-full text-white">🏆</span>
                        </h4>

                        @foreach($phaseFinale['finale'] as $match)
                            @php
                                $scoreTotal1 = $match->score_total1 ?? 0;
                                $scoreTotal2 = $match->score_total2 ?? 0;

                                if ($scoreTotal1 > 0 || $scoreTotal2 > 0) {
                                    if ($scoreTotal1 > $scoreTotal2) {
                                        $colorA = "winner";
                                        $colorB = "loser";
                                    } elseif ($scoreTotal1 < $scoreTotal2) {
                                        $colorA = "loser";
                                        $colorB = "winner";
                                    } else {
                                        $colorA = $colorB = "draw";
                                    }
                                } else {
                                    $colorA = $colorB = "pending";
                                }
                            @endphp

                            <div class="text-center">
                                <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-4 lg:space-x-8 mb-6 md:mb-8">
                                    <div class="text-center">
                                        <div class="font-bold text-white text-lg md:text-2xl mb-3 md:mb-4 bg-blue-900 px-4 md:px-6 py-2 md:py-3 rounded-xl mobile-text-lg">
                                            {{ $match->player1->pseudo ?? 'Finaliste 1' }}
                                        </div>
                                        <div class="text-2xl md:text-4xl font-bold {{ $colorA }} px-4 md:px-8 py-2 md:py-4 rounded-xl mobile-text-lg">
                                            {{ $scoreTotal1 ?: '-' }}
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 md:w-16 md:h-16 lg:w-20 lg:h-20 champions-trophy rounded-full flex items-center justify-center mb-2 md:mb-3">
                                            <span class="text-gray-900 font-bold text-base md:text-xl">VS</span>
                                        </div>
                                        <div class="text-sm md:text-xl font-bold text-yellow-400 bg-gray-900 px-3 md:px-4 py-1 md:py-2 rounded-full mobile-text-sm">
                                            🏆 FINALE 🏆
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <div class="font-bold text-white text-lg md:text-2xl mb-3 md:mb-4 bg-red-900 px-4 md:px-6 py-2 md:py-3 rounded-xl mobile-text-lg">
                                            {{ $match->player2->pseudo ?? 'Finaliste 2' }}
                                        </div>
                                        <div class="text-2xl md:text-4xl font-bold {{ $colorB }} px-4 md:px-8 py-2 md:py-4 rounded-xl mobile-text-lg">
                                            {{ $scoreTotal2 ?: '-' }}
                                        </div>
                                    </div>
                                </div>

                                @if($scoreTotal1 > 0 || $scoreTotal2 > 0)
                                    <div class="text-center mt-4 md:mt-6 text-sm md:text-lg text-gray-300 bg-gray-800 rounded-xl p-3 md:p-4 mb-4 md:mb-6 mobile-text-sm">
                                        <div class="flex flex-col md:flex-row justify-center space-y-2 md:space-y-0 md:space-x-4 lg:space-x-8 mb-2 md:mb-3">
                                            <span>Aller: <strong class="text-white">{{ $match->score1_aller ?? '0' }} - {{ $match->score2_aller ?? '0' }}</strong></span>
                                            <span class="hidden md:inline">|</span>
                                            <span>Retour: <strong class="text-white">{{ $match->score1_retour ?? '0' }} - {{ $match->score2_retour ?? '0' }}</strong></span>
                                        </div>
                                        <div class="text-lg md:text-2xl font-bold text-yellow-400">
                                            Score Final: <span class="text-white text-xl md:text-3xl">{{ $scoreTotal1 }} - {{ $scoreTotal2 }}</span>
                                        </div>
                                    </div>

                                    @if($match->winner_id)
                                        <div class="text-center mt-4 md:mt-6">
                                            <div class="inline-flex items-center champions-trophy text-gray-900 px-4 md:px-6 lg:px-8 py-2 md:py-3 lg:py-4 rounded-full font-bold text-base md:text-xl mobile-text-sm">
                                                <i class="fas fa-crown mr-2 text-lg md:text-2xl"></i>
                                                CHAMPION: {{ $match->winner_id == $match->player1_id ? ($match->player1->pseudo ?? 'Finaliste 1') : ($match->player2->pseudo ?? 'Finaliste 2') }}
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center mt-6 md:mt-8 text-yellow-400 bg-yellow-900 rounded-xl p-4 md:p-6 mobile-text-sm">
                                        <i class="fas fa-clock text-2xl md:text-4xl mb-2 md:mb-3"></i>
                                        <div class="text-lg md:text-2xl font-bold">Finale à venir</div>
                                        <p class="text-sm md:text-lg mt-1 md:mt-2">Le grand rendez-vous approche...</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
            @else
                <div class="text-center text-gray-500 py-8 md:py-16">
                    <i class="fas fa-flag-checkered text-4xl md:text-6xl lg:text-8xl mb-4 md:mb-6 opacity-50"></i>
                    <h3 class="text-xl md:text-3xl font-bold mb-3 md:mb-4 gradient-champions">Phase finale à venir</h3>
                    <p class="text-sm md:text-xl text-gray-400">La phase finale sera disponible après les matchs de poule</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Section Classement -->
    <section id="section-classement" class="hidden fade-in">
        <div class="glass-card rounded-2xl p-4 md:p-6 lg:p-8 neon-glow">
            <!-- En-tête classement -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8 space-y-4 md:space-y-0">
                <div class="flex items-center justify-center md:justify-start space-x-3 md:space-x-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-trophy text-gray-900 text-base md:text-lg"></i>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-white">Classement Général</h3>
                </div>
                <div class="text-green-400 font-semibold text-center md:text-left">
                    {{ count($classements) }} joueurs
                </div>
            </div>

            <!-- Tableau classement responsive -->
            <div class="overflow-x-auto">
                <table class="min-w-full mobile-table">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="py-3 md:py-4 px-2 md:px-4 text-left text-green-400 font-bold mobile-text-sm">#</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-left text-green-400 font-bold mobile-text-sm">Joueur</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-white-400 font-bold mobile-text-sm ">MJ</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-green-400 font-bold mobile-text-sm">G</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-yellow-400 font-bold mobile-text-sm ">N</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-red-400 font-bold mobile-text-sm">P</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-green-400 font-bold mobile-text-sm mobile-hidden">BP</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-green-400 font-bold mobile-text-sm mobile-hidden">BC</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-white-400 font-bold mobile-text-sm">Dif</th>
                            <th class="py-3 md:py-4 px-2 md:px-4 text-center text-green-400 font-bold mobile-text-sm">Pts</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classements as $index => $classement)
                            <tr class="table-row border-b border-gray-800 {{ 'rank-' . ($index + 1) }}">
                                <td class="py-3 md:py-4 px-2 md:px-4 font-bold">
                                    @if($index + 1 <= 3)
                                        <div class="w-6 h-6 md:w-8 md:h-8 rounded-full flex items-center justify-center text-xs md:text-sm
                                            @if($index + 1 == 1) bg-yellow-400 text-gray-900
                                            @elseif($index + 1 == 2) bg-gray-400 text-gray-900
                                            @else bg-orange-400 text-gray-900 @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    @else
                                        <span class="text-sm md:text-base">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td class="py-3 md:py-4 px-2 md:px-4 font-semibold">
                                    <div class="flex items-center space-x-2 md:space-x-3">
                                        <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-xs">
                                            {{ substr($classement->inscrit->pseudo ?? 'J', 0, 1) }}
                                        </div>
                                        <span class="text-sm md:text-base mobile-text-sm">{{ $classement->inscrit->pseudo ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center text-white-400 font-bold mobile-text-sm">{{ $classement->mj }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center text-green-400 font-bold mobile-text-sm">{{ $classement->g }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center text-yellow-400 font-bold mobile-text-sm ">{{ $classement->n }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center text-red-400 font-bold mobile-text-sm">{{ $classement->p }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center mobile-text-sm mobile-hidden">{{ $classement->bp }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center mobile-text-sm mobile-hidden">{{ $classement->bc }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center mobile-text-sm">{{ $classement->dif }}</td>
                                <td class="py-3 md:py-4 px-2 md:px-4 text-center">
                                    <span class="bg-gradient-to-r from-green-400 to-blue-400 text-gray-900 px-2 md:px-3 py-1 rounded-full font-bold text-xs md:text-sm mobile-text-sm">
                                        {{ $classement->points }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="py-6 md:py-8 text-center text-gray-500">
                                    <i class="fas fa-trophy text-2xl md:text-4xl mb-2 md:mb-3 opacity-50"></i>
                                    <p class="text-sm md:text-lg">Aucun classement disponible</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Bouton Retour -->
    <div class="text-center mt-8 md:mt-12 mobile-padding">
        <a href="{{ route('participant') }}"
           class="inline-flex items-center px-6 md:px-8 py-2 md:py-3 bg-gradient-to-r from-green-500 to-blue-500 text-gray-900 rounded-xl font-bold hover:from-green-400 hover:to-blue-400 transition-all duration-300 transform hover:scale-105 shadow-lg text-sm md:text-base">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour au dashboard
        </a>
    </div>

</div>

<script>
    // Données des journées
    const journeesData = {
        @foreach($journees as $numero => $matches)
            {{ $numero }}: {
                matches: [
                    @foreach($matches as $match)
                    {
                        joueur1: "{{ $match->joueur1->pseudo ?? '—' }}",
                        joueur2: "{{ $match->joueur2->pseudo ?? '—' }}",
                        score1: {{ $match->score_joueur1 ?? 'null' }},
                        score2: {{ $match->score_joueur2 ?? 'null' }},
                    },
                    @endforeach
                ]
            },
        @endforeach
    };

    // Éléments DOM
    const btnJournees = document.getElementById('btn-journees');
    const btnPhaseFinale = document.getElementById('btn-phase-finale');
    const btnClassement = document.getElementById('btn-classement');
    const sectionJournees = document.getElementById('section-journees');
    const sectionPhaseFinale = document.getElementById('section-phase-finale');
    const sectionClassement = document.getElementById('section-classement');
    const journeeDropdown = document.getElementById('journee-dropdown');
    const journeeContent = document.getElementById('journee-content');

    // Afficher une journée spécifique
    function showJournee(journeeNumber) {
        const data = journeesData[journeeNumber];
        let matchesHTML = '';

        data.matches.forEach(match => {
            const scoreA = match.score1;
            const scoreB = match.score2;

            let colorA = "pending", colorB = "pending";

            if (scoreA !== null && scoreB !== null) {
                if (scoreA > scoreB) {
                    colorA = "winner";
                    colorB = "loser";
                } else if (scoreA < scoreB) {
                    colorA = "loser";
                    colorB = "winner";
                } else {
                    colorA = colorB = "draw";
                }
            }

            matchesHTML += `
                <div class="match-card glass-card rounded-xl p-4 md:p-6 hover:neon-glow">
                    <div class="flex items-center justify-between mb-3 md:mb-4 mobile-stack mobile-space-y">
                        <div class="text-center flex-1">
                            <div class="font-semibold text-blue-300 text-xs md:text-sm mb-1">${match.joueur1}</div>
                            <div class="text-xs text-gray-400 mobile-hidden">Joueur 1</div>
                        </div>
                        <div class="mx-2 md:mx-4">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-gray-700 rounded-full flex items-center justify-center">
                                <span class="text-gray-300 font-bold text-xs md:text-sm">VS</span>
                            </div>
                        </div>
                        <div class="text-center flex-1">
                            <div class="font-semibold text-red-300 text-xs md:text-sm mb-1">${match.joueur2}</div>
                            <div class="text-xs text-gray-400 mobile-hidden">Joueur 2</div>
                        </div>
                    </div>
                    <div class="flex justify-center items-center space-x-3 md:space-x-4">
                        <span class="px-3 md:px-4 py-1 md:py-2 rounded-lg font-bold ${colorA} min-w-10 md:min-w-12 text-sm md:text-base">${scoreA !== null ? scoreA : '-'}</span>
                        <span class="text-gray-400 font-bold text-base md:text-lg">-</span>
                        <span class="px-3 md:px-4 py-1 md:py-2 rounded-lg font-bold ${colorB} min-w-10 md:min-w-12 text-sm md:text-base">${scoreB !== null ? scoreB : '-'}</span>
                    </div>
                    <div class="text-center mt-3 md:mt-4">
                        <span class="text-${scoreA !== null && scoreB !== null ? 'green' : 'yellow'}-400 text-xs md:text-sm font-semibold">
                            <i class="fas fa-${scoreA !== null && scoreB !== null ? 'check-circle' : 'clock'} mr-1"></i>
                            ${scoreA !== null && scoreB !== null ? 'Terminé' : 'À venir'}
                        </span>
                    </div>
                </div>
            `;
        });

        journeeContent.innerHTML = `
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8 space-y-4 md:space-y-0">
                <div class="flex items-center justify-center md:justify-start space-x-3 md:space-x-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                        <span class="font-bold text-gray-900 text-base md:text-lg">${journeeNumber}</span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-white">Journée ${journeeNumber}</h3>
                </div>
                <div class="text-green-400 font-semibold text-center md:text-left">${data.matches.length} matchs</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">${matchesHTML}</div>
        `;

        journeeDropdown.classList.add('hidden');
        switchToJournees();
    }

    // Navigation principale
    function switchToJournees() {
        sectionJournees.classList.remove('hidden');
        sectionPhaseFinale.classList.add('hidden');
        sectionClassement.classList.add('hidden');
        btnJournees.classList.remove('inactive-tab');
        btnJournees.classList.add('active-tab', 'neon-glow');
        btnPhaseFinale.classList.remove('active-tab', 'neon-blue');
        btnPhaseFinale.classList.add('inactive-tab');
        btnClassement.classList.remove('active-tab', 'neon-glow');
        btnClassement.classList.add('inactive-tab');
    }

    function switchToPhaseFinale() {
        sectionPhaseFinale.classList.remove('hidden');
        sectionJournees.classList.add('hidden');
        sectionClassement.classList.add('hidden');
        journeeDropdown.classList.add('hidden');
        btnPhaseFinale.classList.remove('inactive-tab');
        btnPhaseFinale.classList.add('active-tab', 'neon-blue');
        btnJournees.classList.remove('active-tab', 'neon-glow');
        btnJournees.classList.add('inactive-tab');
        btnClassement.classList.remove('active-tab', 'neon-glow');
        btnClassement.classList.add('inactive-tab');
    }

    function switchToClassement() {
        sectionClassement.classList.remove('hidden');
        sectionJournees.classList.add('hidden');
        sectionPhaseFinale.classList.add('hidden');
        journeeDropdown.classList.add('hidden');
        btnClassement.classList.remove('inactive-tab');
        btnClassement.classList.add('active-tab', 'neon-glow');
        btnJournees.classList.remove('active-tab', 'neon-glow');
        btnJournees.classList.add('inactive-tab');
        btnPhaseFinale.classList.remove('active-tab', 'neon-blue');
        btnPhaseFinale.classList.add('inactive-tab');
    }

    // Événements
    btnJournees.addEventListener('click', function(e) {
        e.stopPropagation();
        journeeDropdown.classList.toggle('hidden');
    });

    btnPhaseFinale.onclick = switchToPhaseFinale;
    btnClassement.onclick = switchToClassement;

    // Fermer le dropdown quand on clique ailleurs
    document.addEventListener('click', function() {
        journeeDropdown.classList.add('hidden');
    });

    // Empêcher la fermeture quand on clique dans le dropdown
    journeeDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.slide-in').forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>

</body>
</html>
