/*  Interacciones propias de la página principal. */

(function () {
    "use strict";

    // Modal: al abrir una noticia, cargar su imagen en grande
    var modalImg = document.getElementById('modalImage');
    if (!modalImg) return;

    document.querySelectorAll('[data-img]').forEach(function (el) {
        el.addEventListener('click', function () {
            modalImg.src = el.getAttribute('data-img');
        });
    });
})();