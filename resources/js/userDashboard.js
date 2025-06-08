document.addEventListener('DOMContentLoaded', function() {
    function toggleEdit(fieldId) {
        const input = document.getElementById(fieldId);
        if (input) {
            input.readOnly = !input.readOnly;
            if (!input.readOnly) {
                input.focus();
            }
        }
    }

    const profileEditButtons = document.querySelectorAll('.user-profile-form .edit-button');
    profileEditButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inputField = this.previousElementSibling;
            if (inputField && inputField.id) {
                toggleEdit(inputField.id);
            }
        });
    });

    const inputs = document.querySelectorAll('.user-profile-form .is-invalid');
    inputs.forEach(input => {
        input.readOnly = false;
    });

    const addAddressButton = document.getElementById('addAddressButton');
    const addAddressFormContainer = document.getElementById('addAddressFormContainer');
    const addAddressForm = document.getElementById('addAddressForm');
    const cancelAddAddressButton = document.getElementById('cancelAddAddress');

    if (addAddressButton) {
        addAddressButton.addEventListener('click', function() {
            addAddressFormContainer.style.display = 'block';
            addAddressButton.style.display = 'none';
            addAddressFormContainer.scrollIntoView({ behavior: 'smooth' });
        });
    }

    if (cancelAddAddressButton) {
        cancelAddAddressButton.addEventListener('click', function() {
            addAddressFormContainer.style.display = 'none';
            addAddressButton.style.display = 'block';
            if (addAddressForm) {
                addAddressForm.reset();
            }
        });
    }

    const editAddressFormContainer = document.getElementById('editAddressFormContainer');
    const editAddressForm = document.getElementById('editAddressForm');
    const cancelEditAddressButton = document.getElementById('cancelEditAddress');
    const editAddressButtons = document.querySelectorAll('.edit-address-button');

    if (editAddressButtons.length > 0) {
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
                if (addAddressButton) addAddressButton.style.display = 'none';
                editAddressFormContainer.scrollIntoView({ behavior: 'smooth' });
            });
        });

        if (cancelEditAddressButton) {
            cancelEditAddressButton.addEventListener('click', function() {
                editAddressFormContainer.style.display = 'none';
                if (addAddressButton) addAddressButton.style.display = 'block';
                if (editAddressForm) {
                    editAddressForm.reset();
                }
            });
        }
    }

    document.querySelectorAll('.alert .btn-close').forEach(button => {
        button.addEventListener('click', (event) => {
            event.target.closest('.alert').remove();
        });
    });

    if (document.querySelector('#addAddressForm .invalid-feedback')) {
        if (addAddressFormContainer) addAddressFormContainer.style.display = 'block';
        if (addAddressButton) addAddressButton.style.display = 'none';
        if (addAddressFormContainer) addAddressFormContainer.scrollIntoView({ behavior: 'smooth' });
    }
});