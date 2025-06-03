document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this image?')) {
                const imageId = this.dataset.imageId;
                const deleteUrl = this.dataset.deleteUrl;

                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        this.closest('.image-container').remove();
                    } else {
                        alert(data.message || 'Error deleting image');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the image.');
                });
            }
        });
    });
});
