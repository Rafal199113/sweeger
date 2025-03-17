@extends('welcome')

@section('content')
    <div class="row d-flex justify-content-end m-1">
        <div class="ml-1">
            <form action="{{ route('pets.index') }}" method="get">
                <button class="btn btn-success btn-sm" type="submit" title="Wyniki wyszukiwania">
                    <i class="bi bi-card-list"></i>
                </button>
            </form>
        </div>
    </div>

<div class="card mb-3">
    <div class="card-header bg-primary fw-bold">
         Zwierze: {{$data['pet']->name}}
    </div>
    <div class="card-body">
    <form id="petForm" action="{{ route('pets.update', $data['pet']->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <label class="col-lg-2 col-md-2 col-form-label">Imie: <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="bottom" title="Pole wymagane">*</span></label>
            <input class="col-lg-3 col-md-6 control-form" name="name" value="{{ $data['pet']->name }}"> </input>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-md-2 col-form-label">Kategoria: <span data-bs-toggle="tooltip" class="text-danger" data-bs-placement="bottom" title="Pole wymagane">*</span></label>
            <input class="col-lg-3 col-md-6 control-form" name="category" value="{{ $data['pet']->category->name }}"> </input>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-md-2 col-form-label">Nowy tag: </label>
            <input class="col-lg-3 col-md-6 control-form" id="newTag" > </input>
            <button type="button" class="btn btn-secondary btn-sm ml-2" onclick="addTag()">
                <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-md-2 col-form-label">Tagi: </label>
            <ul id="tagList">
                @foreach ($data['pet']->tags as $index => $tag)
                    <li id="tag-{{$index}}">
                        {{ $tag->name }} 
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeTag({{ $index }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="row mb-3">
            <label class="col-lg-2 col-md-2 col-form-label">Status: </label>
            <select class="form-select rounded" name="filters[petFilter][status]">
                @foreach($data['pet']->statusList as $statusEnglish => $statusPolish)
                    <option @if ($data['pet']->getStatus() == $statusEnglish)
                        selected
                    @endif value="{{ $statusEnglish }}">{{ $statusPolish }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm mt-3">Zapisz</button>
    </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary fw-bold">
        Status 
    </div>
    <div class="card-body">
        Status: {{$data['pet']->getStatus()}}
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary fw-bold">
        Galeria 
    </div>
    <div class="card-body">
        <div class="col d-flex flex-column align-items-center"> 
            @foreach ($data['pet']->photoUrls as $index => $img )
                <div id="img-{{$index}}" class="col d-flex flex-column align-items-center"> 
                    <div  class="card mb-3">
                        <div  class="card-header bg-primary fw-bold">
                            <label class="form-label">Usuń zdjęcie: </label>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="removePhoto({{ $index }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <img class="m-3" src="{{$img}} "/>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    let tags = @json($data['pet']->tags); 
    let images = @json($data['pet']->photoUrls); 
    function removeTag(tagIndex) {
        tags.splice(tagIndex, 1);
        document.getElementById('tag-' + tagIndex).remove();
    }

    function removePhoto(tagIndex) {
        images.splice(tagIndex, 1);
        document.getElementById('img-' + tagIndex).remove();
    }

    function addTag() {
        let newTagInput = document.getElementById('newTag');
        let tagList = document.getElementById("tagList");

        let tagName = newTagInput.value.trim();
        if (tagName === "") {
            alert("Wpisz nazwę tagu!");
            return;
        }

        let index = Math.floor(Math.random() * 1000); 

        tags.push({ id: index, name: tagName });

        let newTag = document.createElement("li");
        newTag.style.margin = "5px";
        newTag.id = `tag-${index}`;
        newTag.innerHTML = `
            ${tagName} 
            <button type="button" class="btn btn-danger btn-sm" onclick="removeTag(${index})">
                <i class="bi bi-trash"></i>
            </button>
        `;

        tagList.appendChild(newTag);

        newTagInput.value = "";
    }

    document.getElementById('petForm').addEventListener('submit', function(event) {
        let tagsInput = document.createElement('input');
        tagsInput.type = 'hidden';
        tagsInput.name = 'tags'; 
        tagsInput.value = JSON.stringify(tags); 
        
        let imagesInput = document.createElement('input');
        imagesInput.type = 'hidden';
        imagesInput.name = 'images'; 
        imagesInput.value = JSON.stringify(images); 
        this.appendChild(tagsInput); 
        this.appendChild(imagesInput); 
    });
</script>
@endsection
