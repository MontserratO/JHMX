/* Rellena las fichas completa del visualizador. */

(function () {
    "use strict";

    var modal = document.getElementById('modalRegistro');
    if (!modal) return;

    var elTitulo    = modal.querySelector('#modalRegistroLabel');
    var elPrincipal = modal.querySelector('#fichaPrincipal');
    var elPralLabel = modal.querySelector('#fichaPralLabel');
    var elPralTexto = modal.querySelector('#fichaPralTexto');
    var elDatos     = modal.querySelector('#fichaDatos');

    modal.addEventListener('show.bs.modal', function (evento) {
        var boton = evento.relatedTarget;
        if (!boton) return;

        var r;
        try {
            r = JSON.parse(boton.getAttribute('data-registro') || '{}');
        } catch (e) {
            r = {};
        }

        // --- Título ---
        elTitulo.textContent = r.titulo || 'Ficha completa';

        // --- Campo destacado (resumen / descripción) ---
        if (r.pral) {
            elPralLabel.textContent = r.pralLabel || '';
            elPralTexto.textContent = r.pral;
            elPrincipal.hidden = false;
        } else {
            elPrincipal.hidden = true;
        }

        // --- Resto de los datos, en formato compacto ---
        elDatos.textContent = '';
        var resto = r.resto || {};

        Object.keys(resto).forEach(function (etiqueta) {
            var item = document.createElement('div');
            item.className = 'ficha-dato';

            var lab = document.createElement('span');
            lab.className = 'ficha-dato-label';
            lab.textContent = etiqueta;

            var val = document.createElement('span');
            val.className = 'ficha-dato-valor';
            val.textContent = resto[etiqueta];

            item.appendChild(lab);
            item.appendChild(val);
            elDatos.appendChild(item);
        });
    });
})();