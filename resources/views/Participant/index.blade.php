<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants Autorisés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    {{-- @include('Dashboard.partials.siderbar') --}}

    <div class="content">
        <div class="container-fluid">
            <h1 class="mt-4">Participants Autorisés aux Tournois</h1>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Liste des participants autorisés</h5>
                </div>
                <div class="card-body">
                    @if($participants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Pseudo</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Pays</th>
                                        <th>Date d'inscription</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                        <tr>
                                            <td>{{ $participant->id }}</td>
                                            <td>{{ $participant->nom }}</td>
                                            <td>{{ $participant->prenom }}</td>
                                            <td>{{ $participant->pseudo }}</td>
                                            <td>{{ $participant->email }}</td>
                                            <td>{{ $participant->telephone }}</td>
                                            <td>{{ $participant->pays }}</td>
                                            <td>{{ $participant->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucun participant autorisé pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
