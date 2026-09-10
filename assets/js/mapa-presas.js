/* Mapa de presas */

(function () {
    "use strict";

    var caja = document.getElementById('mapaCaja');
    if (!caja) return;

    var cargando = document.getElementById('mapaCargando');
    var SVG_NS   = 'http://www.w3.org/2000/svg';

    /* ------------------------------------------------------------------
       Ficha técnica
       ------------------------------------------------------------------ */
    var modal = document.getElementById('modalPresa');

    if (modal) {
        var visor    = modal.querySelector('#presaVisor');
        var panel    = modal.querySelector('#presaPanel');
        var alternar = modal.querySelector('#presaAlternar');
        var foto     = modal.querySelector('#presaImagen');

        function mostrarPanel(visible) {
            visor.classList.toggle('sin-panel', !visible);
            alternar.setAttribute('aria-expanded', visible ? 'true' : 'false');
            var i = alternar.querySelector('i');
            var t = alternar.querySelector('span');
            if (i) i.className = visible ? 'bi bi-eye-slash' : 'bi bi-eye';
            if (t) t.textContent = visible ? 'Ver foto' : 'Ver datos';
            alternar.title = visible
                ? 'Ocultar los datos para ver la fotografía'
                : 'Mostrar los datos de la presa';
        }

        alternar.addEventListener('click', function () {
            mostrarPanel(visor.classList.contains('sin-panel'));
        });

        foto.addEventListener('click', function () {
            mostrarPanel(visor.classList.contains('sin-panel'));
        });

        var elTitulo    = modal.querySelector('#presaTitulo');
        var elMunicipio = modal.querySelector('#presaMunicipio');
        var elImagen    = modal.querySelector('#presaImagen');
        var elSecciones = modal.querySelector('#presaSecciones');

        modal.addEventListener('show.bs.modal', function (evento) {
            var b = evento.relatedTarget;
            if (!b) return;

            var nombre = b.getAttribute('data-nombre') || 'Presa';
            elTitulo.textContent    = nombre;
            elMunicipio.textContent = b.getAttribute('data-municipio') || '';
            elMunicipio.hidden      = (elMunicipio.textContent === '');

            var imagen = b.getAttribute('data-imagen') || '';
            if (imagen) {
                elImagen.src = imagen;
                elImagen.alt = 'Fotografía de la presa ' + nombre;
                visor.classList.remove('sin-foto');
            } else {
                elImagen.removeAttribute('src');
                visor.classList.add('sin-foto');
            }

            mostrarPanel(true);

            elSecciones.textContent = '';

            var ficha;
            try {
                ficha = JSON.parse(b.getAttribute('data-ficha') || '{}');
            } catch (e) {
                ficha = {};
            }

            Object.keys(ficha).forEach(function (titulo) {
                var campos = ficha[titulo];

                var bloque = document.createElement('section');
                bloque.className = 'presa-bloque';

                var h = document.createElement('h3');
                h.textContent = titulo;
                bloque.appendChild(h);

                var lista = document.createElement('dl');
                lista.className = 'presa-datos';

                Object.keys(campos).forEach(function (etiqueta) {
                    var dt = document.createElement('dt');
                    dt.textContent = etiqueta;
                    var dd = document.createElement('dd');
                    dd.textContent = campos[etiqueta];
                    lista.appendChild(dt);
                    lista.appendChild(dd);
                });

                bloque.appendChild(lista);
                elSecciones.appendChild(bloque);
            });
        });
    }

    /* ------------------------------------------------------------------
       Puntos sobre el mapa
       ------------------------------------------------------------------ */
    function dibujarPuntos(svg) {
        var grupo = document.createElementNS(SVG_NS, 'g');
        grupo.setAttribute('class', 'capa-presas');

        document.querySelectorAll('.presa-chip').forEach(function (chip) {
            var x = parseFloat(chip.dataset.x);
            var y = parseFloat(chip.dataset.y);
            if (isNaN(x) || isNaN(y)) return;

            var num = chip.dataset.num || '';

            var marca = document.createElementNS(SVG_NS, 'g');
            marca.setAttribute('class', 'presa-marca');
            marca.setAttribute('tabindex', '0');
            marca.setAttribute('role', 'button');
            marca.setAttribute('aria-label', 'Presa ' + chip.dataset.nombre);

            var titulo = document.createElementNS(SVG_NS, 'title');
            titulo.textContent = num + '. ' + chip.dataset.nombre;
            marca.appendChild(titulo);

            var punto = document.createElementNS(SVG_NS, 'circle');
            punto.setAttribute('class', 'presa-punto');
            punto.setAttribute('cx', x);
            punto.setAttribute('cy', y);
            punto.setAttribute('r', 7);
            marca.appendChild(punto);

            var etiqueta = document.createElementNS(SVG_NS, 'text');
            etiqueta.setAttribute('class', 'presa-punto-num');
            etiqueta.setAttribute('x', x);
            etiqueta.setAttribute('y', y);
            etiqueta.setAttribute('text-anchor', 'middle');
            etiqueta.setAttribute('dominant-baseline', 'central');
            etiqueta.textContent = num;
            marca.appendChild(etiqueta);

            function abrir() { chip.click(); }

            marca.addEventListener('click', abrir);
            marca.addEventListener('keydown', function (ev) {
                if (ev.key === 'Enter' || ev.key === ' ') {
                    ev.preventDefault();
                    abrir();
                }
            });

            function resaltar(estado) {
                marca.classList.toggle('resaltada', estado);
                chip.classList.toggle('resaltado', estado);
            }
            marca.addEventListener('mouseenter', function () { resaltar(true); });
            marca.addEventListener('mouseleave', function () { resaltar(false); });
            marca.addEventListener('focus',      function () { resaltar(true); });
            marca.addEventListener('blur',       function () { resaltar(false); });
            chip.addEventListener('mouseenter',  function () { resaltar(true); });
            chip.addEventListener('mouseleave',  function () { resaltar(false); });
            chip.addEventListener('focus',       function () { resaltar(true); });
            chip.addEventListener('blur',        function () { resaltar(false); });

            grupo.appendChild(marca);
        });

        svg.appendChild(grupo);
    }

    /* ------------------------------------------------------------------
       Carga del mapa
       ------------------------------------------------------------------ */
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
            svg.setAttribute('aria-label', 'Mapa de las presas de San Luis Potosí');

            if (cargando) cargando.remove();
            caja.appendChild(envoltura);
            dibujarPuntos(svg);
        })
        .catch(function (error) {
            console.error('No se pudo cargar el mapa:', error);
            if (cargando) {
                cargando.innerHTML = '';
                var p = document.createElement('p');
                p.className = 'libro-error';
                p.textContent = 'No se pudo cargar el mapa. Puedes consultar las presas en la lista de abajo.';
                cargando.appendChild(p);
            }
        });
})();