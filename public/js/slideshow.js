class Slideshow {
    constructor(element) {
        this.slideshow = element;
        this.slides = this.slideshow.querySelectorAll('.slide');
        this.thumbnails = this.slideshow.parentElement.querySelectorAll('.thumbnail');
        this.currentSlide = 0;
        this.interval = null;
        this.intervalTime = 4000; // 4 seconds

        if (this.slides.length > 1) {
            this.init();
        }
    }

    init() {
        this.startSlideshow();
        this.addEventListeners();
    }

    showSlide(index) {
        // Remove active class from current slide and thumbnail
        this.slides[this.currentSlide].classList.remove('active');
        this.thumbnails[this.currentSlide].classList.remove('active');

        // Update current slide index
        this.currentSlide = index;

        // Add active class to new current slide and thumbnail
        this.slides[this.currentSlide].classList.add('active');
        this.thumbnails[this.currentSlide].classList.add('active');
    }

    showNextSlide() {
        const nextIndex = (this.currentSlide + 1) % this.slides.length;
        this.showSlide(nextIndex);
    }

    startSlideshow() {
        this.interval = setInterval(() => this.showNextSlide(), this.intervalTime);
        this.slideshow.dataset.interval = this.interval;
    }

    pauseSlideshow() {
        if (this.slideshow.dataset.interval) {
            clearInterval(parseInt(this.slideshow.dataset.interval));
        }
    }

    resumeSlideshow() {
        this.interval = setInterval(() => this.showNextSlide(), this.intervalTime);
        this.slideshow.dataset.interval = this.interval;
    }

    addEventListeners() {
        // Pause on hover
        this.slideshow.addEventListener('mouseenter', () => this.pauseSlideshow());
        this.slideshow.addEventListener('mouseleave', () => this.resumeSlideshow());

        // Thumbnail click events
        this.thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => {
                this.pauseSlideshow();
                this.showSlide(index);
                this.resumeSlideshow();
            });
        });
    }
}

// Initialize all slideshows when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.image-slideshow').forEach(slideshow => {
        new Slideshow(slideshow);
    });
});
