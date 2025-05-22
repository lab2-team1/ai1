@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Add new adress</h1>
    <form action="{{ route('admin.addresses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User:</label>
            <select id="user_id" name="user_id" class="form-control" required>
                <option value="">Select user</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" class="form-control" required>
            @error('street')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" class="form-control" required>
            @error('city')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="zip_code">Zip code:</label>
            <input type="text" id="zip_code" name="zip_code" class="form-control"
                   placeholder="00-000" pattern="\d{2}-\d{3}"
                   title="Wprowadź kod pocztowy w formacie XX-XXX (np. 00-000)" required>
            @error('zip_code')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" class="form-control" required>
            @error('country')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Add address</button>
    </form>
@endsection
