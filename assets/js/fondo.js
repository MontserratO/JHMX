/* fondo.js — Fondo rotativo del encabezado. */

(function () {
    "use strict";

    var imgs    = window.__portada || [];
    var header  = document.getElementById('header');
    var overlay = document.getElementById('background-overlay');

    if (!header || imgs.length === 0) return;

    var grad = "linear-gradient(rgba(0,0,0,var(--opacidad-negro)), rgba(0,0,0,var(--opacidad-negro)))";

    // Primera imagen siempre visible, aunque no haya rotación.
    header.style.backgroundImage = grad + ", url('" + imgs[0] + "')";

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || imgs.length < 2 || !overlay) return;

    var i = 0;
    setInterval(function () {
        i = (i + 1) % imgs.length;
        overlay.style.backgroundImage = grad + ", url('" + imgs[i] + "')";
        overlay.style.opacity = 1;

        setTimeout(function () {
            header.style.backgroundImage = grad + ", url('" + imgs[i] + "')";
            overlay.style.opacity = 0;
        }, 1000);
    }, 5000);
})();