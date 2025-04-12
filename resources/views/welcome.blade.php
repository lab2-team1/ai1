<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MarketPlace - Buy and Sell with Ease</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar">
            <div class="navbar-container">
                <div class="navbar-content">
                    <a href="/" class="navbar-brand">MarketPlace</a>
                    <div class="navbar-menu">
                        <a href="#">Login</a>
                        <a href="#" class="btn-primary">Create Offer</a>
                    </div>
                </div>
            </div>
        </nav>

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

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-grid">
                    <div>
                        <h3 class="footer-title">About Us</h3>
                        <p class="footer-description">Your trusted marketplace for buying and selling quality items.</p>
                    </div>
                    <div>
                        <h3 class="footer-title">Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Terms</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="footer-title">Contact</h3>
                        <ul class="footer-links">
                            <li>Email: </li>
                            <li>Phone: </li>
                            <li>Address: </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="footer-title">Follow Us</h3>
                        <ul class="footer-links">
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Instagram</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-divider">
                    <p>&copy; 2024 MarketPlace. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
