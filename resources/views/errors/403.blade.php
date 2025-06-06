@extends('layouts.error')

@section('content')
    <div style="padding: 2rem; text-align: center;">
        <h1>403 - Brak uprawnień</h1>
        <p>Nie masz dostępu do tej sekcji.</p>
        <a href="{{ url('/') }}">Powrót na stronę główną</a>
    </div>
@endsection
