@extends('dashboards.admindashboard')

@section('admin-content')
    <h1>Manage users</h1>
    
    <div class="admin-actions-container">
        <a href="{{ route('admin.users.create') }}" class="btn-primary">Add new user</a>
        
        <form action="{{ route('admin.users.index') }}" method="GET" class="search-form">
            <div class="search-input-group">
                <input type="text" name="search" class="search-input" placeholder="Search by name or email..." value="{{ request('search') }}">
                <button type="submit" class="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Registration date</th>
                    <th>Last update</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($user->admin)
                                <i class="fa fa-check-circle" style="color: #28a745;" title="Yes"></i>
                            @else
                                <i class="fa fa-times-circle" style="color: #dc3545;" title="No"></i>
                            @endif
                        </td>
                        <td class="admin-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-message">No users to display.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $users->appends(request()->query())->links() }}
    </div>
@endsection
