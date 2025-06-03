class ImageManager {
    constructor() {
        this.initializeSortable();
        this.initializeDeleteButtons();
    }

    initializeSortable() {
        const sortableImages = document.getElementById('sortable-images');
        if (sortableImages) {
            new Sortable(sortableImages, {
                animation: 150,
                onEnd: () => this.handleReorder(sortableImages)
            });
        }
    }

    async handleReorder(sortableImages) {
        const imageIds = Array.from(sortableImages.querySelectorAll('.image-container'))
            .map(container => container.dataset.imageId);

        const isAdmin = window.location.pathname.includes('/admin/');
        // Extract the listing ID from the URL path
        const pathParts = window.location.pathname.split('/');
        const listingId = pathParts[pathParts.length - 1]; // Get the last part of the URL

        const reorderUrl = isAdmin
            ? `/admin/listings/${listingId}/reorder-images`
            : `/user/listings/${listingId}/reorder-images`;

        try {
            console.log('Sending reorder request:', { image_ids: imageIds, url: reorderUrl });
            const response = await fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ image_ids: imageIds })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Reorder response:', data);

            if (data.message) {
                this.showNotification('Images reordered successfully', 'success');
                // Force a page reload to ensure the new order is displayed
                window.location.reload();
            } else if (data.error) {
                this.showNotification(data.error, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Error reordering images', 'error');
        }
    }

    initializeDeleteButtons() {
        document.querySelectorAll('.delete-image').forEach(button => {
            button.addEventListener('click', () => this.handleDelete(button));
        });
    }

    async handleDelete(button) {
        if (confirm('Are you sure you want to delete this image?')) {
            const imageId = button.dataset.imageId;
            const deleteUrl = button.dataset.deleteUrl;

            try {
                const response = await fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                if (data.success) {
                    button.closest('.image-container').remove();
                    this.showNotification('Image deleted successfully', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.showNotification('Error deleting image', 'error');
            }
        }
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialize image management when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ImageManager();
});
