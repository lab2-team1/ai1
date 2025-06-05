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
        const listingId = window.location.pathname.split('/').filter(Boolean).pop();
        const reorderUrl = isAdmin
            ? `/admin/listings/${listingId}/reorder-images`
            : `/user/listings/${listingId}/reorder-images`;

        try {
            const response = await fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ image_ids: imageIds })
            });

            const data = await response.json();
            if (data.message) {
                this.showNotification('Images reordered successfully', 'success');
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
                    if (confirm('Image deleted successfully. Click OK to refresh the page.')) {
                        window.location.reload();
                    }
                } else {
                    this.showNotification('Error deleting image', 'error');
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
