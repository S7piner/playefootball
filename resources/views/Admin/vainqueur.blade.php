@extends('create')

@section('content')
<div class="container py-5 text-center">

    <h1 class="text-success mb-4">🏆 Vainqueur du Tournoi</h1>

    <img src="/images/trophee.png" width="200" class="mb-3">

    <h2 class="fw-bold">{{ $vainqueur->pseudo }}</h2>

    <p class="mt-3">Félicitations au champion !</p>

</div>
@endsection
