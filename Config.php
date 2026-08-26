<?php

$baseUrl = getenv('APP_BASE_URL_GALLOSOUNDSITE');

if ($baseUrl === false || $baseUrl === '') {
    $baseUrl = 'http://localhost:8082/gallosoundsite/';
}

define('BASE_URL', rtrim($baseUrl, '/'));
