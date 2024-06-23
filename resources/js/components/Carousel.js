const createCarousel = (container) => {
    const carouselItems = container.querySelectorAll('.carousel__item');
    const carouselButtons = container.querySelectorAll('.controls button');
    const rotationButton = container.querySelector('.rotation');

    let currentIndex = 0;
    let intervalId = null;

    const startRotation = () => {
      if (!intervalId) {
        intervalId = setInterval(goToNextSlide, 3000);
        updateRotationButton(true);
      }
    };

    const stopRotation = () => {
      clearInterval(intervalId);
      intervalId = null;
      updateRotationButton(false);
    };

    const updateRotationButton = (isPlaying) => {
      if (rotationButton) {
        rotationButton.innerHTML = isPlaying
          ? '<span><i class="fa-solid fa-pause"></i></span>'
          : '<span><i class="fa-solid fa-play"></i></span>';
      }
    };

    const goToSlide = (index) => {
      if (carouselItems) {
        currentIndex = (index + carouselItems.length) % carouselItems.length;
        updateCarousel();
      }
    };

    const goToNextSlide = () => {
      goToSlide(currentIndex + 1);
    };

    const goToPreviousSlide = () => {
      goToSlide(currentIndex - 1);
    };

    const handleButtonClick = (event) => {
      const { classList } = event.currentTarget;
      if (classList.contains('previous')) {
        stopRotation();
        goToPreviousSlide();
      } else if (classList.contains('next')) {
        stopRotation();
        goToNextSlide();
      } else if (classList.contains('rotation')) {
        toggleRotation();
      }
    };

    const updateCarousel = () => {
      carouselItems.forEach((item)=> item.classList.remove("show"))
      carouselItems[currentIndex]?.classList.add("show")
      const ariaLabel = `${currentIndex + 1} of ${carouselItems.length}`;
      carouselItems[currentIndex]?.setAttribute('aria-label', ariaLabel);
    };

    const toggleRotation = () => {
      if (intervalId) {
        stopRotation();
      } else {
        startRotation();
      }
    };

    // Initialize event listeners
    carouselButtons.forEach((button) => {
      button.addEventListener('click', handleButtonClick);
    });

    // Start rotation initially
    goToSlide(currentIndex);
    startRotation();
  };

  const Carousel = ()=>{
  // Initialize all carousels on the page
  document.querySelectorAll('.carousel').forEach(createCarousel);
  }

  export default Carousel;
