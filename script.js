(function () {
    const listElements = document.querySelectorAll('.menu__item--show');
    const list = document.querySelector('.menu__links');
    const menu = document.querySelector('.menu__hamburguer');

    const addClick = () => {
        listElements.forEach(element => {
            element.addEventListener('click', () => {


                let subMenu = element.children[1];
                let height = 0;
                element.classList.toggle('menu__item--active');


                if (subMenu.clientHeight === 0) {
                    height = subMenu.scrollHeight;
                }

                subMenu.style.height = `${height}px`;

            });
        });
    }

    const deleteStyleHeight = () => {
        listElements.forEach(element => {

            if (element.children[1].getAttribute('style')) {
                element.children[1].removeAttribute('style');
                element.classList.remove('menu__item--active');
            }

        });
    }


    window.addEventListener('resize', () => {
        if (window.innerWidth > 800) {
            deleteStyleHeight();
            if (list.classList.contains('menu__links--show'))
                list.classList.remove('menu__links--show');

        } else {
            addClick();
        }
    });

    if (window.innerWidth <= 800) {
        addClick();
    }

    menu.addEventListener('click', () => list.classList.toggle('menu__links--show'));



})();




// Selecciona el carrusel por su id
var myCarousel = document.getElementById('myCarousel');

// Crea un objeto Carousel y almacénalo en una variable
var carousel = new bootstrap.Carousel(myCarousel);

// Usa setInterval para cambiar al siguiente slide cada 7 segundos
var intervalId = setInterval(function () {
    // Utiliza el método 'next' del carrusel para cambiar al siguiente slide
    carousel.next();
}, 7000); // 7000 milisegundos = 7 segundos

// Agrega un event listener para el evento 'click' en el botón de siguiente
myCarousel.querySelector('.carousel-control-next').addEventListener('click', function () {
    // Reinicia el intervalo de cambio automático de slide
    clearInterval(intervalId);
    intervalId = setInterval(function () {
        carousel.next();
    }, 7000);
});

// Agrega un event listener para el evento 'click' en el botón de anterior
myCarousel.querySelector('.carousel-control-prev').addEventListener('click', function () {
    // Reinicia el intervalo de cambio automático de slide
    clearInterval(intervalId);
    intervalId = setInterval(function () {
        carousel.next();
    }, 7000);
});



