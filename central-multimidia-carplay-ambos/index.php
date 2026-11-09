<?php

require __DIR__ . '/../Config.php';

$pagina = require __DIR__ . '/../conteudo/central-multimidia-carplay.php';
$pagina['slug'] = 'central-multimidia-carplay-ambos';
$pagina['botao_flutuante'] = true;

require __DIR__ . '/../inc/layout-campanha.php';
