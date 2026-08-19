/* navbars.js — Comportamiento de las barras fijas al hacer scroll.

   Al bajar más de 100px, la barra superior se oculta y la de abajo sube a
   ocupar su lugar, para ganar espacio de pantalla.

   Unifica los dos archivos viejos (funciones.js y funcionesP.js), que hacían
   lo mismo con distintas barras según la página:
     - Home:      se oculta nav-gob    y sube nav-colsan
     - Subpáginas: se oculta nav-colsan y sube nav-sistem

   Aquí se detectan solas: la primera barra presente es la que se oculta y
   la segunda la que sube. */

(function () {
    "use strict";

    // Orden de arriba hacia abajo, tal como aparecen en la página.
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
