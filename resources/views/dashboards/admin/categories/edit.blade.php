@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Edit Category</h1>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent Category:</label>
            <select id="parent_id" name="parent_id" class="form-control">
                <option value="">None</option>
                @foreach ($categories as $parentCategory)
                    <option value="{{ $parentCategory->id }}" {{ $category->parent_id == $parentCategory->id ? 'selected' : '' }}>
                        {{ $parentCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
@endsection

@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Manage Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add New Category</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
