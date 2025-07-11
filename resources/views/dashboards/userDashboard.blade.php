<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('shared.head', ['pageTitle' => 'MarketPlace - Buy and Sell with Ease'])
    <head>
        @vite(['resources/js/userDashboard.js'])
    </head>
    <body>
        @include('shared.navigation')

        <div class="user-panel">
        @include('shared.userSidebar')
        <section class="user-content">
            <h1>User Panel</h1>

            @if(session('profile_success'))
                <div class="alert alert-success">
                    {{ session('profile_success') }}
                </div>
            @endif

            <form action="{{ route('user.update') }}" method="POST" class="user-profile-form" id="userProfileForm">
                @csrf
                @method('PUT')
                <div class="user-field">
                    <label for="first_name">First Name</label>
                    <div class="field-with-edit">
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" class="form-control @error('first_name') is-invalid @enderror" readOnly>
                        <button type="button" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    @error('first_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="user-field">
                    <label for="last_name">Last Name</label>
                    <div class="field-with-edit">
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" class="form-control @error('last_name') is-invalid @enderror" readOnly>
                        <button type="button" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    @error('last_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="user-field">
                    <label for="email">Email</label>
                    <div class="field-with-edit">
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control @error('email') is-invalid @enderror" readOnly>
                        <button type="button" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="user-field">
                    <label for="phone">Phone Number</label>
                    <div class="field-with-edit">
                        <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" class="form-control @error('phone') is-invalid @enderror" readOnly>
                        <button type="button" class="edit-button">
                            <i class="fa fa-edit"></i>
                        </button>
                    </div>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" id="submitButton">Save</button>
            </form>

            <br>
            <hr>

            <h2>Your Addresses</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($addresses->isEmpty())
                <p>You don't have any addresses yet.</p>
            @else
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Street</th>
                            <th>City</th>
                            <th>Zip Code</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addresses as $address)
                        <tr>
                            <td>{{ $address->street }}</td>
                            <td>{{ $address->city }}</td>
                            <td>{{ $address->zip_code }}</td>
                            <td>{{ $address->country }}</td>
                            <td class="admin-actions">
                                <button type="button" class="edit-address-button" data-id="{{ $address->id }}" data-street="{{ $address->street }}" data-city="{{ $address->city }}" data-zipcode="{{ $address->zip_code }}" data-country="{{ $address->country }}" title="Edit"><i class="fa fa-edit"></i></button>
                                <form action="{{ route('user.addresses.destroy', $address->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this address?')"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <button type="button" class="btn btn-primary mt-3" id="addAddressButton">Add New Address</button>
            <div id="addAddressFormContainer" style="display: none;" class="mt-4">
                <h3>Add New Address</h3>
                <form action="{{ route('user.addresses.store') }}" method="POST" id="addAddressForm">
                    @csrf
                    <div class="mb-3">
                        <label for="add_street" class="form-label">Street</label>
                        <input type="text" class="form-control @error('street') is-invalid @enderror" id="add_street" name="street" value="{{ old('street') }}" required>
                        @error('street')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_city" class="form-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="add_city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="add_zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="add_country" class="form-label">Country</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="add_country" name="country" value="{{ old('country') }}" required>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Add Address</button>
                    <button type="button" class="btn btn-secondary" id="cancelAddAddress">Cancel</button>
                </form>
            </div>

            <p> </p>
            <div id="editAddressFormContainer" style="display: none;" class="mt-4">
                <h3>Edit Address</h3>
                <form action="" method="POST" id="editAddressForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_address_id" id="edit_address_id">
                    <div class="mb-3">
                        <label for="edit_street" class="form-label">Street</label>
                        <input type="text" class="form-control @error('street') is-invalid @enderror" id="edit_street" name="street" value="{{ old('street') }}" required>
                        @error('street')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="edit_city" class="form-label">City</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="edit_city" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="edit_zip_code" name="zip_code" value="{{ old('zip_code') }}" required>
                        @error('zip_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country</label>
                        <input type="text" class="form-control @error('country') is-invalid @enderror" id="edit_country" name="country" value="{{ old('country') }}" required>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" id="cancelEditAddress">Cancel</button>  
                </form>
            </div>

        </section>
        </div>

        @include('shared.footer')
    </body>
</html>
