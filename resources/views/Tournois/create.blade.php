@extends('create')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Ajouter un Nouveau Tournoi</h2>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tournois.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom du Tournoi</label>
                            <input type="text" class="form-control form-control-lg" id="nom" name="nom" placeholder="Entrez le nom du tournoi" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image du Tournoi</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Entrez une description pour le tournoi"></textarea>
                        </div>

                        <!-- 💰 Caution -->
                        <div class="mb-3">
                            <label for="caution" class="form-label fw-semibold">Caution (en FCFA)</label>
                            <input type="number" class="form-control" id="caution" name="caution" placeholder="Ex: 1000" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date du Tournoi</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Ajouter le Tournoi</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('tournois.index') }}" class="text-decoration-none">&larr; Retour à la liste des tournois</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
