class Slideshow {
    constructor(element) {
        this.slideshow = element;
        this.slides = this.slideshow.querySelectorAll('.slide');
        this.thumbnails = this.slideshow.parentElement.querySelectorAll('.thumbnail');
        this.currentSlide = 0;
        this.interval = null;
        this.intervalTime = 4000; // 4 seconds
        this.imagesLoaded = false;

        if (this.slides.length > 1) {
            this.init();
        }
    }

    init() {
        this.preloadImages().then(() => {
            this.imagesLoaded = true;
            this.startSlideshow();
            this.addEventListeners();
        });
    }

    preloadImages() {
        const promises = Array.from(this.slides).map(slide => {
            return new Promise((resolve) => {
                const img = slide.querySelector('img');
                if (img) {
                    if (img.complete) {
                        resolve();
                    } else {
                        img.onload = () => resolve();
                        img.onerror = () => resolve(); // Resolve even on error to not block the slideshow
                    }
                } else {
                    resolve();
                }
            });
        });
        return Promise.all(promises);
    }

    showSlide(index) {
        if (!this.imagesLoaded) return;

        // Remove active class from current slide and thumbnail
        this.slides[this.currentSlide].classList.remove('active');
        if (this.thumbnails[this.currentSlide]) {
            this.thumbnails[this.currentSlide].classList.remove('active');
        }

        // Update current slide index
        this.currentSlide = index;

        // Add active class to new current slide and thumbnail
        this.slides[this.currentSlide].classList.add('active');
        if (this.thumbnails[this.currentSlide]) {
            this.thumbnails[this.currentSlide].classList.add('active');
        }
    }

    showNextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.showSlide(nextIndex);
    }

    startSlideshow() {
        if (this.interval) {
            clearInterval(this.interval);
        }
        this.interval = setInterval(() => this.showNextSlide(), this.intervalTime);
        this.slideshow.dataset.interval = this.interval;
    }

    pauseSlideshow() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    }

    resumeSlideshow() {
        if (!this.interval) {
            this.startSlideshow();
        }
    }

    addEventListeners() {
        // Pause on hover
        this.slideshow.addEventListener('mouseenter', () => this.pauseSlideshow());
        this.slideshow.addEventListener('mouseleave', () => this.resumeSlideshow());

        // Thumbnail click events
        if (this.thumbnails) {
            this.thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => {
                    this.pauseSlideshow();
                    this.showSlide(index);
                    this.resumeSlideshow();
                });
            });
        }
    }
}

// Initialize all slideshows when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.image-slideshow').forEach(slideshow => {
        new Slideshow(slideshow);
    });
});
