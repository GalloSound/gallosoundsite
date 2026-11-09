<?php

require __DIR__ . '/../Config.php';

$pagina = require __DIR__ . '/../conteudo/central-multimidia-carplay.php';
$pagina['slug'] = 'central-multimidia-carplay-botao';
$pagina['barra_visita'] = false;

require __DIR__ . '/../inc/layout-campanha.php';
