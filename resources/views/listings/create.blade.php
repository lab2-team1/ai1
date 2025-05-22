<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Dodaj ogłoszenie'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Dodaj nowe ogłoszenie</h1>

                @if(session('success'))
                    <div style="color: green;">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.listings.store') }}" class="edit-form">
                    @csrf

                    <div class="form-group">
                        <label for="title">Tytuł:</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}">
                        @error('title')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="user_id">Użytkownik:</label>
                        <input type="number" id="user_id" name="user_id" value="{{ old('user_id') }}">
                        @error('user_id')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategoria:</label>
                        <input type="number" id="category_id" name="category_id" value="{{ old('category_id') }}">
                        @error('category_id')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Opis:</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Cena:</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0">
                        @error('price')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            @foreach(\App\Models\Listing::$statuses as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">Dodaj ogłoszenie</button>
                </form>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>