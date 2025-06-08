<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'MarketPlace - Buy and Sell with Ease'])
    <body>
        <!-- Navigation -->
        @include('shared.navigation')

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <!-- Search Bar -->
                <div class="search-container">
                    <form action="{{ route('search') }}" method="GET" class="search-form">
                        <div class="search-input-group">
                            <input type="text" name="query" class="search-input" placeholder="Search for anything..." value="{{ request('query') }}" id="search-input">
                            <div id="search-suggestions" class="search-suggestions"></div>
                            <button type="submit" class="search-button">Search</button>
                        </div>
                    </form>
                </div>

                <div class="filters-container">
                    <form action="{{ route('home') }}" method="GET" class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Category</label>
                            <select name="category" class="filter-input">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Location</label>
                            <input type="text" name="location" class="filter-input" placeholder="Enter location" value="{{ request('location') }}">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Price Range</label>
                            <div class="price-range-container">
                                <input type="number" name="min_price" class="price-range-input" placeholder="Min" value="{{ request('min_price') }}">
                                <span class="price-range-separator">to</span>
                                <input type="number" name="max_price" class="price-range-input" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Sort by</label>
                            <select name="sort" class="filter-input" id="sort-select">
                                <option value="">Select sorting</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Newest First</option>
                                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Oldest First</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title: A to Z</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title: Z to A</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button type="submit" class="filter-button">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>

                <section class="latest-listings">
                    <h2>Newest listings</h2>
                    <div class="listings-grid">
                        @foreach($listings as $listing)
                            <div class="listing-card @if($listing->promotion_expires_at && $listing->promotion_expires_at->isFuture()) promoted-listing @endif">
                                <div class="listing-image">
                                    @if($listing->images->isNotEmpty())
                                        <div class="image-slideshow" data-listing-id="{{ $listing->id }}">
                                            @foreach($listing->images->sortBy('order') as $image)
                                                <div class="slide {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $listing->title }}" class="listing-img" loading="lazy">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="no-image">No Image Available</div>
                                    @endif
                                </div>
                                <div class="listing-content">
                                    @if($listing->promotion_expires_at && $listing->promotion_expires_at->isFuture())
                                        <span class="promotion-badge">Promoted listing!</span>
                                    @endif
                                    <h3 class="listing-title">{{ $listing->title }}</h3>
                                    <p class="listing-description">{{ Str::limit($listing->description, 100) }}</p>
                                    <span class="listing-category">{{ $listing->category->name }}</span>
                                    <a href="{{ route('listings.show', $listing) }}" class="btn btn-secondary">Show details</a>
                                    <div class="listing-footer">
                                        <span class="listing-price">{{ number_format($listing->price, 2) }} zł</span>
                                        <span class="listing-date" datetime="{{ $listing->created_at->toIso8601String() }}">{{ $listing->created_at->diffForHumans() }}</span>
                                        <span class="listing-visits"><i class="fas fa-eye"></i> {{ $listing->visits }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        {{ $listings->links() }}
                    </div>
                </section>
            </div>
        </main>

        <!-- footer -->
        @include('shared.footer')
        <script src="{{ asset('js/search.js') }}"></script>
    </body>
</html>
