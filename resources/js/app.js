import './bootstrap';



// Menú responsive
document.addEventListener('DOMContentLoaded', () => {

    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {

        menuToggle.addEventListener('click', () => {

            const isHidden = mobileMenu.classList.toggle('hidden');

            menuToggle.setAttribute(
                'aria-expanded',
                String(!isHidden)
            );

        });

        // Cerrar el menú al seleccionar una opción
        mobileMenu.querySelectorAll('a').forEach(link => {

            link.addEventListener('click', () => {

                mobileMenu.classList.add('hidden');

                menuToggle.setAttribute(
                    'aria-expanded',
                    'false'
                );

            });

        });

    }

});
