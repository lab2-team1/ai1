@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Zarządzanie kategoriami</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">Dodaj nową kategorię</a>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazwa</th>
                    <th>Kategoria nadrzędna</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent ? $category->parent->name : 'Brak' }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" title="Edytuj"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Usuń" onclick="return confirm('Na pewno usunąć tę kategorię?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-message">Brak kategorii do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
