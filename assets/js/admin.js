/* Ayudas del panel de administración. */

(function () {
    "use strict";

    document.querySelectorAll('.form-eliminar').forEach(function (form) {
        form.addEventListener('submit', function (ev) {
            var nombre = form.dataset.nombre || 'este registro';
            var texto  = '¿Eliminar «' + nombre + '»?\n\n' +
                         'Esta acción no se puede deshacer.';
            if (!window.confirm(texto)) {
                ev.preventDefault();
            }
        });
    });
})();
