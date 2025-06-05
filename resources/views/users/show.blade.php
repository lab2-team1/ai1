{{-- filepath: resources/views/users/show.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('shared.head', ['pageTitle' => 'Profil'])

<body>
    @include('shared.navigation')

    <div style="display: flex; justify-content: center; padding: 3rem 0 3rem 0; background: #f7f7fa;">
        {{-- Lewa wolna przestrzeń --}}
        <div style="width: 220px; flex-shrink: 0;"></div>

        {{-- Główna zawartość z zakładkami --}}
        <main
            style="flex: 1; max-width: 950px; margin: 0 40px; background: #fff; border-radius: 1rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 2.5rem 2.5rem 2rem 2.5rem;">
            <div class="user-profile">
                <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem;">Profil użytkownika</h1>
                <ul style="list-style: none; padding: 0; margin-bottom: 2.5rem;">
                    <li><strong>Imię:</strong> {{ $user->first_name }}</li>
                    <li><strong>Nazwisko:</strong> {{ $user->last_name }}</li>
                    <li><strong>Telefon:</strong> {{ $user->phone }}</li>
                    <li><strong>Data rejestracji:</strong> {{ $user->created_at->format('Y-m-d') }}</li>
                </ul>

                {{-- Zakładki --}}
                <div style="margin-top: 2rem;">
                    <ul class="nav nav-tabs"
                        style="display: flex; border-bottom: none; gap: 0; justify-content: flex-start; margin-bottom: 0;">
                        <li class="nav-item" style="flex: 1; list-style: none;">
                            <a class="nav-link active" id="listings-tab" href="#"
                                onclick="showTab('listings'); return false;"
                                style="display: block; text-align: center; font-size: 1.25rem; font-weight: 600; padding: 1rem 0 0.7rem 0; border: none; border-radius: 1rem 1rem 0 0; background: #f7f7fa; color: #333; transition: background 0.2s, color 0.2s; position: relative;">
                                Ogłoszenia
                            </a>
                        </li>
                        <li class="nav-item" style="flex: 1; list-style: none;">
                            <a class="nav-link" id="ratings-tab" href="#"
                                onclick="showTab('ratings'); return false;"
                                style="display: block; text-align: center; font-size: 1.25rem; font-weight: 600; padding: 1rem 0 0.7rem 0; border: none; border-radius: 1rem 1rem 0 0; background: #f7f7fa; color: #333; transition: background 0.2s, color 0.2s; position: relative;">
                                Oceny
                            </a>
                        </li>
                    </ul>
                    <div id="tab-listings" class="tab-content" style="margin-top: 2rem;">
                        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;">Ogłoszenia użytkownika
                        </h2>
                        @if ($listings->isEmpty())
                            <p>Brak ogłoszeń.</p>
                        @else
                            <div class="listings-grid"
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; max-width: 1000px; margin: 0 auto;">
                                @foreach ($listings as $listing)
                                    <div class="listing-card"
                                        style="background: #f9f9fb; border-radius: 0.7rem; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e3e3e0; overflow: hidden;">
                                        <div class="listing-image"
                                            style="width: 100%; height: 180px; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                            {{-- <img src="{{ $listing->image_url }}" alt="..." style="max-width:100%;max-height:100%;"> --}}
                                            <span style="color: #bbb;">Brak zdjęcia</span>
                                        </div>
                                        <div class="listing-content" style="padding: 1rem;">
                                            <h3 class="listing-title"
                                                style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">
                                                {{ $listing->title }}</h3>
                                            <div class="listing-price"
                                                style="font-weight: bold; color: #1b1b18; margin-bottom: 0.5rem;">
                                                {{ $listing->formatted_price ?? number_format($listing->price, 2) . ' PLN' }}
                                            </div>
                                            <div class="listing-date" style="color: #706f6c; font-size: 0.875rem;">
                                                {{ $listing->created_at->diffForHumans() }}
                                            </div>
                                            <a href="{{ route('admin.listings.show', $listing->id) }}"
                                                class="btn btn-primary"
                                                style="margin-top: 0.5rem; display: inline-block;">Zobacz</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div id="tab-ratings" class="tab-content" style="margin-top: 2rem; display: none;">
                        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 1.5rem;">Oceny użytkownika</h2>
                        <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                            {{-- Jako kupujący --}}
                            <div style="flex: 1; min-width: 300px;">
                                <h4 style="margin-bottom: 1rem;">Jako kupujący</h4>
                                @forelse($ratingsAsBuyer as $rating)
                                    <div
                                        style="background: #f9f9fb; border-radius: 0.7rem; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e3e3e0; margin-bottom: 1.2rem; padding: 1rem;">
                                        <div style="font-weight: 600;">
                                            {{ $rating->transaction->listing->title ?? 'Brak tytułu' }}
                                        </div>
                                        <div style="font-size: 0.95em; color: #666;">
                                            od: {{ $rating->rater->first_name ?? '' }}
                                            {{ $rating->rater->last_name ?? '' }}
                                        </div>
                                        <div style="margin: 0.5rem 0;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating->rating)
                                                    <span style="color: #f5b301; font-size: 1.3em;">&#9733;</span>
                                                @else
                                                    <span style="color: #aaa; font-size: 1.3em;">&#9733;</span>
                                                @endif
                                            @endfor
                                        </div>
                                        @if ($rating->comment)
                                            <div style="font-size: 0.95em; color: #444;">"{{ $rating->comment }}"</div>
                                        @endif
                                    </div>
                                @empty
                                    <p>Brak ocen jako kupujący.</p>
                                @endforelse
                            </div>
                            {{-- Jako sprzedający --}}
                            <div style="flex: 1; min-width: 300px;">
                                <h4 style="margin-bottom: 1rem;">Jako sprzedający</h4>
                                @forelse($ratingsAsSeller as $rating)
                                    <div
                                        style="background: #f9f9fb; border-radius: 0.7rem; box-shadow: 0 1px 4px rgba(0,0,0,0.06); border: 1px solid #e3e3e0; margin-bottom: 1.2rem; padding: 1rem;">
                                        <div style="font-weight: 600;">
                                            {{ $rating->transaction->listing->title ?? 'Brak tytułu' }}
                                        </div>
                                        <div style="font-size: 0.95em; color: #666;">
                                            do: {{ $rating->rater->first_name ?? '' }}
                                            {{ $rating->rater->last_name ?? '' }}
                                        </div>
                                        <div style="margin: 0.5rem 0;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rating->rating)
                                                    <span style="color: #f5b301; font-size: 1.3em;">&#9733;</span>
                                                @else
                                                    <span style="color: #aaa; font-size: 1.3em;">&#9733;</span>
                                                @endif
                                            @endfor
                                        </div>
                                        @if ($rating->comment)
                                            <div style="font-size: 0.95em; color: #444;">"{{ $rating->comment }}"</div>
                                        @endif
                                    </div>
                                @empty
                                    <p>Brak ocen jako sprzedający.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        {{-- Prawa wolna przestrzeń --}}
        <div style="width: 220px; flex-shrink: 0;"></div>
    </div>

    @include('shared.footer')

    <style>
        .nav-link {
            cursor: pointer;
            border-bottom: 4px solid transparent !important;
            box-shadow: none !important;
        }

        .nav-link.active#listings-tab {
            border-bottom: 4px solid #007bff !important;
            color: #007bff !important;
            background: #fff !important;
        }

        .nav-link.active#ratings-tab {
            border-bottom: 4px solid #f5b301 !important;
            /* złoty jak gwiazdka */
            color: #f5b301 !important;
            background: #fff !important;
        }

        .nav-tabs {
            border-bottom: none !important;
        }
    </style>
    <script>
        function showTab(tab) {
            document.getElementById('tab-listings').style.display = tab === 'listings' ? 'block' : 'none';
            document.getElementById('tab-ratings').style.display = tab === 'ratings' ? 'block' : 'none';
            document.getElementById('listings-tab').classList.toggle('active', tab === 'listings');
            document.getElementById('ratings-tab').classList.toggle('active', tab === 'ratings');
        }
    </script>
</body>

</html>
