/* Comportamiento de las barras fijas al hacer scroll. */

(function () {
    "use strict";

    var barras = ['#nav-gob', '#nav-colsan', '#nav-sistem']
        .map(function (sel) { return document.querySelector(sel); })
        .filter(Boolean);

    if (barras.length < 2) return;   // con una sola barra no hay nada que mover

    var superior = barras[0];
    var inferior = barras[1];

    function alDesplazar() {
        var bajo = window.scrollY > 100;
        superior.classList.toggle(superior.id + '-scrolled', bajo);
        inferior.classList.toggle(inferior.id + '-scrolled', bajo);
    }

    window.addEventListener('load', alDesplazar);
    window.addEventListener('scroll', alDesplazar, { passive: true });
})();
