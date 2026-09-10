/*  Mapa interactivo de los municipios de San Luis Potosí. */

(function () {
    "use strict";

    var caja = document.getElementById('mapaCaja');
    if (!caja) return;

    var cargando = document.getElementById('mapaCargando');
    var imgBase  = caja.dataset.imgbase || '';

    var ficha = {
        img:    document.getElementById('fichaImagen'),
        nombre: document.getElementById('fichaNombre'),
        zona:   document.getElementById('fichaZona')
    };

    var cache = {};

    function mostrar(path) {
        var nombre = path.getAttribute('data-nombre') || '';
        var zona   = path.getAttribute('data-zona')   || '';
        var imagen = path.getAttribute('data-imagen') || '';

        ficha.nombre.textContent = nombre;
        ficha.zona.textContent   = zona;

        if (imagen) {
            var url = imgBase + encodeURIComponent(imagen);

            if (!cache[url]) {
                cache[url] = new Image();
                cache[url].src = url;
            }
            ficha.img.src = url;
            ficha.img.alt = 'Vista de ' + nombre;
        }
    }

    function activar(svg) {
        var municipios = svg.querySelectorAll('.municipio');

        municipios.forEach(function (path) {
            var nombre = path.getAttribute('data-nombre') || 'Municipio';

            path.setAttribute('tabindex', '0');
            path.setAttribute('role', 'button');
            path.setAttribute('aria-label', nombre);

            path.addEventListener('mouseenter', function () { mostrar(path); });
            path.addEventListener('focus',      function () { mostrar(path); });

            path.addEventListener('click', function () {
                svg.querySelectorAll('.municipio.activo').forEach(function (m) {
                    m.classList.remove('activo');
                });
                path.classList.add('activo');
                mostrar(path);
            });

            path.addEventListener('keydown', function (ev) {
                if (ev.key === 'Enter' || ev.key === ' ') {
                    ev.preventDefault();
                    path.click();
                }
            });
        });

        document.querySelectorAll('.leyenda-item').forEach(function (boton) {
            var zona = boton.dataset.zona;

            function marcar(estado) {
                svg.querySelectorAll('.municipio.' + zona).forEach(function (m) {
                    m.classList.toggle('resaltado', estado);
                });
                boton.classList.toggle('activo', estado);
            }

            boton.addEventListener('mouseenter', function () { marcar(true); });
            boton.addEventListener('mouseleave', function () { marcar(false); });
            boton.addEventListener('focus',      function () { marcar(true); });
            boton.addEventListener('blur',       function () { marcar(false); });
            boton.addEventListener('click', function () {
                marcar(!boton.classList.contains('activo'));
            });
        });
    }

    /* ---- Carga del mapa ---- */
    fetch(caja.dataset.svg)
        .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.text();
        })
        .then(function (texto) {
            var envoltura = document.createElement('div');
            envoltura.className = 'mapa-svg';
            envoltura.innerHTML = texto;

            var svg = envoltura.querySelector('svg');
            if (!svg) throw new Error('El archivo no contiene un SVG');

            svg.removeAttribute('width');
            svg.removeAttribute('height');
            svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
            svg.setAttribute('role', 'img');
            svg.setAttribute('aria-label', 'Mapa de los municipios de San Luis Potosí');

            if (cargando) cargando.remove();
            caja.appendChild(envoltura);
            activar(svg);
        })
        .catch(function (error) {
            console.error('No se pudo cargar el mapa:', error);
            if (cargando) {
                cargando.innerHTML = '';
                var p = document.createElement('p');
                p.className = 'libro-error';
                p.textContent = 'No se pudo cargar el mapa. Recarga la página para intentarlo de nuevo.';
                cargando.appendChild(p);
            }
        });
})();