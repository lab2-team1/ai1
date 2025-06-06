@extends('layouts.error')

@section('content')
    <div style="padding: 2rem; text-align: center;">
        <h1>419 - Sesja wygasła</h1>
        <p>Twoja sesja wygasła. Odśwież stronę i spróbuj ponownie.</p>
        <a href="{{ url()->previous() }}">Wróć</a> |
        <a href="{{ url('/') }}">Strona główna</a>
    </div>
@endsection
