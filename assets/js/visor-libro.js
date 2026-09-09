/* Visor de PDF con presentación de libro abierto. */

window.VisorLibro = (function () {
    "use strict";

    var CDN_WORKER = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    function armarEstructura(raiz, opciones) {
        raiz.classList.add('libro');
        raiz.innerHTML =
            '<div class="libro-barra">' +
                '<div class="libro-buscador">' +
                    '<i class="bi bi-search" aria-hidden="true"></i>' +
                    '<input type="search" placeholder="Buscar en el documento…" ' +
                           'aria-label="Buscar en el documento">' +
                '</div>' +
                '<div class="libro-acciones">' +
                    '<a class="libro-btn js-descargar" download>' +
                        '<i class="bi bi-download" aria-hidden="true"></i>' +
                        '<span class="libro-btn-txt">Descargar</span></a>' +
                    '<a class="libro-btn js-aparte" target="_blank" rel="noopener">' +
                        '<i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>' +
                        '<span class="libro-btn-txt">Abrir aparte</span></a>' +
                    '<button type="button" class="libro-btn js-pantalla" title="Pantalla completa">' +
                        '<i class="bi bi-arrows-fullscreen" aria-hidden="true"></i></button>' +
                '</div>' +
            '</div>' +
            '<p class="libro-resultados" aria-live="polite"></p>' +
            '<div class="libro-escena">' +
                '<button type="button" class="libro-flecha izq js-anterior" aria-label="Página anterior">' +
                    '<i class="bi bi-chevron-left" aria-hidden="true"></i></button>' +
                '<div class="libro-hojas"></div>' +
                '<button type="button" class="libro-flecha der js-siguiente" aria-label="Página siguiente">' +
                    '<i class="bi bi-chevron-right" aria-hidden="true"></i></button>' +
                '<div class="libro-cargando">' +
                    '<div class="libro-spinner" aria-hidden="true"></div>' +
                    '<p>Preparando el documento…</p></div>' +
            '</div>' +
            '<div class="libro-pie">' +
                '<div class="libro-zoom">' +
                    '<button type="button" class="libro-btn js-menos" aria-label="Alejar">' +
                        '<i class="bi bi-zoom-out" aria-hidden="true"></i></button>' +
                    '<button type="button" class="libro-btn js-mas" aria-label="Acercar">' +
                        '<i class="bi bi-zoom-in" aria-hidden="true"></i></button>' +
                '</div>' +
                '<span class="libro-indicador" aria-live="polite"></span>' +
                '<span class="libro-ayuda">Usa ← → para pasar de página</span>' +
            '</div>' +
            '<div class="libro-minis" aria-label="Miniaturas de las páginas"></div>';

        var descarga = raiz.querySelector('.js-descargar');
        var aparte   = raiz.querySelector('.js-aparte');
        descarga.href = opciones.descarga || opciones.url;
        aparte.href   = opciones.url;
    }

    /** Monta el visor en el contenedor y carga el PDF. */
    function montar(raiz, opciones) {
        if (!raiz || typeof pdfjsLib === 'undefined') return;
        if (typeof opciones === 'string') opciones = { url: opciones };
        if (!opciones || !opciones.url) return;

        pdfjsLib.GlobalWorkerOptions.workerSrc = opciones.worker || CDN_WORKER;

        armarEstructura(raiz, opciones);

        var el = {
            hojas:      raiz.querySelector('.libro-hojas'),
            cargando:   raiz.querySelector('.libro-cargando'),
            anterior:   raiz.querySelector('.js-anterior'),
            siguiente:  raiz.querySelector('.js-siguiente'),
            indicador:  raiz.querySelector('.libro-indicador'),
            menos:      raiz.querySelector('.js-menos'),
            mas:        raiz.querySelector('.js-mas'),
            pantalla:   raiz.querySelector('.js-pantalla'),
            minis:      raiz.querySelector('.libro-minis'),
            buscar:     raiz.querySelector('.libro-buscador input'),
            resultados: raiz.querySelector('.libro-resultados')
        };

        var pdf = null, totalPags = 0, pliegos = [], actual = 0, zoom = 1;
        var textoPags = [];
        var dobleVista = window.matchMedia('(min-width: 992px)').matches;

        /* Agrupa por portada sola y luego de dos en dos. */
        function armarPliegos() {
            pliegos = [];
            if (!dobleVista) {
                for (var p = 1; p <= totalPags; p++) pliegos.push([p]);
                return;
            }
            pliegos.push([1]);
            for (var i = 2; i <= totalPags; i += 2) {
                pliegos.push(i + 1 <= totalPags ? [i, i + 1] : [i]);
            }
        }

        /* Dibuja una página. */
        function dibujar(numero, contenedor, altoObjetivo) {
            return pdf.getPage(numero).then(function (pagina) {
                var base   = pagina.getViewport({ scale: 1 });
                var vista  = pagina.getViewport({ scale: (altoObjetivo / base.height) * zoom });
                var ratio  = window.devicePixelRatio || 1;

                var canvas = document.createElement('canvas');
                canvas.className = 'libro-pagina';
                canvas.width  = Math.floor(vista.width * ratio);
                canvas.height = Math.floor(vista.height * ratio);
                canvas.style.width  = Math.floor(vista.width) + 'px';
                canvas.style.height = Math.floor(vista.height) + 'px';

                var ctx = canvas.getContext('2d');
                ctx.scale(ratio, ratio);

                var hoja = document.createElement('div');
                hoja.className = 'libro-hoja';
                hoja.appendChild(canvas);

                var folio = document.createElement('span');
                folio.className = 'libro-folio';
                folio.textContent = numero;
                hoja.appendChild(folio);

                contenedor.appendChild(hoja);
                return pagina.render({ canvasContext: ctx, viewport: vista }).promise;
            });
        }

        function mostrar(indice) {
            if (indice < 0 || indice >= pliegos.length) return;
            actual = indice;

            var alto = Math.max(340, Math.min(window.innerHeight * 0.66, 900));
            el.hojas.classList.add('cambiando');

            var nuevo = document.createElement('div');
            nuevo.className = 'libro-pliego' + (pliegos[actual].length === 2 ? ' doble' : '');

            Promise.all(pliegos[actual].map(function (n) {
                return dibujar(n, nuevo, alto);
            })).then(function () {
                el.hojas.textContent = '';
                el.hojas.appendChild(nuevo);
                el.hojas.classList.remove('cambiando');
                actualizar();
            });
        }

        function actualizar() {
            var pags = pliegos[actual] || [1];
            el.indicador.textContent = pags.length === 2
                ? pags[0] + '–' + pags[1] + ' de ' + totalPags
                : pags[0] + ' de ' + totalPags;

            el.anterior.disabled  = (actual === 0);
            el.siguiente.disabled = (actual === pliegos.length - 1);

            el.minis.querySelectorAll('.libro-mini').forEach(function (m) {
                m.classList.toggle('activa', pags.indexOf(+m.dataset.pagina) !== -1);
            });
        }

        function irAPagina(numero) {
            for (var i = 0; i < pliegos.length; i++) {
                if (pliegos[i].indexOf(numero) !== -1) { mostrar(i); return; }
            }
        }

        function armarMiniaturas() {
            for (var n = 1; n <= totalPags; n++) {
                (function (numero) {
                    pdf.getPage(numero).then(function (pagina) {
                        var base   = pagina.getViewport({ scale: 1 });
                        var vista  = pagina.getViewport({ scale: 86 / base.height });
                        var canvas = document.createElement('canvas');
                        canvas.width  = vista.width;
                        canvas.height = vista.height;

                        pagina.render({
                            canvasContext: canvas.getContext('2d'), viewport: vista
                        }).promise.then(function () {
                            var b = document.createElement('button');
                            b.type = 'button';
                            b.className = 'libro-mini';
                            b.dataset.pagina = numero;
                            b.title = 'Página ' + numero;
                            b.appendChild(canvas);

                            var etq = document.createElement('span');
                            etq.textContent = numero;
                            b.appendChild(etq);
                            b.addEventListener('click', function () { irAPagina(numero); });

                            var refs = el.minis.children, puesto = null;
                            for (var i = 0; i < refs.length; i++) {
                                if (+refs[i].dataset.pagina > numero) { puesto = refs[i]; break; }
                            }
                            el.minis.insertBefore(b, puesto);
                            actualizar();
                        });
                    });
                })(n);
            }
        }

        /* Búsqueda: se extrae el texto de todas las páginas una sola vez. */
        function extraerTexto() {
            var tareas = [];
            for (var n = 1; n <= totalPags; n++) {
                (function (numero) {
                    tareas.push(pdf.getPage(numero)
                        .then(function (p) { return p.getTextContent(); })
                        .then(function (c) {
                            textoPags[numero] = c.items.map(function (i) {
                                return i.str;
                            }).join(' ').toLowerCase();
                        }));
                })(n);
            }
            return Promise.all(tareas);
        }

        function buscar(termino) {
            termino = termino.trim().toLowerCase();
            el.resultados.textContent = '';

            if (termino.length < 3) {
                if (termino.length > 0) el.resultados.textContent = 'Escribe al menos 3 letras';
                return;
            }

            var hallazgos = [];
            for (var n = 1; n <= totalPags; n++) {
                if (textoPags[n] && textoPags[n].indexOf(termino) !== -1) hallazgos.push(n);
            }

            if (hallazgos.length === 0) {
                el.resultados.textContent = 'Sin coincidencias';
                return;
            }

            var txt = document.createElement('span');
            txt.textContent = hallazgos.length === 1
                ? 'Aparece en la página ' : 'Aparece en las páginas ';
            el.resultados.appendChild(txt);

            hallazgos.forEach(function (n, i) {
                var b = document.createElement('button');
                b.type = 'button';
                b.className = 'libro-salto';
                b.textContent = n;
                b.addEventListener('click', function () { irAPagina(n); });
                el.resultados.appendChild(b);
                if (i < hallazgos.length - 1) {
                    el.resultados.appendChild(document.createTextNode(', '));
                }
            });

            irAPagina(hallazgos[0]);
        }

        /* ---- Controles ---- */
        el.anterior.addEventListener('click', function () { mostrar(actual - 1); });
        el.siguiente.addEventListener('click', function () { mostrar(actual + 1); });
        el.mas.addEventListener('click', function () {
            zoom = Math.min(2, zoom + 0.2); mostrar(actual);
        });
        el.menos.addEventListener('click', function () {
            zoom = Math.max(0.6, zoom - 0.2); mostrar(actual);
        });

        if (!raiz.requestFullscreen && !raiz.webkitRequestFullscreen) {
            el.pantalla.hidden = true;
        } else {
            el.pantalla.addEventListener('click', function () {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    (raiz.requestFullscreen || raiz.webkitRequestFullscreen).call(raiz);
                }
            });
            document.addEventListener('fullscreenchange', function () {
                var activo = (document.fullscreenElement === raiz);
                raiz.classList.toggle('en-pantalla', activo);
                var i = el.pantalla.querySelector('i');
                if (i) i.className = activo ? 'bi bi-fullscreen-exit' : 'bi bi-arrows-fullscreen';
                if (pdf) mostrar(actual);
            });
        }

        var espera;
        el.buscar.addEventListener('input', function () {
            clearTimeout(espera);
            var v = this.value;
            espera = setTimeout(function () { buscar(v); }, 350);
        });

        function teclas(ev) {
            if (/^(INPUT|TEXTAREA|SELECT)$/.test(ev.target.tagName)) return;
            if (!raiz.isConnected) { document.removeEventListener('keydown', teclas); return; }
            if (ev.key === 'ArrowLeft')  mostrar(actual - 1);
            if (ev.key === 'ArrowRight') mostrar(actual + 1);
        }
        document.addEventListener('keydown', teclas);

        var reajuste;
        window.addEventListener('resize', function () {
            clearTimeout(reajuste);
            reajuste = setTimeout(function () {
                if (!pdf || !raiz.isConnected) return;
                var doble = window.matchMedia('(min-width: 992px)').matches;
                var visible = pliegos.length ? pliegos[actual][0] : 1;
                if (doble !== dobleVista) {
                    dobleVista = doble;
                    armarPliegos();
                    irAPagina(visible);
                } else {
                    mostrar(actual);
                }
            }, 250);
        });

        /* ---- Arranque ---- */
        pdfjsLib.getDocument(opciones.url).promise.then(function (doc) {
            pdf = doc;
            totalPags = pdf.numPages;
            armarPliegos();
            mostrar(0);
            armarMiniaturas();
            extraerTexto();
            el.cargando.hidden = true;
            raiz.classList.add('listo');
        }).catch(function (error) {
            console.error('No se pudo cargar el documento:', error);
            el.cargando.innerHTML = '';
            var p = document.createElement('p');
            p.className = 'libro-error';
            p.textContent = 'No se pudo cargar el documento. Puedes descargarlo con el botón de arriba.';
            el.cargando.appendChild(p);
        });
    }

    /**
     * Pone como portada la primera pagina del PDF
     */
    function portada(canvas, url) {
        if (typeof pdfjsLib === 'undefined') return;
        pdfjsLib.GlobalWorkerOptions.workerSrc = CDN_WORKER;

        pdfjsLib.getDocument(url).promise.then(function (pdf) {
            return pdf.getPage(1);
        }).then(function (pagina) {
            var base  = pagina.getViewport({ scale: 1 });
            var ancho = canvas.parentElement.clientWidth || 320;
            var vista = pagina.getViewport({ scale: ancho / base.width });

            canvas.width  = vista.width;
            canvas.height = vista.height;

            return pagina.render({
                canvasContext: canvas.getContext('2d'), viewport: vista
            }).promise;
        }).then(function () {
            canvas.classList.add('listo');
        }).catch(function () {  });
    }

    return { montar: montar, portada: portada };
})();