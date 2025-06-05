<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => $listing->title])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Listing Details</h1>

                <div class="listing-details">
                    <div class="detail-group">
                        <h2>{{ $listing->title }}</h2>
                        <p class="listing-description">{{ $listing->description }}</p>
                    </div>

                    <div class="detail-group">
                        <h3>Information</h3>
                        <ul class="listing-info">
                            <li><strong>Price:</strong> {{ $listing->formatted_price }}</li>
                            <li><strong>Status:</strong> {{ ucfirst($listing->status) }}</li>
                            <li><strong>Category:</strong> {{ $listing->category ? $listing->category->name : '-' }}</li>
                            <li><strong>Owner:</strong> {{ $listing->user ? $listing->user->first_name . ' ' . $listing->user->last_name : '-' }}</li>
                            <li><strong>Created:</strong> {{ $listing->created_at->format('d.m.Y H:i') }}</li>
                        </ul>
                    </div>

                    <div class="detail-actions">
                        <a href="{{ route('admin.listings.edit', $listing->id) }}" class="btn-primary">Edit</a>
                        <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>
