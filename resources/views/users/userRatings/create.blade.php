{{-- filepath: resources/views/users/userRatings/create.blade.php --}}
@include('shared.head', ['pageTitle' => 'Profil'])

<body>
    @include('shared.navigation')
    <div class="user-panel">
        @include('shared.userSidebar')
        <section class="user-content">
            <h2>Wystaw ocenę użytkownikowi</h2>
            <form method="POST" action="{{ route('userRatings.store') }}">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="rated_user_id" value="{{ $transaction->seller_id == auth()->id() ? $transaction->buyer_id : $transaction->seller_id }}">

                <div class="form-group">
                    <label for="rating">Ocena (1-5):</label>
                    <select name="rating" id="rating" class="form-control" required>
                        <option value="">Wybierz ocenę</option>
                        @for($i=5; $i>=1; $i--)
                            <option value="{{ $i }}">{{ $i }} ★</option>
                        @endfor
                    </select>
                    @error('rating')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Komentarz (opcjonalnie):</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Wyślij ocenę</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">Wróć</button>
            </form>
        </section>
    </div>
    @include('shared.footer')
</body>
