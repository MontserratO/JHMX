/*  Visor para ampliar mapas con mucho detalle. */

(function () {
    "use strict";

    var modal = document.getElementById('visorMapa');
    if (!modal) return;

    var titulo   = modal.querySelector('#visorMapaTitulo');
    var lienzo   = modal.querySelector('#mapaLienzo');
    var imagen   = modal.querySelector('#mapaAmpliado');
    var nivel    = modal.querySelector('#mapaNivel');
    var descarga = modal.querySelector('#mapaDescarga');
    var btnMas   = modal.querySelector('#mapaMas');
    var btnMenos = modal.querySelector('#mapaMenos');

    var escala = 1;
    var MIN = 0.5, MAX = 6;

    function aplicar() {
        imagen.style.transform = 'scale(' + escala + ')';
        nivel.textContent = Math.round(escala * 100) + '%';
        lienzo.classList.toggle('ampliado', escala > 1);
    }

    function acercar(paso, centro) {
        var previa = escala;
        escala = Math.min(MAX, Math.max(MIN, escala + paso));
        if (escala === previa) return;

        if (centro) {
            var factor = escala / previa;
            lienzo.scrollLeft = (lienzo.scrollLeft + centro.x) * factor - centro.x;
            lienzo.scrollTop  = (lienzo.scrollTop + centro.y) * factor - centro.y;
        }
        aplicar();
    }

    btnMas.addEventListener('click',   function () { acercar(0.4); });
    btnMenos.addEventListener('click', function () { acercar(-0.4); });

    lienzo.addEventListener('wheel', function (ev) {
        if (!ev.ctrlKey && Math.abs(ev.deltaY) < 4) return;
        ev.preventDefault();
        var caja = lienzo.getBoundingClientRect();
        acercar(ev.deltaY < 0 ? 0.3 : -0.3, {
            x: ev.clientX - caja.left,
            y: ev.clientY - caja.top
        });
    }, { passive: false });

    var arrastrando = false, xIni = 0, yIni = 0, sxIni = 0, syIni = 0;

    lienzo.addEventListener('pointerdown', function (ev) {
        if (escala <= 1) return;
        arrastrando = true;
        xIni = ev.clientX;  yIni = ev.clientY;
        sxIni = lienzo.scrollLeft;  syIni = lienzo.scrollTop;
        lienzo.setPointerCapture(ev.pointerId);
        lienzo.classList.add('arrastrando');
    });

    lienzo.addEventListener('pointermove', function (ev) {
        if (!arrastrando) return;
        lienzo.scrollLeft = sxIni - (ev.clientX - xIni);
        lienzo.scrollTop  = syIni - (ev.clientY - yIni);
    });

    ['pointerup', 'pointercancel'].forEach(function (evento) {
        lienzo.addEventListener(evento, function () {
            arrastrando = false;
            lienzo.classList.remove('arrastrando');
        });
    });

    modal.addEventListener('show.bs.modal', function (evento) {
        var b = evento.relatedTarget;
        if (!b) return;

        var src    = b.getAttribute('data-src') || '';
        var nombre = b.getAttribute('data-titulo') || 'Mapa';

        titulo.textContent = nombre;
        imagen.src = src;
        imagen.alt = nombre;
        descarga.href = src;

        escala = 1;
        aplicar();
    });

    modal.addEventListener('shown.bs.modal', function () {
        lienzo.scrollLeft = (lienzo.scrollWidth - lienzo.clientWidth) / 2;
        lienzo.scrollTop  = (lienzo.scrollHeight - lienzo.clientHeight) / 2;
    });

    modal.addEventListener('hidden.bs.modal', function () {
        imagen.removeAttribute('src');
    });
})();
