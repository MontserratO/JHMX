/*  Visor de mapas con capas de información. */

(function () {
    "use strict";

    var visor = document.querySelector('.sig-visor');
    if (!visor || typeof L === 'undefined') return;

    var BASE  = visor.dataset.base || '';
    var CAPAS = JSON.parse(visor.dataset.capas || '{}');

    var mapa = L.map('map', { scrollWheelZoom: true }).setView([22.85, -100.37], 7);

    /* ---- Mapas base ---- */
    var CLAVE = 'pvxCaDtZ8y4b6JOS2z7p';
    var atribucion = '<a href="https://www.maptiler.com/copyright/" target="_blank" rel="noopener">&copy; MapTiler</a> ' +
                     '<a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">&copy; OpenStreetMap</a>';

    var bases = {
        calles:   L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=' + CLAVE,
                              { attribution: atribucion, maxZoom: 18 }),
        satelite: L.tileLayer('https://api.maptiler.com/maps/hybrid/{z}/{x}/{y}.jpg?key=' + CLAVE,
                              { attribution: atribucion, maxZoom: 18 })
    };
    var baseActual = bases.calles.addTo(mapa);

    document.querySelectorAll('input[name="base"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            mapa.removeLayer(baseActual);
            baseActual = bases[this.value].addTo(mapa);
        });
    });

    L.control.scale({ imperial: false }).addTo(mapa);

    /* ------------------------------------------------------------------
       Estilos de capa
       ------------------------------------------------------------------ */
    function estilo(def) {
        return function (feature) {
            // Zonas administrativas
            if (def.tipo === 'zonas') {
                var zonas = ['#825a4e', '#f0cd7c', '#f6f479', '#5e8846'];
                var z = parseInt(feature.properties.Zona, 10);
                var color = zonas[z - 1] || '#999999';
                return { fillColor: color, color: color, weight: 1,
                         opacity: 0.5, fillOpacity: def.opacidad };
            }

            // Corrientes
            if (def.tipo === 'linea' && feature.properties && feature.properties.TIPO) {
                var c = (feature.properties.TIPO === 'Perenne') ? '#538add' : '#a9c6e8';
                return { color: c, weight: 1.4, opacity: 1, fillOpacity: 0 };
            }

            return {
                color: def.color || '#666666',
                fillColor: def.relleno || 'transparent',
                weight: def.tipo === 'contorno' ? 1.6 : 1,
                opacity: 0.95,
                fillOpacity: def.relleno ? def.opacidad : 0
            };
        };
    }

    /** Texto que aparece al pulsar un elemento. */
    function etiqueta(def) {
        return function (feature, capa) {
            var p = feature.properties || {};
            var texto = def.campo ? p[def.campo] : null;

            if (def.archivo === 'Acuiferos' && p.NOM_REGION) {
                texto = p.NOM_REGION + ' — ' + (p.NOM_ACUI || '');
            }
            if (def.archivo === 'Localidades' && p.AMBITO) {
                texto = p.AMBITO + ' — ' + (p.NOMGEO || '');
            }
            if (def.tipo === 'linea' && p.TIPO) {
                texto = 'Corriente ' + p.TIPO;
            }

            if (texto) {
                // bindPopup admite HTML: se escapa por si el dato lo trae
                var caja = document.createElement('div');
                caja.className = 'sig-popup';
                caja.textContent = texto;
                capa.bindPopup(caja);
            }
        };
    }

    /* ------------------------------------------------------------------
       Carga de capas
       ------------------------------------------------------------------ */
    var cargadas   = {};
    var encuadrado = false;

    function encender(clave, etiquetaEl) {
        var def = CAPAS[clave];
        if (!def) return;

        if (cargadas[clave]) {
            mapa.addLayer(cargadas[clave]);
            return;
        }

        etiquetaEl.classList.add('cargando');

        fetch(BASE + encodeURIComponent(def.archivo) + '.geojson')
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(function (datos) {
                var opciones = {
                    style: estilo(def),
                    onEachFeature: etiqueta(def)
                };

                if (def.tipo === 'punto') {
                    opciones.pointToLayer = function (feature, latlng) {
                        return L.circleMarker(latlng, {
                            radius: 5,
                            fillColor: def.relleno || '#a2eeff',
                            color: def.color || '#497f8a',
                            weight: 1,
                            opacity: 1,
                            fillOpacity: def.opacidad
                        });
                    };
                }

                var capa = L.geoJSON(datos, opciones);
                cargadas[clave] = capa;
                capa.addTo(mapa);

                if (def.tipo === 'contorno') capa.bringToBack();

                /* Encuadre */
                if (def.encuadre && !encuadrado) {
                    encuadrado = true;
                    try {
                        mapa.fitBounds(capa.getBounds(), { padding: [18, 18] });
                    } catch (e) {  }
                }

                etiquetaEl.classList.remove('cargando');
            })
            .catch(function (error) {
                console.error('No se pudo cargar la capa ' + clave + ':', error);
                etiquetaEl.classList.remove('cargando');
                etiquetaEl.classList.add('con-error');
                var casilla = etiquetaEl.querySelector('input');
                if (casilla) casilla.checked = false;
                etiquetaEl.title = 'No se pudo cargar esta capa';
            });
    }

    function apagar(clave) {
        if (cargadas[clave]) mapa.removeLayer(cargadas[clave]);
    }

    document.querySelectorAll('.sig-capa[data-capa] input').forEach(function (casilla) {
        var etiquetaEl = casilla.closest('.sig-capa');
        var clave = casilla.value;

        casilla.addEventListener('change', function () {
            if (this.checked) {
                encender(clave, etiquetaEl);
            } else {
                apagar(clave);
            }
        });

        if (casilla.checked) encender(clave, etiquetaEl);
    });

    /* ---- Panel plegable ---- */
    var toggle = document.getElementById('panelToggle');
    if (toggle) {
        toggle.addEventListener('click', function () {
            var oculto = visor.classList.toggle('panel-oculto');
            var i = toggle.querySelector('i');
            if (i) {
                i.className = oculto ? 'bi bi-layers-half' : 'bi bi-chevron-right';
            }
            toggle.title = oculto ? 'Mostrar el panel de capas'
                                  : 'Ocultar el panel de capas';
            toggle.setAttribute('aria-expanded', oculto ? 'false' : 'true');
            setTimeout(function () { mapa.invalidateSize(); }, 320);
        });
    }
})();