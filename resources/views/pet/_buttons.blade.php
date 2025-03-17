<div class="row d-flex justify-content-end m-1">
    <div class="ml-1">
        <form action="{{route('pets.create')}}" method="get">
            <button class="btn btn-success btn-sm" type="submit">
                <i class="bi bi-plus-circle"></i>
            </button>
        </form>    
    </div>
    
    <div class="ml-1">
        <form action="{{route('pets.index')}}" method="post">
            @csrf
            <button class="btn btn-success btn-sm" type="submit" title="Wyniki wyszukiwania">
                <i class="bi bi-card-list"></i>
            </button>
        </form>
    </div>
</div>
