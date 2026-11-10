<?php

require __DIR__ . '/../Config.php';

$pagina = require __DIR__ . '/../conteudo/central-multimidia.php';
$pagina['slug'] = 'central-multimidia-carplay-ambos';
$pagina['indexar'] = false;
$pagina['canonical_slug'] = 'central-multimidia';
$pagina['botao_flutuante'] = true;

require __DIR__ . '/../inc/layout-campanha.php';
