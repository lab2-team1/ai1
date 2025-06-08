function toggleEdit(fieldId) {
    const input = document.getElementById(fieldId);
    input.readOnly = !input.readOnly;
    if (!input.readOnly) {
        input.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.user-profile-form .is-invalid');
    inputs.forEach(input => {
        input.readOnly = false;
    });

    const addAddressButton = document.getElementById('addAddressButton');
    const addAddressFormContainer = document.getElementById('addAddressFormContainer');
    const addAddressForm = document.getElementById('addAddressForm');
    const cancelAddAddressButton = document.getElementById('cancelAddAddress');

    addAddressButton.addEventListener('click', function() {
        addAddressFormContainer.style.display = 'block';
        addAddressButton.style.display = 'none';
        addAddressFormContainer.scrollIntoView({ behavior: 'smooth' });
    });

    cancelAddAddressButton.addEventListener('click', function() {
        addAddressFormContainer.style.display = 'none';
        addAddressButton.style.display = 'block';
        addAddressForm.reset();
    });

    const editAddressFormContainer = document.getElementById('editAddressFormContainer');
    const editAddressForm = document.getElementById('editAddressForm');
    const cancelEditAddressButton = document.getElementById('cancelEditAddress');
    const editAddressButtons = document.querySelectorAll('.edit-address-button');
    const editAddressIdInput = document.getElementById('edit_address_id');
    const editStreetInput = document.getElementById('edit_street');
    const editCityInput = document.getElementById('edit_city');
    const editZipCodeInput = document.getElementById('edit_zip_code');
    const editCountryInput = document.getElementById('edit_country');

    editAddressButtons.forEach(button => {
        button.addEventListener('click', function() {
            const addressId = this.getAttribute('data-id');
            const street = this.getAttribute('data-street');
            const city = this.getAttribute('data-city');
            const zipcode = this.getAttribute('data-zipcode');
            const country = this.getAttribute('data-country');

            editAddressIdInput.value = addressId;
            editStreetInput.value = street;
            editCityInput.value = city;
            editZipCodeInput.value = zipcode;
            editCountryInput.value = country;

            editAddressForm.action = '/user/addresses/' + addressId;

            editAddressFormContainer.style.display = 'block';
            addAddressButton.style.display = 'none';
            editAddressFormContainer.scrollIntoView({ behavior: 'smooth' });
        });
    });

    cancelEditAddressButton.addEventListener('click', function() {
        editAddressFormContainer.style.display = 'none';
        addAddressButton.style.display = 'block';
        editAddressForm.reset();
    });

    document.querySelectorAll('.alert .btn-close').forEach(button => {
        button.addEventListener('click', () => {
            button.closest('.alert').remove();
        });
    });

    // Obsługa błędów formularza
    if (document.querySelector('.invalid-feedback')) {
        document.getElementById('addAddressFormContainer').style.display = 'block';
        document.getElementById('addAddressButton').style.display = 'none';
        document.getElementById('addAddressFormContainer').scrollIntoView({ behavior: 'smooth' });
    }
});