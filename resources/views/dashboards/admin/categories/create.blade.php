@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Create New Category</h1>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent Category:</label>
            <select id="parent_id" name="parent_id" class="form-control">
                <option value="">None</option>
                @foreach ($categories as $parentCategory)
                    <option value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
@endsection
