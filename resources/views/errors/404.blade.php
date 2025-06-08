@extends('layouts.error')

@section('content')
    <div style="padding: 2rem; text-align: center;">
        <h1>404 - Nie znaleziono strony</h1>
        <p>Strona, której szukasz, nie istnieje lub została przeniesiona.</p>
        <a href="{{ url('/') }}">Powrót na stronę główną</a>
    </div>
@endsection
