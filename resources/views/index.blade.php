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
                    <form class="search-form">
                        <div class="search-input-group">
                            <input type="text" class="search-input" placeholder="Search for anything...">
                            <button type="submit" class="search-button">Search</button>
                        </div>
                    </form>
                </div>

                <section class="categories">
                    <h2>Kategorie</h2>
                    <div class="category-grid">
                        @foreach($categories as $category)
                            <a href="{{ route('listings.index', ['category' => $category->id]) }}" class="category-card">
                                <h3>{{ $category->name }}</h3>
                                <p>{{ $category->description }}</p>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="latest-listings">
                    <h2>Najnowsze ogłoszenia</h2>
                    <div class="listing-grid">
                        @foreach($listings as $listing)
                            <div class="listing-card">
                                <div class="listing-header">
                                    <h3>{{ $listing->title }}</h3>
                                    <span class="listing-price">{{ number_format($listing->price, 2) }} zł</span>
                                </div>
                                <p class="listing-description">{{ Str::limit($listing->description, 100) }}</p>
                                <div class="listing-footer">
                                    <span class="listing-category">{{ $listing->category->name }}</span>
                                    <a href="{{ route('listings.show', $listing) }}" class="btn btn-secondary">Zobacz szczegóły</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <a href="{{ route('listings.index') }}" class="btn btn-primary">Zobacz wszystkie ogłoszenia</a>
                    </div>
                </section>
            </div>
        </main>

        <!-- footer -->
        @include('shared.footer')

    </body>
</html>
