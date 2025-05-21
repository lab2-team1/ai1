@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Edytuj adres</h1>
    <form action="{{ route('admin.addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">Użytkownik:</label>
            <select id="user_id" name="user_id" class="form-control" required>
                <option value="">Wybierz użytkownika</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $address->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->first_name }} {{ $user->last_name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="street">Ulica:</label>
            <input type="text" id="street" name="street" class="form-control" value="{{ $address->street }}" required>
            @error('street')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="city">Miasto:</label>
            <input type="text" id="city" name="city" class="form-control" value="{{ $address->city }}" required>
            @error('city')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="zip_code">Kod pocztowy:</label>
            <input type="text" id="zip_code" name="zip_code" class="form-control"
                   value="{{ $address->zip_code }}" placeholder="00-000"
                   pattern="\d{2}-\d{3}"
                   title="Wprowadź kod pocztowy w formacie XX-XXX (np. 00-000)" required>
            @error('zip_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="country">Kraj:</label>
            <input type="text" id="country" name="country" class="form-control" value="{{ $address->country }}" required>
            @error('country')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Zaktualizuj adres</button>
    </form>
@endsection
