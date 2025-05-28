<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => $listing->title])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Szczegóły ogłoszenia</h1>

                <div class="listing-details">
                    <div class="detail-group">
                        <h2>{{ $listing->title }}</h2>
                        <p class="listing-description">{{ $listing->description }}</p>
                    </div>

                    <div class="detail-group">
                        <h3>Informacje</h3>
                        <ul class="listing-info">
                            <li><strong>Cena:</strong> {{ $listing->formatted_price }}</li>
                            <li><strong>Status:</strong> {{ ucfirst($listing->status) }}</li>
                            <li><strong>Kategoria:</strong> {{ $listing->category ? $listing->category->name : '-' }}</li>
                            <li><strong>Właściciel:</strong> {{ $listing->user ? $listing->user->first_name . ' ' . $listing->user->last_name : '-' }}</li>
                            <li><strong>Data dodania:</strong> {{ $listing->created_at->format('d.m.Y H:i') }}</li>
                        </ul>
                    </div>

                    <div class="detail-actions">
                        <a href="{{ route('admin.listings.edit', $listing->id) }}" class="btn-primary">Edytuj</a>
                        <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Na pewno usunąć to ogłoszenie?')">Usuń</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>
