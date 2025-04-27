<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'MarketPlace - Buy and Sell with Ease'])
    <body>
        <!-- Navigation -->
        @include('shared.navigation')

        <div class="admin-panel">
        @include('shared.adminSidebar')
        <section class="admin-content">
            <h1>Zarządzanie ogłoszeniami</h1>
            <a href="{{ route('listings.create') }}" class="btn-primary" style="max-width:200px; margin-bottom: 1rem; display:inline-block;">Dodaj nowe ogłoszenie</a>
            <div style="overflow-x:auto;">
                <table class="table" style="width:100%; border-collapse:collapse; background:white;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Kategoria</th>
                            <th>Właściciel</th>
                            <th>Cena</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                            <tr>
                                <td>{{ $listing->id }}</td>
                                <td>{{ $listing->title }}</td>
                                <td>{{ $listing->category ? $listing->category->name : '-' }}</td>
                                <td>{{ $listing->user ? $listing->user->first_name . ' ' . $listing->user->last_name : '-' }}</td>
                                <td>{{ $listing->formatted_price ?? number_format($listing->price, 2) . ' PLN' }}</td>
                                <td>{{ ucfirst($listing->status) }}</td>
                                <td style="white-space:nowrap;">
                                    <a href="{{ route('listings.show', $listing->id) }}" title="Podgląd"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('listings.edit', $listing->id) }}" title="Edytuj" style="margin-left:10px;"><i class="fa fa-edit"></i></a>
                                    <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" style="display:inline; margin-left:10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Usuń" style="background:none; border:none; color:#c00; cursor:pointer;" onclick="return confirm('Na pewno usunąć to ogłoszenie?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;">Brak ogłoszeń do wyświetlenia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
        </div>

        <!-- footer -->
        @include('shared.footer')

    </body>
</html>
