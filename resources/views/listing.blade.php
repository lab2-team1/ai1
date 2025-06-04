<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('shared.head', ['pageTitle' => $listing->title])

<body>
    @include('shared.navigation')

    <main class="main-content">
        <div class="container">
            <div class="listing-details">
                <!-- Image Gallery Section -->
                <div class="listing-gallery">
                    @if ($listing->images->isNotEmpty())
                        <div class="image-slideshow" data-listing-id="{{ $listing->id }}">
                            @foreach ($listing->images->sortBy('order') as $image)
                                <div class="slide {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $listing->title }}"
                                        class="listing-img" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                        <div class="image-thumbnails">
                            @foreach ($listing->images->sortBy('order') as $image)
                                <div class="thumbnail {{ $loop->first ? 'active' : '' }}"
                                    data-slide-index="{{ $loop->index }}">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="Thumbnail"
                                        loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-image">No Images Available</div>
                    @endif
                </div>

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
                        <li>
                            <strong>Owner:</strong>
                            @if ($listing->user)
                                <a href="{{ route('users.show', $listing->user->id) }}" class="btn btn-link"
                                    style="padding:0; font-weight:600;">
                                    {{ $listing->user->first_name }} {{ $listing->user->last_name }}
                                </a>
                            @else
                                -
                            @endif
                        </li>
                        <li><strong>Date Added:</strong> {{ $listing->created_at->format('d.m.Y H:i') }}</li>
                    </ul>
                </div>

                @auth
                    @if (auth()->user()->id === $listing->user_id)
                        <div class="detail-actions">
                            <a href="{{ route('admin.listings.edit', $listing->id) }}" class="btn-primary">Edit</a>
                            <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                            </form>
                        </div>
                    @elseif(auth()->user()->id !== $listing->user_id && $listing->isActive())
                        <form action="{{ route('listings.buy', $listing->id) }}" method="POST" style="margin-top: 20px;">
                            @csrf
                            <button type="submit" class="btn-primary">Buy Now</button>
                        </form>
                    @endif
                @else
                    @if ($listing->isActive())
                        <a href="{{ route('login') }}" class="btn-primary"
                            style="margin-top: 20px; display: inline-block;">Buy Now</a>
                    @endif
                @endauth
            </div>
        </div>
    </main>

    @include('shared.footer')
</body>

</html>
