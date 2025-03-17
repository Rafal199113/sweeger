<div class="card">
    <div class="card-header bg-primary fw-bold">Wyszukiwarka</div>
    <div class="card-body">
        <form action="{{route('pets.index')}}" method="post">
            @csrf
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Status:</label>
                <select class="form-select rounded" name="filters[petFilter][status]">
                    @foreach($data['petStatusList'] as $statusEnglish => $statusPolish)
                        <option @if ($data['filters']['petFilter']['status'] == $statusEnglish)
                            selected
                        @endif value="{{$statusEnglish}}" >{{$statusPolish}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"  class="btn btn-warning btn-sm mt-3">Szukaj</button>
        </form>
    </div>
</div>
        
 

