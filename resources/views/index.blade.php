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

                <!-- Filters -->
                <div class="filters-container">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Category</label>
                            <select class="filter-input">
                                <option value="">All Categories</option>
                                <option value="electronics">Electronics</option>
                                <option value="fashion">Fashion</option>
                                <option value="home">Home & Garden</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Location</label>
                            <input type="text" class="filter-input" placeholder="Enter location">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Price Range</label>
                            <div class="price-range-container">
                                <input type="number" class="price-range-input" placeholder="Min">
                                <span class="price-range-separator">to</span>
                                <input type="number" class="price-range-input" placeholder="Max">
                            </div>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <button class="filter-button">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Featured Listings -->
                <section>
                    <div class="section-header">
                        <h2 class="section-title">Featured Listings</h2>
                        <p class="section-description">Discover our handpicked selection of quality items</p>
                    </div>
                    <div class="listings-grid">
                        <!-- Listing Card 1 -->
                        <div class="listing-card">
                            <div class="listing-image"></div>
                            <div class="listing-content">
                                <h3 class="listing-title">iPhone 13 Pro Max</h3>
                                <p class="listing-description">Like new condition, includes original box and accessories</p>
                                <div class="listing-footer">
                                    <span class="listing-price">$899</span>
                                    <span class="listing-date">2 days ago</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Pagination -->
                    <div class="pagination">
                        <nav class="pagination-nav">
                            <a href="#" class="pagination-link">Previous</a>
                            <a href="#" class="pagination-link active">1</a>
                            <a href="#" class="pagination-link">2</a>
                            <a href="#" class="pagination-link">3</a>
                            <a href="#" class="pagination-link">Next</a>
                        </nav>
                    </div>
                </section>
            </div>
        </main>

        <!-- footer -->
        @include('shared.footer')

    </body>
</html>
