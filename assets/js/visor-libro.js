/* Visor de PDF con presentación de libro abierto. */

(function () {
    "use strict";

    var cfg = window.__documento;
    if (!cfg || !cfg.url || typeof pdfjsLib === 'undefined') return;

    pdfjsLib.GlobalWorkerOptions.workerSrc = cfg.worker;

    // ---- Elementos de la página ----
    var el = {
        raiz:       document.getElementById('libro'),
        hojas:      document.getElementById('libroHojas'),
        cargando:   document.getElementById('libroCargando'),
        anterior:   document.getElementById('libroAnterior'),
        siguiente:  document.getElementById('libroSiguiente'),
        indicador:  document.getElementById('libroIndicador'),
        menos:      document.getElementById('libroMenos'),
        mas:        document.getElementById('libroMas'),
        pantalla:   document.getElementById('libroPantalla'),
        minis:      document.getElementById('libroMinis'),
        buscar:     document.getElementById('libroBuscar'),
        resultados: document.getElementById('libroResultados')
    };
    if (!el.raiz || !el.hojas) return;

    // ---- Estado ----
    var pdf        = null;
    var totalPags  = 0;
    var pliegos    = [];
    var actual     = 0;
    var zoom       = 1;
    var textoPags  = [];
    var dobleVista = window.matchMedia('(min-width: 992px)').matches;

    function armarPliegos() {
        pliegos = [];
        if (!dobleVista) {
            for (var p = 1; p <= totalPags; p++) pliegos.push([p]);
            return;
        }
        pliegos.push([1]);                       // portada sola
        for (var i = 2; i <= totalPags; i += 2) {
            pliegos.push(i + 1 <= totalPags ? [i, i + 1] : [i]);
        }
    }

    function dibujar(numero, contenedor, altoObjetivo) {
        return pdf.getPage(numero).then(function (pagina) {
            var base    = pagina.getViewport({ scale: 1 });
            var escala  = (altoObjetivo / base.height) * zoom;
            var vista   = pagina.getViewport({ scale: escala });
            var ratio   = window.devicePixelRatio || 1;

            var canvas  = document.createElement('canvas');
            canvas.className = 'libro-pagina';
            canvas.width  = Math.floor(vista.width * ratio);
            canvas.height = Math.floor(vista.height * ratio);
            canvas.style.width  = Math.floor(vista.width) + 'px';
            canvas.style.height = Math.floor(vista.height) + 'px';

            var ctx = canvas.getContext('2d');
            ctx.scale(ratio, ratio);

            var envoltura = document.createElement('div');
            envoltura.className = 'libro-hoja';
            envoltura.appendChild(canvas);

            var folio = document.createElement('span');
            folio.className = 'libro-folio';
            folio.textContent = numero;
            envoltura.appendChild(folio);

            contenedor.appendChild(envoltura);

            return pagina.render({ canvasContext: ctx, viewport: vista }).promise;
        });
    }

    function mostrar(indice) {
        if (indice < 0 || indice >= pliegos.length) return;
        actual = indice;

        var alto = Math.max(360, Math.min(window.innerHeight * 0.72, 900));

        el.hojas.classList.add('cambiando');

        var nuevo = document.createElement('div');
        nuevo.className = 'libro-pliego' + (pliegos[actual].length === 2 ? ' doble' : '');

        var tareas = pliegos[actual].map(function (n) {
            return dibujar(n, nuevo, alto);
        });

        Promise.all(tareas).then(function () {
            el.hojas.textContent = '';
            el.hojas.appendChild(nuevo);
            el.hojas.classList.remove('cambiando');
            actualizarControles();
        });
    }

    function actualizarControles() {
        var pags = pliegos[actual];
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

    /* ------------------------------------------------------------------
       Miniaturas
       ------------------------------------------------------------------ */
    function armarMiniaturas() {
        for (var n = 1; n <= totalPags; n++) {
            (function (numero) {
                pdf.getPage(numero).then(function (pagina) {
                    var base   = pagina.getViewport({ scale: 1 });
                    var vista  = pagina.getViewport({ scale: 96 / base.height });
                    var canvas = document.createElement('canvas');
                    canvas.width  = vista.width;
                    canvas.height = vista.height;

                    pagina.render({
                        canvasContext: canvas.getContext('2d'),
                        viewport: vista
                    }).promise.then(function () {
                        var boton = document.createElement('button');
                        boton.type = 'button';
                        boton.className = 'libro-mini';
                        boton.dataset.pagina = numero;
                        boton.title = 'Página ' + numero;
                        boton.appendChild(canvas);

                        var etq = document.createElement('span');
                        etq.textContent = numero;
                        boton.appendChild(etq);

                        boton.addEventListener('click', function () {
                            irAPagina(numero);
                        });

                        var refs = el.minis.children;
                        var puesto = null;
                        for (var i = 0; i < refs.length; i++) {
                            if (+refs[i].dataset.pagina > numero) { puesto = refs[i]; break; }
                        }
                        el.minis.insertBefore(boton, puesto);
                        actualizarControles();
                    });
                });
            })(n);
        }
    }

    /* ------------------------------------------------------------------
       Búsqueda dentro del texto del documento.
       ------------------------------------------------------------------ */
    function extraerTexto() {
        var tareas = [];
        for (var n = 1; n <= totalPags; n++) {
            (function (numero) {
                tareas.push(
                    pdf.getPage(numero)
                       .then(function (p) { return p.getTextContent(); })
                       .then(function (c) {
                           textoPags[numero] = c.items.map(function (i) {
                               return i.str;
                           }).join(' ').toLowerCase();
                       })
                );
            })(n);
        }
        return Promise.all(tareas);
    }

    function buscar(termino) {
        termino = termino.trim().toLowerCase();
        el.resultados.textContent = '';

        if (termino.length < 3) {
            if (termino.length > 0) {
                el.resultados.textContent = 'Escribe al menos 3 letras';
            }
            return;
        }

        var encontradas = [];
        for (var n = 1; n <= totalPags; n++) {
            if (textoPags[n] && textoPags[n].indexOf(termino) !== -1) {
                encontradas.push(n);
            }
        }

        if (encontradas.length === 0) {
            el.resultados.textContent = 'Sin coincidencias';
            return;
        }

        var texto = document.createElement('span');
        texto.textContent = encontradas.length === 1
            ? 'Aparece en la página '
            : 'Aparece en las páginas ';
        el.resultados.appendChild(texto);

        encontradas.forEach(function (n, i) {
            var enlace = document.createElement('button');
            enlace.type = 'button';
            enlace.className = 'libro-salto';
            enlace.textContent = n;
            enlace.addEventListener('click', function () { irAPagina(n); });
            el.resultados.appendChild(enlace);
            if (i < encontradas.length - 1) {
                el.resultados.appendChild(document.createTextNode(', '));
            }
        });

        irAPagina(encontradas[0]);
    }

    /* ------------------------------------------------------------------
       Controles
       ------------------------------------------------------------------ */
    el.anterior.addEventListener('click', function () { mostrar(actual - 1); });
    el.siguiente.addEventListener('click', function () { mostrar(actual + 1); });

    el.mas.addEventListener('click', function () {
        zoom = Math.min(2, zoom + 0.2);
        mostrar(actual);
    });
    el.menos.addEventListener('click', function () {
        zoom = Math.max(0.6, zoom - 0.2);
        mostrar(actual);
    });

    if (el.pantalla) {
        if (!el.raiz.requestFullscreen && !el.raiz.webkitRequestFullscreen) {
            el.pantalla.hidden = true;
        } else {
            el.pantalla.addEventListener('click', function () {
                if (document.fullscreenElement || document.webkitFullscreenElement) {
                    (document.exitFullscreen || document.webkitExitFullscreen).call(document);
                } else {
                    (el.raiz.requestFullscreen || el.raiz.webkitRequestFullscreen).call(el.raiz);
                }
            });
            document.addEventListener('fullscreenchange', function () {
                var activo = !!document.fullscreenElement;
                el.raiz.classList.toggle('en-pantalla', activo);
                var i = el.pantalla.querySelector('i');
                if (i) i.className = activo ? 'bi bi-fullscreen-exit' : 'bi bi-arrows-fullscreen';
                mostrar(actual);
            });
        }
    }

    if (el.buscar) {
        var tiempo;
        el.buscar.addEventListener('input', function () {
            clearTimeout(tiempo);
            var v = this.value;
            tiempo = setTimeout(function () { buscar(v); }, 350);
        });
        el.buscar.addEventListener('keydown', function (ev) {
            if (ev.key === 'Enter') { ev.preventDefault(); buscar(this.value); }
        });
    }

    // Navegación con las flechas del teclado
    document.addEventListener('keydown', function (ev) {
        if (/^(INPUT|TEXTAREA|SELECT)$/.test(ev.target.tagName)) return;
        if (ev.key === 'ArrowLeft')  mostrar(actual - 1);
        if (ev.key === 'ArrowRight') mostrar(actual + 1);
    });

    // Al cambiar de tamaño se reagrupa
    var espera;
    window.addEventListener('resize', function () {
        clearTimeout(espera);
        espera = setTimeout(function () {
            var doble = window.matchMedia('(min-width: 992px)').matches;
            var pagVisible = pliegos.length ? pliegos[actual][0] : 1;
            if (doble !== dobleVista) {
                dobleVista = doble;
                armarPliegos();
                irAPagina(pagVisible);
            } else {
                mostrar(actual);
            }
        }, 250);
    });

    /* ------------------------------------------------------------------
       Arranque
       ------------------------------------------------------------------ */
    pdfjsLib.getDocument(cfg.url).promise.then(function (documento) {
        pdf       = documento;
        totalPags = pdf.numPages;

        armarPliegos();
        mostrar(0);
        armarMiniaturas();
        extraerTexto();

        el.cargando.hidden = true;
        el.raiz.classList.add('listo');
    }).catch(function (error) {
        console.error('No se pudo cargar el documento:', error);
        el.cargando.innerHTML = '';
        var aviso = document.createElement('p');
        aviso.className = 'libro-error';
        aviso.textContent = 'No se pudo cargar el documento. Puedes descargarlo con el botón de arriba.';
        el.cargando.appendChild(aviso);
    });
})();
