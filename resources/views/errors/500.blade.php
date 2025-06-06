@extends('layouts.error')

@section('content')
    <div style="padding: 2rem; text-align: center;">
        <h1>500 - Błąd serwera</h1>
        <p>Wystąpił nieoczekiwany błąd po stronie serwera. Spróbuj ponownie później.</p>
        <a href="{{ url('/') }}">Powrót na stronę główną</a>
    </div>
@endsection
