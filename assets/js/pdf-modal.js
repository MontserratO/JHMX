/*  Abre un PDF en el modal compartido. */

(function () {
    "use strict";

    var modal = document.getElementById('modalPdf');
    if (!modal) return;

    var titulo    = modal.querySelector('#modalPdfLabel');
    var marco     = modal.querySelector('#pdfMarco');
    var descargar = modal.querySelector('#pdfDescargar');
    var aparte    = modal.querySelector('#pdfAparte');
    var movil     = modal.querySelector('#pdfMovilAbrir');

    modal.addEventListener('show.bs.modal', function (evento) {
        var boton = evento.relatedTarget;
        if (!boton) return;

        var url    = boton.getAttribute('data-pdf') || '';
        var nombre = boton.getAttribute('data-titulo') || 'Documento';

        titulo.textContent = nombre;
        marco.title = nombre;
        marco.src   = url + '#view=FitH';

        descargar.href = url;
        aparte.href    = url;
        movil.href     = url;
    });

    // Al cerrar se descarga el documento de memoria
    modal.addEventListener('hidden.bs.modal', function () {
        marco.src = '';
    });
})();
