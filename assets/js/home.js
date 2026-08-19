(function () {
    "use strict";

    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var imgs = window.__portada || [];
    var header = document.getElementById('header');
    var overlay = document.getElementById('background-overlay');

    // Fondo rotativo del encabezado
    if (header && overlay && imgs.length > 1 && !reduce) {
        var i = 0;
        var grad = "linear-gradient(rgba(0,0,0,var(--opacidad-negro)), rgba(0,0,0,var(--opacidad-negro)))";

        setInterval(function () {
            i = (i + 1) % imgs.length;
            overlay.style.backgroundImage = grad + ", url('" + imgs[i] + "')";
            overlay.style.opacity = 1;

            setTimeout(function () {
                header.style.backgroundImage = grad + ", url('" + imgs[i] + "')";
                overlay.style.opacity = 0;
            }, 1000);
        }, 4000);
    }

    // Modal: al abrir una noticia, cargar su imagen en grande
    var modalImg = document.getElementById('modalImage');
    document.querySelectorAll('[data-img]').forEach(function (el) {
        el.addEventListener('click', function () {
            if (modalImg) modalImg.src = el.getAttribute('data-img');
        });
    });
})();