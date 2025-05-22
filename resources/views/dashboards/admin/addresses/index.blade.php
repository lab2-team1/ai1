@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Address management</h1>
    <a href="{{ route('admin.addresses.create') }}" class="btn-primary">Add new user</a>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Zip code</th>
                    <th>Country</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($addresses as $address)
                    <tr>
                        <td>{{ $address->id }}</td>
                        <td>{{ $address->user ? $address->user->first_name . ' ' . $address->user->last_name : 'Brak użytkownika' }}</td>
                        <td>{{ $address->street }}</td>
                        <td>{{ $address->city }}</td>
                        <td>{{ $address->zip_code }}</td>
                        <td>{{ $address->country }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.addresses.edit', $address->id) }}" title="Edytuj"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.addresses.destroy', $address->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Usuń" onclick="return confirm('Na pewno usunąć ten adres?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-message">No addresses to display.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
