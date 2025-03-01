$(window).on("load", () => {
  showLoader();
  setTimeout(() => {
    hideLoader();
  }, 1000);
});

$(document).ready(() => {
  initCarousel();
});

window.showLoader = () => {
  $("#preloader").removeClass("preloader-hidden").show();
};

window.hideLoader = () => {
  $("#preloader").addClass("animate__animated animate__fadeOut preloader-hidden");
  setTimeout(() => $("#preloader").hide(), 200);
};

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
