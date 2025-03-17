@extends('welcome')

@section('content')
    <div class="row d-flex justify-content-end m-1">
        <div class="ml-1">
            <form action="{{ route('pets.create') }}" method="get">
                <button class="btn btn-success btn-sm" type="submit">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </form>    
        </div>

        <div class="ml-1">
            <form action="{{ route('pets.index') }}" method="get">
                <button class="btn btn-success btn-sm" type="submit" title="Wyniki wyszukiwania">
                    <i class="bi bi-card-list"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Dodaj zwierzę
        </div>
        <div class="card-body">
            <form action="{{ route('pets.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Imię <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="bottom" title="Pole wymagane">*</span>:</label>
                    <input type="text" name="pet_name" class="form-control">
                    <div class="form-text">Podaj imię swojego zwierzaka.</div>
                    @if ($errors->has("pet_name"))
                        @foreach ($errors->get("pet_name") as $error)
                            <p class="text-danger"> {{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Gatunek zwierzaka <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="bottom" title="Pole wymagane">*</span>:</label>
                    <input type="text" name="pet_breed" class="form-control">
                    <div class="form-text">Podaj gatunek swojego zwierzaka.</div>
                    @if ($errors->has("pet_breed"))
                        @foreach ($errors->get("pet_breed") as $error)
                            <p class="text-danger"> {{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Tag <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="bottom" title="Pole wymagane">*</span>:</label>
                    <input type="text" name="pet_tag" class="form-control">
                    <div class="form-text">Dodaj tag.</div>
                    @if ($errors->has("pet_tag"))
                        @foreach ($errors->get("pet_tag") as $error)
                            <p class="text-danger"> {{ $error }}</p>
                        @endforeach
                    @endif
                </div>
                <div class="mb-3">
                    <label for="photoUrls" class="form-label">Linki do zdjęć</label>
                    <div id="photo_links">
                        <input type="text" class="form-control mb-2" name="photo_links[]">
                    </div>
                    <button type="button" class="btn btn-secondary" id="addUrl">Dodaj kolejne zdjęcie</button>
                </div>
                <button type="submit" class="btn btn-primary">Wyślij</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.getElementById('addUrl').addEventListener('click', function() {
        var container = document.getElementById('photo_links');
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control mb-2';
        input.name = 'photo_links[]';

        container.appendChild(input);
    });
</script>
@endsection
