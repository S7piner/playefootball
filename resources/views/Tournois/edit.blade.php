@extends('create')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Modifier un Tournoi</h1>

    <form action="{{ route('tournois.update', $tournois->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-medium">Nom du Tournoi</label>
            <input type="text" name="nom" class="w-full border p-2 rounded" value="{{ $tournois->nom }}" required>
        </div>

        <div>
            <label class="block font-medium">Image</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="4">{{ $tournois->description }}</textarea>
        </div>

        <div>
            <label class="block font-medium">Date</label>
            <input type="date" name="date" class="w-full border p-2 rounded" value="{{ $tournois->date }}" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier</button>
    </form>
</div>
@endsection

    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tournois.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block font-medium">Nom du Tournoi</label>
            <input type="text" name="nom" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Image</label>
            <input type="file" name="image" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="4"></textarea>
        </div>

        <div>
            <label class="block font-medium">Date</label>
            <input type="date" name="date" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    </form>
</div>
@endsection
