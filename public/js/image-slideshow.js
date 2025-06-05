document.addEventListener('DOMContentLoaded', function() {
    // Initialize all slideshows
    const slideshows = document.querySelectorAll('.image-slideshow');

    slideshows.forEach(slideshow => {
        const slides = slideshow.querySelectorAll('.slide');
        let currentSlide = 0;
        let interval;

        // Function to show the next slide
        function showNextSlide() {
            // Remove active class from current slide
            slides[currentSlide].classList.remove('active');

            // Move to next slide, loop back to first if at end
            currentSlide = (currentSlide + 1) % slides.length;

            // Add active class to new current slide
            slides[currentSlide].classList.add('active');
        }

        // Start the slideshow if there's more than one image
        if (slides.length > 1) {
            // Set interval for automatic slideshow
            interval = setInterval(showNextSlide, 4000); // Change slide every 4 seconds

            // Store interval ID on the slideshow element
            slideshow.dataset.interval = interval;

            // Optional: Pause slideshow on hover
            slideshow.addEventListener('mouseenter', () => {
                if (slideshow.dataset.interval) {
                    clearInterval(parseInt(slideshow.dataset.interval));
                }
            });

            slideshow.addEventListener('mouseleave', () => {
                interval = setInterval(showNextSlide, 4000);
                slideshow.dataset.interval = interval;
            });
        }
    });
});
