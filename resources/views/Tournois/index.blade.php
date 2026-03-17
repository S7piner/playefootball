@extends('create')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold">Tournois eFootball</h1>
        <a href="{{ route('tournois.create') }}" class="btn btn-primary btn-lg">Ajouter un Tournoi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($tournois as $tournoi)
            <div class="col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    @if($tournoi->image)
                        <img src="{{ asset('storage/'.$tournoi->image) }}" class="card-img-top" alt="{{ $tournoi->nom }}" style="height:200px; object-fit:cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $tournoi->nom }}</h5>
                        <p class="card-text text-muted mb-2">{{ Str::limit($tournoi->description, 100) }}</p>
                        <p class="text-secondary mb-2"><i class="bi bi-currency-dollar"></i> Caution: {{ $tournoi->caution }} FCFA</p>
                        <p class="text-secondary mb-3"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($tournoi->date)->format('d M Y') }}</p>
                        <a href="{{ route('tournois.show', $tournoi->id) }}" class="btn btn-outline-primary mt-auto">Voir Détails</a>
                         <form action="{{ route('tournois.destroy', $tournoi->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce tournoi ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
