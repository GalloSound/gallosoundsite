<?php

header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Sao_Paulo');

$response = array(
    'envio' => false,
    'email' => false,
);

/**
 * Sanitiza um texto simples para evitar entradas inválidas.
 *
 * @param mixed $value
 * @param int $maxLength
 *
 * @return string
 */
function sanitizeText($value, $maxLength)
{
    if (!is_string($value) && !is_numeric($value)) {
        return '';
    }

    $text = trim((string) $value);
    $text = str_replace(array("\r", "\n"), ' ', $text);
    $text = strip_tags($text);

    if (function_exists('mb_substr')) {
        return mb_substr($text, 0, $maxLength, 'UTF-8');
    }

    return substr($text, 0, $maxLength);
}

$rawInput = file_get_contents('php://input');
$decodedInput = json_decode($rawInput, true);
$data = is_array($decodedInput) ? $decodedInput : $_POST;

$nome = sanitizeText(isset($data['nome']) ? $data['nome'] : '', 120);
$email = filter_var(isset($data['email']) ? trim((string) $data['email']) : '', FILTER_VALIDATE_EMAIL);
$whats = sanitizeText(isset($data['whats']) ? $data['whats'] : '', 40);
$mensagem = sanitizeText(isset($data['mensagem']) ? $data['mensagem'] : '', 4000);

if ($nome === '' || $mensagem === '' || $email === false) {
    echo json_encode($response);
    exit;
}

$emailSender = 'webmaster@gallosound.com.br';
$emailDestinatario = 'contato@gallosound.com.br, axrgallo@gmail.com';
$assunto = 'Formulario de Contato - Site Gallo Sound';

$quebraLinha = (PATH_SEPARATOR === ';') ? "\r\n" : "\n";
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

$headers = 'MIME-Version: 1.1' . $quebraLinha;
$headers .= 'Content-type: text/html; charset=UTF-8' . $quebraLinha;
$headers .= 'From: Gallo Sound <' . $emailSender . '>' . $quebraLinha;
$headers .= 'Reply-To: ' . $email . $quebraLinha;
$headers .= 'Return-Path: ' . $emailSender . $quebraLinha;
$headers .= 'X-Mailer: PHP/' . phpversion();

$enviado = @mail($emailDestinatario, $assunto, $mensagemHtml, $headers, '-f' . $emailSender);

if (!$enviado) {
    $enviado = @mail($emailDestinatario, $assunto, $mensagemHtml, $headers);
}

$response['email'] = true;
$response['envio'] = $enviado ? true : false;

echo json_encode($response);