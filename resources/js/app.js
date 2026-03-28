import './bootstrap';
import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, FreeMode } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

window.Alpine = Alpine;
window.Swiper = Swiper;
window.SwiperModules = { Navigation, Pagination, Autoplay, FreeMode };

Alpine.start();

// Initialize Swiper sliders when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Hero Swiper
    const heroSwiper = document.querySelector('.hero-swiper');
    if (heroSwiper) {
        new Swiper('.hero-swiper', {
            modules: [Pagination, Autoplay],
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    // Testimonial Swiper
    const testimonialSwiper = document.querySelector('.testimonial-swiper');
    if (testimonialSwiper) {
        new Swiper('.testimonial-swiper', {
            modules: [Pagination, Autoplay],
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            slidesPerView: 1,
            spaceBetween: 30,
        });
    }

    // Proses Akad Swiper - Infinite smooth slider
    const prosesAkadSwiper = document.querySelector('.proses-akad-swiper');
    if (prosesAkadSwiper) {
        new Swiper('.proses-akad-swiper', {
            modules: [Autoplay, FreeMode],
            loop: true,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
            },
            speed: 3000,
            slidesPerView: 2,
            spaceBetween: 16,
            allowTouchMove: true,
            freeMode: true,
            breakpoints: {
                640: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 24,
                },
                1280: {
                    slidesPerView: 6,
                    spaceBetween: 24,
                },
            },
        });
    }
});
