@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Zarządzanie adresami</h1>
    <a href="{{ route('admin.addresses.create') }}" class="btn-primary">Dodaj nowy adres</a>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Użytkownik</th>
                    <th>Ulica</th>
                    <th>Miasto</th>
                    <th>Kod pocztowy</th>
                    <th>Kraj</th>
                    <th>Akcje</th>
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
                        <td colspan="7" class="empty-message">Brak adresów do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
