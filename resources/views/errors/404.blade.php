@extends('welcome')

@section('content')
    <h1>404</h1>
    <h2>Nie udało sie pobrać elementu</h2>
    <a href="{{ $url }}">Sprubuj ponownie</a><br>
    <a href="{{ url('/') }}">Wróć do strony głównej</a>
</body>
</html>

@endsection