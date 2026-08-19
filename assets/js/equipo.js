/* equipo.js — Rellena el modal único con los datos de la tarjeta pulsada.

   Se usa textContent (no innerHTML) al insertar los datos: aunque ya vienen
   escapados desde PHP, así el navegador nunca los interpreta como HTML. */

(function () {
    "use strict";

    var modal = document.getElementById('modalPersona');
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function (evento) {
        var tarjeta = evento.relatedTarget;
        if (!tarjeta) return;

        var nombre = tarjeta.getAttribute('data-nombre') || '';
        var cargo  = tarjeta.getAttribute('data-cargo') || '';
        var desc   = tarjeta.getAttribute('data-descripcion') || '';
        var foto   = tarjeta.getAttribute('data-foto') || '';

        modal.querySelector('#modalPersonaLabel').textContent = nombre;
        modal.querySelector('#modalPersonaCargo').textContent = cargo;
        modal.querySelector('#modalPersonaDesc').textContent  = desc;

        var img = modal.querySelector('#modalPersonaFoto');
        img.src = foto;
        img.alt = 'Fotografía de ' + nombre;

        // Si no hay cargo o descripción, se ocultan para no dejar huecos.
        modal.querySelector('#modalPersonaCargo').hidden = (cargo === '');
        modal.querySelector('#modalPersonaDesc').hidden  = (desc === '');
    });
})();
