// Importar Swiper y sus estilos
import { Swiper } from 'swiper/bundle';
import 'swiper/css/bundle';

// Inicializar Swiper cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si existe el contenedor del swiper
    const swiperContainer = document.querySelector('.card-wrapper');
    
    if (swiperContainer) {
        new Swiper(swiperContainer, {
            // Configuración básica
            loop: true,
            loopedSlides: 3,
            slidesPerView: 3,
            spaceBetween: 20,
            centeredSlides: false,
            slideToClickedSlide: false,
            watchSlidesProgress: false,
            
            // Efecto de deslizamiento
            effect: 'slide',
            
            // Paginación
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: false,
            },
            
            // Navegación
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            // Breakpoints responsivos
            breakpoints: {
                // Pantallas pequeñas (móviles)
                320: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                // Tablets pequeñas
                576: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                // Tablets grandes
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                // Escritorios
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                }
            },
            
            // Autoplay
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
        });
        
        console.log('Swiper inicializado correctamente');
    } else {
        console.error('No se encontró el contenedor del Swiper');
    }
});
