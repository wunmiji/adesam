var carousel = new Swiper(".home-swiper", {
    speed: 400,
    slidesPerView: 1,
    shortSwipes: false,
    simulateTouch: false, // For text clickable
    //spaceBetween: 16,
    //centeredSlides: true,
    //centeredSlidesBounds: true,

    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true
    },
});
