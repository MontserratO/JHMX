<?php

/**
 * Cierra la sesión del panel de administración.
 */

require_once __DIR__ . '/../app/bootstrap.php';

Auth::salir();
redirect(base_url('admin/login'));
