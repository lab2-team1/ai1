<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'Edit Listing'])
    <body>
        @include('shared.navigation')

        <div class="admin-panel">
            @include('shared.adminSidebar')
            <section class="admin-content">
                <h1>Edit Listing</h1>

                @if(session('success'))
                    <div style="color: green;">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.listings.update', $listing->id) }}" class="edit-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $listing->title) }}">
                        @error('title')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description">{{ old('description', $listing->description) }}</textarea>
                        @error('description')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $listing->price) }}" step="0.01" min="0">
                        @error('price')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select id="category_id" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $listing->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
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

                    <div class="form-group">
                        <label>Current Images:</label>
                        <div class="current-images" id="sortable-images">
                            @if($listing->images && count($listing->images) > 0)
                                @foreach($listing->images->sortBy('order') as $image)
                                    <div class="image-container" data-image-id="{{ $image->id }}">
                                        <img src="{{ asset('storage/' . $image->image_url) }}" alt="Listing image" style="max-width: 200px; margin: 5px;">
                                        <div class="image-actions">
                                            <button type="button" class="set-primary-image {{ $image->is_primary ? 'active' : '' }}"
                                                    data-image-id="{{ $image->id }}"
                                                    data-url="{{ route('admin.listings.set-primary-image', $image->id) }}">
                                                {{ $image->is_primary ? 'Primary' : 'Set as Primary' }}
                                            </button>
                                            <button type="button" class="delete-image"
                                                    data-image-id="{{ $image->id }}"
                                                    data-delete-url="{{ route('admin.listings.delete-image', $image->id) }}">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No images uploaded yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="images">Add New Images:</label>
                        <input type="file" id="images" name="images[]" multiple accept="image/*">
                        <small class="form-text text-muted">You can select multiple images. Supported formats: JPG, PNG, GIF</small>
                        @error('images')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="submit-button">Save Changes</button>
                </form>
            </section>
        </div>

        @include('shared.footer')
        <script src="{{ asset('js/image-delete.js') }}"></script>
    </body>
</html>
