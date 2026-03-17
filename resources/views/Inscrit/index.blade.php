@extends('create')

@section('content')
<style>
    /* --- Styles personnalisés pour rendre la liste plus élégante --- */
    .page-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .inscription-box {
        background: #2a2a2a;
        border-radius: 15px;
        padding: 20px;
        width: 100%;
        max-width: 1000px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        transition: all 0.3s ease;
    }

    .inscription-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
    }

    .inscription-box h3 {
        color: #fff;
        margin-bottom: 20px;
        font-weight: 600;
        letter-spacing: 1px;
        font-size: 1.5rem;
        text-align: center;
    }

    /* Styles pour le tableau responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table.table {
        border-collapse: collapse;
        width: 100%;
        min-width: 600px; /* Largeur minimale pour garder la lisibilité */
    }

    table.table thead {
        background: linear-gradient(90deg, #007bff, #6610f2);
    }

    table.table thead th {
        color: #fff !important;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 12px 8px;
        white-space: nowrap;
    }

    table.table tbody tr {
        background: #3a3a3a;
        color: #fff;
        transition: all 0.3s ease;
    }

    table.table tbody tr:hover {
        background: #444;
    }

    table.table tbody td {
        padding: 12px 8px;
        font-size: 0.85rem;
        border-bottom: 1px solid #555;
    }

    .btn-sm {
        border-radius: 8px;
        font-size: 0.75rem;
        padding: 6px 12px;
        margin: 2px;
    }

    .alert-success {
        background-color: #28a745 !important;
        color: #fff !important;
        border: none;
        font-weight: 500;
        border-radius: 8px;
        padding: 12px;
    }

    /* Styles spécifiques pour mobile */
    @media (max-width: 768px) {
        .page-wrapper {
            padding: 10px;
            align-items: flex-start;
        }

        .inscription-box {
            padding: 15px;
            border-radius: 12px;
        }

        .inscription-box h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        table.table thead th {
            font-size: 0.7rem;
            padding: 10px 6px;
        }

        table.table tbody td {
            padding: 10px 6px;
            font-size: 0.8rem;
        }

        .btn-sm {
            font-size: 0.7rem;
            padding: 5px 10px;
            margin: 1px;
        }

        /* Masquer certaines colonnes sur mobile très petit */
        @media (max-width: 480px) {
            .mobile-hidden {
                display: none;
            }

            table.table {
                min-width: 500px;
            }

            .btn-sm {
                display: block;
                width: 100%;
                margin-bottom: 5px;
            }

            .actions-column {
                min-width: 120px;
            }
        }

        /* Pour les très petits écrans */
        @media (max-width: 360px) {
            .inscription-box {
                padding: 10px;
            }

            table.table thead th,
            table.table tbody td {
                padding: 8px 4px;
                font-size: 0.75rem;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.65rem;
            }
        }
    }

    /* Amélioration de l'affichage des boutons d'action */
    .actions-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 120px;
    }

    /* Style pour le message vide */
    .empty-message {
        text-align: center;
        color: #fff;
        padding: 20px;
        font-style: italic;
    }

    /* Animation de chargement */
    @key fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .inscription-box {
        animation: fadeIn 0.5s ease-out;
    }
</style>

<div class="page-wrapper">
    <div class="inscription-box text-center">
        <h3>📋 Liste des inscriptions</h3>

        {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success text-start">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-start align-middle mb-0">
                <thead>
                    <tr class="text-center">
                        <th class="mobile-hidden">ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th class="mobile-hidden">Pseudo</th>
                        <th class="mobile-hidden">Pays</th>
                        <th class="mobile-hidden">Email</th>
                        <th class="mobile-hidden">Téléphone</th>
                        <th class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inscrit as $item)
                        <tr>
                            <td class="mobile-hidden">{{ $item->id }}</td>
                            <td>{{ $item->nom }}</td>
                            <td>{{ $item->prenom }}</td>
                            <td class="mobile-hidden">{{ $item->pseudo }}</td>
                            <td class="mobile-hidden">{{ $item->pays }}</td>
                            <td class="mobile-hidden">{{ $item->email }}</td>
                            <td class="mobile-hidden">{{ $item->telephone }}</td>
                            <td>
                                <div class="actions-container">
                                    {{-- Bouton Supprimer --}}
                                    <form action="{{ route('inscrit.destroy', $item->id) }}" method="POST" style="display:inline-block; width: 100%;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?')">
                                            🗑️ Supprimer
                                        </button>
                                    </form>

                                    {{-- Bouton Participer --}}
                                    @if(!$item->authorized)
                                        <form action="{{ route('inscrit.participer', $item->id) }}" method="POST" style="display:inline-block; width: 100%;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                ✅ Participer
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            🎯 Autorisé
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-message">Aucune inscription trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Indicateur de défilement horizontal pour mobile --}}
        <div class="mt-3 text-center d-md-none">
            <small class="text-muted">↔️ Défilez horizontalement pour voir plus de contenu</small>
        </div>

        {{-- Pagination (si activée) --}}
        @if(method_exists($inscrit, 'links'))
            <div class="mt-3 d-flex justify-content-center">
                {{ $inscrit->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    // Amélioration de l'expérience mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Ajout d'un indicateur visuel pour le défilement horizontal
        const tableContainer = document.querySelector('.table-responsive');

        if (tableContainer) {
            tableContainer.addEventListener('scroll', function() {
                this.style.boxShadow = 'inset 0 -2px 0 rgba(255,255,255,0.1)';
            });
        }

        // Confirmation améliorée pour la suppression
        const deleteButtons = document.querySelectorAll('form[action*="destroy"] button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('⚠️ Cette action est irréversible. Confirmez-vous la suppression ?')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
