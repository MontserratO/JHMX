<?php defined('JH_APP') || exit('Acceso no permitido.'); ?>
<!-- Modal para ver un PDF. -->
<div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content pdf-modal">

            <div class="modal-header">
                <h2 class="modal-title" id="modalPdfLabel"></h2>
                <div class="pdf-modal-acciones">
                    <a href="#" id="pdfDescargar" class="libro-btn" download>
                        <i class="bi bi-download" aria-hidden="true"></i>
                        <span class="libro-btn-txt">Descargar</span>
                    </a>
                    <a href="#" id="pdfAparte" class="libro-btn" target="_blank" rel="noopener">
                        <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        <span class="libro-btn-txt">Abrir aparte</span>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
            </div>

            <div class="modal-body">
                <iframe id="pdfMarco" class="pdf-marco" title="Documento" src=""></iframe>

                <div class="pdf-movil">
                    <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                    <p>Para leerlo cómodamente desde un teléfono, ábrelo en tu lector de PDF.</p>
                    <a href="#" id="pdfMovilAbrir" class="btn-a" target="_blank" rel="noopener">
                        Abrir documento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
