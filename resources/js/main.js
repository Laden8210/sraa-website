$(window).on("load", () => {
    setTimeout(() => {
      $("#preloader").addClass("animate__animated animate__fadeOut preloader-hidden");
      setTimeout(() => $("#preloader").hide(), 200);
    }, 1000);
  });

  $(document).ready(() => {

    initCarousel();

  });




  const initCarousel = () => {
    const slides = $(".carousel-slide");
    let currentSlide = 0;

    const showSlide = (index) => {
      slides.removeClass("active").eq(index).addClass("active");
    };

    setInterval(() => {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }, 5000);
  };
