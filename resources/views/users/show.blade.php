<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('shared.head', ['pageTitle' => 'Profil'])

<body>
    @include('shared.navigation')

    <main class="profile" style="padding-top: 4rem;">
        <div class="user-profile">
            <h1>Profil użytkownika</h1>
            <ul>
                <li><strong>Imię:</strong> {{ $user->first_name }}</li>
                <li><strong>Nazwisko:</strong> {{ $user->last_name }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Telefon:</strong> {{ $user->phone }}</li>
                <li><strong>Data rejestracji:</strong> {{ $user->created_at->format('Y-m-d') }}</li>
            </ul>

            <!-- ...dane użytkownika... -->

            <h2>Ogłoszenia użytkownika</h2>
            @if ($listings->isEmpty())
                <p>Brak ogłoszeń.</p>
            @else
                <div class="listings-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 300px)); gap: 1.5rem; max-width: 1000px; margin: 0 auto;">
                    @foreach ($listings as $listing)
                        <div class="listing-card"
                            style="background: #fff; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e3e3e0; overflow: hidden;">
                            <div class="listing-image"
                                style="width: 100%; height: 180px; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                {{-- Tu możesz dodać <img src="{{ $listing->image_url }}" alt="..." style="max-width:100%;max-height:100%;"> jeśli masz zdjęcia --}}
                                <span style="color: #bbb;">Brak zdjęcia</span>
                            </div>
                            <div class="listing-content" style="padding: 1rem;">
                                <h3 class="listing-title"
                                    style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">
                                    {{ $listing->title }}</h3>
                                <div class="listing-price"
                                    style="font-weight: bold; color: #1b1b18; margin-bottom: 0.5rem;">
                                    {{ $listing->formatted_price ?? number_format($listing->price, 2) . ' PLN' }}
                                </div>
                                <div class="listing-date" style="color: #706f6c; font-size: 0.875rem;">
                                    {{ $listing->created_at->diffForHumans() }}
                                </div>
                                <a href="{{ route('admin.listings.show', $listing->id) }}" class="btn btn-primary"
                                    style="margin-top: 0.5rem; display: inline-block;">Zobacz</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>

    @include('shared.footer')
</body>

</html>
