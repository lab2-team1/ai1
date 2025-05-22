@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Edit User</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}" required>
            @error('first_name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}" required>
            @error('last_name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone">Phone number:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <div class="checkbox-wrapper">
                <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->admin) ? 'checked' : '' }}>
                <label for="is_admin">Is Admin</label>
            </div>
            @error('is_admin')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
@endsection 