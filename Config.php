<?php

$baseUrl = getenv('APP_BASE_URL_GALLOSOUNDSITE');

if ($baseUrl === false || $baseUrl === '') {
    $baseUrl = 'http://localhost:8082/gallosoundsite/';
}

$rawHost = isset($_SERVER['HTTP_HOST']) ? strtolower(trim((string) $_SERVER['HTTP_HOST'])) : '';
$hostOnly = preg_replace('/:\d+$/', '', $rawHost);
$publicHosts = getenv('GALLOSOUND_PUBLIC_HOSTS');

if (is_string($hostOnly) && $hostOnly !== '' && preg_match('/^[a-z0-9.-]+$/', $hostOnly) && is_string($publicHosts)) {
    $allowed = preg_split('/[\s,]+/', strtolower($publicHosts));
    if (is_array($allowed) && in_array($hostOnly, $allowed, true)) {
        $scheme = (getenv('APP_ENV') === 'production') ? 'https' : 'http';
        $https = isset($_SERVER['HTTPS']) ? strtolower((string) $_SERVER['HTTPS']) : '';
        if ($https === 'on' || $https === '1') {
            $scheme = 'https';
        }
        $baseUrl = (getenv('APP_ENV') === 'production')
            ? 'https://' . $hostOnly
            : $scheme . '://' . $rawHost;
    }
}

define('BASE_URL', rtrim($baseUrl, '/'));
