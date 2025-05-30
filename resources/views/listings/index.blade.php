<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Lista ogłoszeń'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Lista ogłoszeń</h1>

                <a href="{{ route('admin.listings.create') }}" class="btn-primary">Dodaj nowe ogłoszenie</a>

                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tytuł</th>
                                <th>Kategoria</th>
                                <th>Cena</th>
                                <th>Status</th>
                                <th>Właściciel</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listings as $listing)
                                <tr>
                                    <td>{{ $listing->id }}</td>
                                    <td>{{ $listing->title }}</td>
                                    <td>{{ $listing->category ? $listing->category->name : '-' }}</td>
                                    <td>{{ $listing->formatted_price }}</td>
                                    <td>{{ ucfirst($listing->status) }}</td>
                                    <td>{{ $listing->user ? $listing->user->first_name . ' ' . $listing->user->last_name : '-' }}</td>
                                    <td class="admin-actions">
                                        <a href="{{ route('admin.listings.show', $listing->id) }}">Szczegóły</a>
                                        <a href="{{ route('admin.listings.edit', $listing->id) }}">Edytuj</a>
                                        <form action="{{ route('admin.listings.destroy', $listing->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Na pewno usunąć to ogłoszenie?')">Usuń</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-message">Brak ogłoszeń</td>
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
