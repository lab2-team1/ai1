<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Listings'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Listings</h1>

                <a href="{{ route('admin.listings.create') }}" class="btn-primary">Add New Listing</a>

                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listings as $listing)
                                <tr>
                                    <td>{{ $listing->id }}</td>
                                    <td>
                                        @if($listing->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $listing->images->first()->image_url) }}" alt="{{ $listing->title }}" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div style="width: 50px; height: 50px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #666;">No image</div>
                                        @endif
                                    </td>
                                    <td>{{ $listing->title }}</td>
                                    <td>{{ $listing->category ? $listing->category->name : '-' }}</td>
                                    <td>{{ $listing->formatted_price }}</td>
                                    <td class="admin-actions">
                                        <a href="{{ route('listings.show', $listing->id) }}" title="View"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.listings.edit', $listing->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this listing?')" style="background: none; border: none; padding: 0; color: #dc3545; cursor: pointer;"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-message">No listings found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>
