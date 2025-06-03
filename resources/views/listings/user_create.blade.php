<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Dodaj ogłoszenie'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Add new listing</h1>

                @if(session('success'))
                    <div style="color: green;">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('user.listings.store') }}" class="edit-form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}">
                        @error('title')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0">
                        @error('price')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="images">Images:</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*">
                        <small class="form-text text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF</small>
                        @error('images')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">Add listing</button>
                </form>
            </section>
        </div>

        @include('shared.footer')
    </body>
</html>
