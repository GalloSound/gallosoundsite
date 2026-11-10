<?php

require __DIR__ . '/../Config.php';

$pagina = require __DIR__ . '/../conteudo/central-multimidia.php';
$pagina['barra_visita'] = false;

require __DIR__ . '/../inc/layout-campanha.php';
