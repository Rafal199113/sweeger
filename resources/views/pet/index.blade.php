@extends('welcome')

@section('content')
<div class="container">
    @include('pet._buttons')
    @include('pet._search')

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="card card-table mt-3">
        <div class="card-header">
            Zwierzaki
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="white-space: nowrap; width: 1%" class="align-middle"></th>
                            <th style="white-space: nowrap; width: 1%" class="align-middle">Id</th>
                            <th>Status</th>
                            <th>Imie</th>
                            <th style="white-space: nowrap; width: 1%" class="align-middle"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pets'] as $pet)
                        <tr class="align-middle">
                            <td class="text-center">
                                <form action="{{ route('pets.show', $pet->id) }}" method="GET" style="display:inline;">
                                    @csrf
                                    @method('GET')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil-square "></i>
                                    </button>
                                </form>
                            </td>
                            <td>{{$pet->id}}</td>
                            <td>{{$pet->getStatus()}}</td>
                            <td>
                                @if (!empty($pet->name))
                                    {{$pet->name}}
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Czy na pewno chcesz usunąć?');">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
