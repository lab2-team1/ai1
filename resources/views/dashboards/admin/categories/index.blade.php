@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Manage Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add New Category</a>
    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-message">No categories to display.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
