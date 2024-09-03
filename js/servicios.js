document.addEventListener('DOMContentLoaded', function () {
    const overlays = document.querySelectorAll('.overlayservicios');
    const navLinks = document.querySelectorAll('#menu .nav a');

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            overlays.forEach(o => o.style.display = 'none'); // Ocultar todos los overlays

            // Si el enlace tiene un hash, desplázate a la sección correspondiente
            if (this.hash !== "") {
                e.preventDefault();
                const hash = this.hash;

                // Usar jQuery para desplazarse suavemente
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    window.location.hash = hash;
                });
            }
        });
    });
});

function showInfo(infoId) {
    document.getElementById(infoId).style.display = 'flex';
}

function hideInfo(event) {
    if (event.target.classList.contains('overlayservicios')) {
        event.target.style.display = 'none';
    }
}