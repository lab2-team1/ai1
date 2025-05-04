<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Edycja ogłoszenia'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Edycja ogłoszenia</h1>

                @if(session('success'))
                    <div style="color: green;">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('listings.update', $listing->id) }}" class="edit-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Tytuł:</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $listing->title) }}">
                        @error('title')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Opis:</label>
                        <textarea id="description" name="description">{{ old('description', $listing->description) }}</textarea>
                        @error('description')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Cena:</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $listing->price) }}" step="0.01" min="0">
                        @error('price')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status">
                            @foreach(\App\Models\Listing::$statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $listing->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">Zapisz zmiany</button>
                </form>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>