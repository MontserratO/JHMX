/*  Modal único de la galería de recursos. */

(function () {
    "use strict";

    /* ------------------------------------------------------------------
       Portadas de los esquemas
       ------------------------------------------------------------------ */
    var portadas = document.querySelectorAll('.mosaico-portada[data-pdf]');

    if (portadas.length && window.VisorLibro) {
        if ('IntersectionObserver' in window) {
            var observador = new IntersectionObserver(function (entradas, obs) {
                entradas.forEach(function (entrada) {
                    if (!entrada.isIntersecting) return;
                    VisorLibro.portada(entrada.target, entrada.target.dataset.pdf);
                    obs.unobserve(entrada.target);
                });
            }, { rootMargin: '200px' });

            portadas.forEach(function (c) { observador.observe(c); });
        } else {
            portadas.forEach(function (c) { VisorLibro.portada(c, c.dataset.pdf); });
        }
    }

    /* ------------------------------------------------------------------
       Visor
       ------------------------------------------------------------------ */
    var modal = document.getElementById('visorRecurso');
    if (!modal) return;

    var cuerpo = modal.querySelector('#visorCuerpo');
    var pie    = modal.querySelector('#visorTitulo');

    modal.addEventListener('show.bs.modal', function (evento) {
        var boton = evento.relatedTarget;
        if (!boton) return;

        var clase  = boton.getAttribute('data-clase')  || 'imagen';
        var src    = boton.getAttribute('data-src')    || '';
        var nombre = (boton.getAttribute('data-titulo') || '').trim();

        cuerpo.textContent = '';
        modal.classList.remove('modo-imagen', 'modo-video', 'modo-libro');

        pie.textContent = nombre;
        pie.hidden = (nombre === '' || nombre.toLowerCase() === 'sin titulo'
                                    || nombre.toLowerCase() === 'sin título');

        if (clase === 'imagen') {
            modal.classList.add('modo-imagen');
            var img = document.createElement('img');
            img.className = 'visor-img';
            img.src = src;
            img.alt = nombre;
            cuerpo.appendChild(img);

        } else if (clase === 'video') {
            modal.classList.add('modo-video');
            var video = document.createElement('video');
            video.className = 'visor-video';
            video.controls = true;
            video.autoplay = true;
            video.preload  = 'metadata';
            var f = document.createElement('source');
            f.src  = src;
            f.type = 'video/mp4';
            video.appendChild(f);
            cuerpo.appendChild(video);

        } else {
            modal.classList.add('modo-libro');
            pie.hidden = true;
            var caja = document.createElement('div');
            cuerpo.appendChild(caja);

            if (window.VisorLibro) {
                VisorLibro.montar(caja, { url: src });
            }
        }
    });

    modal.addEventListener('hidden.bs.modal', function () {
        var video = cuerpo.querySelector('video');
        if (video) {
            video.pause();
            video.removeAttribute('src');
            video.load();
        }
        cuerpo.textContent = '';
    });
})();