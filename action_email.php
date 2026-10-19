<?php

header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Sao_Paulo');

$response = [
    'envio' => false,
    'email' => false,
];

/**
 * @param mixed $value
 */
function sanitizeText($value, int $maxLength): string
{
    if (!is_string($value) && !is_numeric($value)) {
        return '';
    }

    $text = trim((string) $value);
    $text = str_replace(["\r", "\n"], ' ', $text);
    $text = strip_tags($text);

    if (function_exists('mb_substr')) {
        return mb_substr($text, 0, $maxLength, 'UTF-8');
    }

    return substr($text, 0, $maxLength);
}

/**
 * @return resource|false
 */
function smtpConnect(string $host, int $port, string $secure, int $timeout)
{
    $target = $host . ':' . $port;
    if ($secure === 'ssl') {
        $target = 'ssl://' . $target;
    }

    $errno = 0;
    $errstr = '';
    $socket = @stream_socket_client(
        $target,
        $errno,
        $errstr,
        $timeout,
        STREAM_CLIENT_CONNECT
    );

    if (!is_resource($socket)) {
        error_log('SMTP connect failed');
        return false;
    }

    stream_set_timeout($socket, $timeout);
    return $socket;
}

/**
 * @param resource $socket
 */
function smtpRead($socket): string
{
    $data = '';
    while (($line = fgets($socket, 515)) !== false) {
        $data .= $line;
        if (isset($line[3]) && $line[3] === ' ') {
            break;
        }
    }

    return $data;
}

/**
 * @param resource $socket
 */
function smtpCmd($socket, string $command, string $expectPrefix): bool
{
    fwrite($socket, $command . "\r\n");
    $response = smtpRead($socket);
    if (!str_starts_with($response, $expectPrefix)) {
        error_log('SMTP command rejected: ' . $expectPrefix);
        return false;
    }

    return true;
}

/**
 * @param string[] $recipients
 */
function smtpSend(
    string $host,
    int $port,
    string $secure,
    string $username,
    string $password,
    string $fromEmail,
    string $fromName,
    array $recipients,
    string $replyTo,
    string $subject,
    string $htmlBody
): bool {
    $timeout = 20;
    $socket = smtpConnect($host, $port, $secure, $timeout);
    if ($socket === false) {
        return false;
    }

    $ok = false;
    try {
        $greeting = smtpRead($socket);
        if (!str_starts_with($greeting, '220')) {
            error_log('SMTP greeting failed');
            return false;
        }

        if (!smtpCmd($socket, 'EHLO gallosound.com.br', '250')) {
            return false;
        }

        if ($secure === 'tls') {
            if (!smtpCmd($socket, 'STARTTLS', '220')) {
                return false;
            }
            if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                error_log('SMTP STARTTLS failed');
                return false;
            }
            if (!smtpCmd($socket, 'EHLO gallosound.com.br', '250')) {
                return false;
            }
        }

        if (!smtpCmd($socket, 'AUTH LOGIN', '334')) {
            return false;
        }
        if (!smtpCmd($socket, base64_encode($username), '334')) {
            return false;
        }
        if (!smtpCmd($socket, base64_encode($password), '235')) {
            return false;
        }

        if (!smtpCmd($socket, 'MAIL FROM:<' . $username . '>', '250')) {
            return false;
        }

        foreach ($recipients as $recipient) {
            if (!smtpCmd($socket, 'RCPT TO:<' . $recipient . '>', '250')) {
                return false;
            }
        }

        if (!smtpCmd($socket, 'DATA', '354')) {
            return false;
        }

        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $headers = [
            'Date: ' . date('r'),
            'From: ' . $fromName . ' <' . $fromEmail . '>',
            'To: ' . implode(', ', $recipients),
            'Reply-To: ' . $replyTo,
            'Message-ID: <' . bin2hex(random_bytes(16)) . '@gallosound.com.br>',
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
            'Subject: ' . $encodedSubject,
        ];

        $stuffedBody = str_replace("\n.", "\n..", $htmlBody);
        if (str_starts_with($stuffedBody, '.')) {
            $stuffedBody = '.' . $stuffedBody;
        }
        $data = implode("\r\n", $headers) . "\r\n\r\n" . $stuffedBody . "\r\n.";
        if (!smtpCmd($socket, $data, '250')) {
            return false;
        }

        smtpCmd($socket, 'QUIT', '221');
        $ok = true;
    } finally {
        fclose($socket);
    }

    return $ok;
}

$rawInput = file_get_contents('php://input');
$decodedInput = json_decode($rawInput, true);
$data = is_array($decodedInput) ? $decodedInput : $_POST;

$nome = sanitizeText($data['nome'] ?? '', 120);
$email = filter_var(isset($data['email']) ? trim((string) $data['email']) : '', FILTER_VALIDATE_EMAIL);
$whats = sanitizeText($data['whats'] ?? '', 40);
$mensagem = sanitizeText($data['mensagem'] ?? '', 4000);

if ($nome === '' || $mensagem === '' || $email === false) {
    echo json_encode($response);
    exit;
}

$response['email'] = true;

$smtpHost = trim((string) getenv('SMTP_HOST'));
$smtpUser = trim((string) getenv('SMTP_USERNAME'));
$smtpPass = (string) getenv('SMTP_PASSWORD');
$smtpSecure = strtolower(trim((string) getenv('SMTP_SECURE')));
$smtpPort = (int) getenv('SMTP_PORT');

if ($smtpHost === '' || $smtpUser === '' || $smtpPass === '') {
    error_log('SMTP env missing');
    echo json_encode($response);
    exit;
}

if ($smtpSecure === '') {
    $smtpSecure = 'tls';
}

if ($smtpPort < 1) {
    $smtpPort = $smtpSecure === 'ssl' ? 465 : 587;
}

if (!in_array($smtpSecure, ['tls', 'ssl'], true)) {
    error_log('SMTP secure invalid');
    echo json_encode($response);
    exit;
}

$fromEmail = 'contato@gallosound.com.br';
$fromName = 'Gallo Sound';
$recipients = [
    'contato@gallosound.com.br',
    'axrgallo@gmail.com',
];
$assunto = 'Formulario de Contato - Site Gallo Sound';

$ip = isset($_SERVER['REMOTE_ADDR']) ? sanitizeText($_SERVER['REMOTE_ADDR'], 45) : 'IP nao identificado';
$dia = date('d-m-Y');
$hora = date('H:i');

$nomeEsc = htmlspecialchars($nome, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$emailEsc = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$whatsEsc = htmlspecialchars($whats, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$mensagemEsc = nl2br(htmlspecialchars($mensagem, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
$ipEsc = htmlspecialchars($ip, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

$mensagemHtml = '<b>' . $assunto . '</b><br />'
    . '<b>Nome:</b> ' . $nomeEsc . '<br />'
    . '<b>E-mail:</b> ' . $emailEsc . '<br />'
    . '<b>WhatsApp:</b> ' . $whatsEsc . '<br />'
    . '<br /><b>Mensagem:</b><br />' . $mensagemEsc . '<br />'
    . '<hr>'
    . '<b>Informacoes Tecnicas</b><br />'
    . '<i>Dia</i>: ' . $dia . '<br />'
    . '<i>Hora</i>: ' . $hora . '<br />'
    . '<i>IP do remetente</i>: ' . $ipEsc . '<br />';

$response['envio'] = smtpSend(
    $smtpHost,
    $smtpPort,
    $smtpSecure,
    $smtpUser,
    $smtpPass,
    $fromEmail,
    $fromName,
    $recipients,
    $email,
    $assunto,
    $mensagemHtml
);

echo json_encode($response);
