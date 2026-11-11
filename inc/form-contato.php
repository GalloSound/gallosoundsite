<?php

declare(strict_types=1);

/**
 * Validação do formulário público: conteúdo, honeypot, espera mínima e limite de envio.
 */

function form_contato_segredo(): string
{
    return hash('sha256', implode('|', [
        'gallosound-form-contato-v1',
        (string) getenv('SMTP_PASSWORD'),
        (string) getenv('APP_BASE_URL_GALLOSOUNDSITE'),
    ]));
}

function form_contato_token(?int $agora = null): string
{
    $agora = $agora ?? time();
    $assinatura = substr(hash_hmac('sha256', (string) $agora, form_contato_segredo()), 0, 32);

    return $agora . '.' . $assinatura;
}

function form_contato_token_valido(string $token, ?int $agora = null): string
{
    $agora = $agora ?? time();
    $partes = explode('.', $token, 2);
    if (count($partes) !== 2 || preg_match('/^[0-9]{10}$/', $partes[0]) !== 1 || preg_match('/^[a-f0-9]{32}$/', $partes[1]) !== 1) {
        return 'recarregue';
    }

    $emitido = (int) $partes[0];
    $esperado = substr(hash_hmac('sha256', (string) $emitido, form_contato_segredo()), 0, 32);
    if (!hash_equals($esperado, $partes[1])) {
        return 'recarregue';
    }

    if ($emitido > $agora + 30) {
        return 'recarregue';
    }

    $idade = $agora - $emitido;
    if ($idade < 2) {
        return 'aguarde';
    }

    if ($idade > 43200) {
        return 'recarregue';
    }

    return '';
}

function form_contato_html_oculto(): string
{
    $token = htmlspecialchars(form_contato_token(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $estilo = 'position:absolute;width:1px;height:1px;margin:0;padding:0;overflow:hidden;'
        . 'clip:rect(0 0 0 0);clip-path:inset(50%);white-space:nowrap;border:0;';

    return '<div aria-hidden="true" style="' . $estilo . '">'
        . '<label>gs<input type="text" name="gs_hp" tabindex="-1" autocomplete="off" value="" /></label>'
        . '</div>'
        . '<input type="hidden" id="formToken" name="form_token" value="' . $token . '" />';
}

function form_contato_html_erro(): string
{
    return '<p id="formErro" role="alert" style="display:none;margin:10px 0 0;color:#8f1d1d;font-size:14px;line-height:1.4;"></p>';
}

function form_contato_aviso(string $campo): string
{
    $avisos = [
        'nome' => 'Informe um nome com letras, como usamos no atendimento.',
        'email' => 'Informe um e-mail completo, de um endereço que você acessa.',
        'whats' => 'Informe um WhatsApp com DDD. Ex.: (11) 90000-0000.',
        'mensagem' => 'Escreva uma mensagem curta sobre o que você precisa.',
        'aguarde' => 'Aguarde alguns segundos e envie de novo.',
        'limite' => 'Recebemos vários envios deste acesso. Aguarde um pouco e tente de novo.',
        'recarregue' => 'Atualize a página e envie o formulário de novo.',
        'bloqueio' => 'Não foi possível enviar. Revise os dados e tente de novo.',
    ];

    return $avisos[$campo] ?? $avisos['bloqueio'];
}

/**
 * @param array<string, mixed> $dados
 * @param array{dns?: bool, limite?: bool, agora?: int} $opcoes
 * @return array{ok: bool, campo: string, aviso: string, nome: string, email: string, whats: string, mensagem: string}
 */
function form_contato_avaliar(array $dados, array $opcoes = []): array
{
    $agora = isset($opcoes['agora']) ? (int) $opcoes['agora'] : time();
    $checarDns = !array_key_exists('dns', $opcoes) || $opcoes['dns'] === true;
    $checarLimite = !array_key_exists('limite', $opcoes) || $opcoes['limite'] === true;

    if (array_key_exists('gs_hp', $dados)) {
        $isca = $dados['gs_hp'];
        if ((!is_string($isca) && !is_numeric($isca)) || trim((string) $isca) !== '') {
            return form_contato_recusa('bloqueio');
        }
    }

    $token = $dados['form_token'] ?? '';
    if (!is_string($token)) {
        return form_contato_recusa('recarregue');
    }

    $erroToken = form_contato_token_valido($token, $agora);
    if ($erroToken !== '') {
        return form_contato_recusa($erroToken);
    }

    $nome = form_contato_texto($dados['nome'] ?? '', 80, false);
    $nome = trim(preg_replace('/\s+/u', ' ', $nome) ?? '');
    $email = strtolower(form_contato_texto($dados['email'] ?? '', 160, false));
    $whats = form_contato_texto($dados['whats'] ?? '', 20, false);
    $mensagem = form_contato_texto($dados['mensagem'] ?? '', 2000, true);

    if (!form_contato_nome_valido($nome)) {
        return form_contato_recusa('nome');
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || !form_contato_email_estrutura($email)) {
        return form_contato_recusa('email');
    }

    if (!form_contato_whats_valido($whats)) {
        return form_contato_recusa('whats');
    }

    if (!form_contato_mensagem_valida($mensagem)) {
        return form_contato_recusa('mensagem');
    }

    if ($checarLimite && !form_contato_limite('ip:' . form_contato_ip(), 10, 3600)) {
        return form_contato_recusa('limite');
    }

    if ($checarLimite && !form_contato_limite('email:' . $email, 5, 3600)) {
        return form_contato_recusa('limite');
    }

    if ($checarDns && !form_contato_dominio_recebe($email)) {
        return form_contato_recusa('email');
    }

    return [
        'ok' => true,
        'campo' => '',
        'aviso' => '',
        'nome' => $nome,
        'email' => $email,
        'whats' => $whats,
        'mensagem' => $mensagem,
    ];
}

/**
 * @return array{ok: bool, campo: string, aviso: string, nome: string, email: string, whats: string, mensagem: string}
 */
function form_contato_recusa(string $campo): array
{
    return [
        'ok' => false,
        'campo' => $campo,
        'aviso' => form_contato_aviso($campo),
        'nome' => '',
        'email' => '',
        'whats' => '',
        'mensagem' => '',
    ];
}

function form_contato_texto(mixed $valor, int $maximo, bool $quebras): string
{
    if (!is_string($valor) && !is_numeric($valor)) {
        return '';
    }

    $texto = trim((string) $valor);
    $texto = str_replace(["\r\n", "\r"], ["\n", "\n"], $texto);
    if (!$quebras) {
        $texto = str_replace("\n", ' ', $texto);
    }

    $texto = strip_tags($texto);
    $texto = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $texto) ?? '';
    $texto = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $texto) ?? $texto;
    $texto = preg_replace('/[ \t]+/u', ' ', $texto) ?? $texto;
    if ($quebras) {
        $texto = preg_replace("/\n{3,}/", "\n\n", $texto) ?? $texto;
    }

    if (function_exists('mb_substr')) {
        return trim(mb_substr($texto, 0, $maximo, 'UTF-8'));
    }

    return trim(substr($texto, 0, $maximo));
}

function form_contato_tamanho(string $texto): int
{
    if (function_exists('mb_strlen')) {
        return mb_strlen($texto, 'UTF-8');
    }

    return strlen($texto);
}

function form_contato_sem_acento(string $texto): string
{
    if (function_exists('mb_strtolower')) {
        $texto = mb_strtolower($texto, 'UTF-8');
    } else {
        $texto = strtolower($texto);
    }

    return strtr($texto, [
        'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y',
    ]);
}

function form_contato_letras(string $texto): string
{
    $letras = preg_replace('/[^a-z]/', '', form_contato_sem_acento($texto));

    return is_string($letras) ? $letras : '';
}

function form_contato_aleatorio(string $texto): bool
{
    $letras = form_contato_letras($texto);
    $tamanho = strlen($letras);
    if ($tamanho < 4) {
        return false;
    }

    if (preg_match('/(.)\1{4,}/', $letras) === 1) {
        return true;
    }

    $teclas = ['qwertyuiop', 'asdfghjkl', 'zxcvbnm', 'poiuytrewq', 'lkjhgfdsa', 'mnbvcxz'];
    $limiteTecla = $tamanho - 3;
    for ($i = 0; $i < $limiteTecla; $i++) {
        $fatia = substr($letras, $i, 4);
        foreach ($teclas as $sequencia) {
            if (str_contains($sequencia, $fatia)) {
                return true;
            }
        }
    }

    if ($tamanho < 6) {
        return false;
    }

    if (preg_match('/[bcdfghjklmnpqrstvwxz]{5,}/', $letras) === 1) {
        return true;
    }

    $alfabeto = ['abcdefghijklmnopqrstuvwxyz', 'zyxwvutsrqponmlkjihgfedcba'];
    $limite = $tamanho - 4;
    for ($i = 0; $i < $limite; $i++) {
        $fatia = substr($letras, $i, 5);
        foreach ($alfabeto as $sequencia) {
            if (str_contains($sequencia, $fatia)) {
                return true;
            }
        }
    }

    $vogais = preg_match_all('/[aeiouy]/', $letras);
    if ($vogais === false) {
        return true;
    }

    $proporcao = $vogais / $tamanho;
    if ($tamanho >= 8 && $proporcao < 0.18) {
        return true;
    }

    if ($tamanho >= 12 && $proporcao > 0.92) {
        return true;
    }

    return $tamanho >= 8 && form_contato_bigrama_raro($letras);
}

function form_contato_bigrama_raro(string $letras): bool
{
    static $raras = null;
    if ($raras === null) {
        $lista = [
            'bq', 'bg', 'bj', 'bk', 'bv', 'bw', 'bx', 'bz',
            'cb', 'cf', 'cg', 'cj', 'cq', 'cv', 'cw', 'cx', 'cz',
            'dq', 'dx', 'dz', 'fq', 'fv', 'fx', 'fz', 'gq', 'gv', 'gx', 'gz',
            'hj', 'hk', 'hv', 'hx', 'hz', 'jb', 'jd', 'jf', 'jg', 'jh', 'jk',
            'jl', 'jm', 'jp', 'jq', 'jr', 'jt', 'jv', 'jw', 'jx', 'jz',
            'kb', 'kd', 'kf', 'kj', 'kq', 'kv', 'kx', 'kz',
            'lq', 'lx', 'lz', 'mq', 'mx', 'mz', 'pq', 'pv', 'px', 'pz',
            'qa', 'qb', 'qc', 'qd', 'qe', 'qf', 'qg', 'qh', 'qi', 'qj', 'qk',
            'ql', 'qm', 'qn', 'qo', 'qp', 'qq', 'qr', 'qs', 'qt', 'qv', 'qw',
            'qx', 'qy', 'qz',
            'tq', 'tv', 'tx', 'tz', 'vb', 'vf', 'vj', 'vk', 'vq', 'vx', 'vz',
            'wq', 'wv', 'wx', 'wz', 'xb', 'xc', 'xd', 'xf', 'xg', 'xh', 'xj',
            'xk', 'xl', 'xm', 'xn', 'xp', 'xq', 'xr', 'xs', 'xu', 'xv', 'xw',
            'xz', 'yq', 'yx', 'yz', 'zb', 'zc', 'zd', 'zf', 'zg', 'zh', 'zj',
            'zk', 'zl', 'zm', 'zn', 'zp', 'zq', 'zr', 'zs', 'zt', 'zv', 'zw',
            'zx', 'jj', 'kk', 'qq', 'vv', 'ww', 'xx', 'yy', 'zz',
        ];
        $raras = array_fill_keys($lista, true);
    }

    $achou = 0;
    $limite = strlen($letras) - 1;
    for ($i = 0; $i < $limite; $i++) {
        if (isset($raras[substr($letras, $i, 2)])) {
            $achou++;
        }
    }

    if ($achou >= 2) {
        return true;
    }

    if ($achou < 1 || strlen($letras) < 10) {
        return false;
    }

    $vogais = preg_match_all('/[aeiouy]/', $letras);
    if ($vogais === false) {
        return true;
    }

    return ($vogais / strlen($letras)) < 0.34;
}

function form_contato_caixa_aleatoria(string $texto): bool
{
    $letras = preg_replace('/[^\p{L}]/u', '', $texto);
    if (!is_string($letras) || !function_exists('mb_strlen') || !function_exists('mb_substr')) {
        return false;
    }

    $tamanho = mb_strlen($letras, 'UTF-8');
    if ($tamanho < 5) {
        return false;
    }

    $anterior = null;
    $trocas = 0;
    for ($i = 0; $i < $tamanho; $i++) {
        $char = mb_substr($letras, $i, 1, 'UTF-8');
        $maiuscula = mb_strtoupper($char, 'UTF-8') === $char && mb_strtolower($char, 'UTF-8') !== $char;
        if ($anterior !== null && $anterior !== $maiuscula) {
            $trocas++;
        }
        $anterior = $maiuscula;
    }

    return $trocas >= 4 && ($trocas / $tamanho) > 0.55;
}

function form_contato_nome_valido(string $nome): bool
{
    $tamanho = form_contato_tamanho($nome);
    if ($tamanho < 3 || $tamanho > 80) {
        return false;
    }

    if (preg_match("/^[\p{L}]+(?:[ '\-][\p{L}]+)*$/u", $nome) !== 1) {
        return false;
    }

    $palavras = preg_split('/\s+/', $nome);
    if ($palavras === false || count($palavras) > 8) {
        return false;
    }

    if (form_contato_caixa_aleatoria($nome)) {
        return false;
    }

    $letras = form_contato_letras($nome);
    if (strlen($letras) < 3 || preg_match('/[aeiouy]/', $letras) !== 1) {
        return false;
    }

    foreach ($palavras as $palavra) {
        if (form_contato_aleatorio($palavra)) {
            return false;
        }
    }

    return true;
}

function form_contato_email_estrutura(string $email): bool
{
    $partes = explode('@', $email, 2);
    if (count($partes) !== 2) {
        return false;
    }

    [$local, $dominio] = $partes;
    if ($local === '' || strlen($local) > 64 || $dominio === '' || strlen($dominio) > 253) {
        return false;
    }

    if (form_contato_email_local_ruim($local) || form_contato_dominio_bloqueado($dominio)) {
        return false;
    }

    if (preg_match('/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+$/', $dominio) !== 1) {
        return false;
    }

    $rotulos = explode('.', $dominio);
    $tld = $rotulos[count($rotulos) - 1];

    return preg_match('/^[a-z]{2,24}$/', $tld) === 1;
}

function form_contato_email_local_ruim(string $local): bool
{
    $mais = strpos($local, '+');
    if ($mais !== false) {
        $local = substr($local, 0, $mais);
    }

    if ($local === '' || preg_match('/^[a-z0-9](?:[a-z0-9._-]*[a-z0-9])?$/', $local) !== 1) {
        return true;
    }

    $letras = form_contato_letras($local);
    if (strlen($letras) < 2) {
        $digitos = preg_replace('/\D/', '', $local) ?? '';

        return strlen($digitos) < 3 || strlen($digitos) > 15;
    }

    if (form_contato_aleatorio($letras)) {
        return true;
    }

    $pedacos = preg_split('/[._-]+/', $local);
    if ($pedacos === false) {
        return true;
    }

    foreach ($pedacos as $pedaco) {
        if ($pedaco === '' || form_contato_aleatorio($pedaco)) {
            return true;
        }
    }

    return false;
}

function form_contato_dominio_bloqueado(string $dominio): bool
{
    if (form_contato_descartavel($dominio)) {
        return true;
    }

    $rotulos = explode('.', $dominio);
    $total = count($rotulos);
    if ($total > 2 && form_contato_descartavel(implode('.', array_slice($rotulos, -2)))) {
        return true;
    }

    return $total > 3 && form_contato_descartavel(implode('.', array_slice($rotulos, -3)));
}

function form_contato_descartavel(string $dominio): bool
{
    static $mapa = null;
    if ($mapa === null) {
        $lista = [
            'mailinator.com', 'mailinator.net', 'mailinator.org', 'mailinator2.com', 'mailinater.com',
            'guerrillamail.com', 'guerrillamail.info', 'guerrillamail.net', 'guerrillamail.org',
            'guerrillamail.biz', 'guerrillamail.de', 'guerrillamailblock.com', 'sharklasers.com',
            'grr.la', 'spam4.me', 'yopmail.com', 'yopmail.fr', 'yopmail.net', 'tempmail.com',
            'temp-mail.org', 'temp-mail.io', 'tempmailo.com', 'tempr.email', 'tempail.com',
            'tempinbox.com', '10minutemail.com', '10minutemail.net', 'minuteinbox.com',
            'trashmail.com', 'trashmail.de', 'trashmail.me', 'trash-mail.com', 'trashmail.org',
            'getnada.com', 'dropmail.me', 'maildrop.cc', 'mailnesia.com', 'fakemail.net',
            'emailfake.com', 'generator.email', 'fakeinbox.com', 'dispostable.com',
            'throwawaymail.com', 'mohmal.com', 'emailondeck.com', 'mytemp.email', 'discard.email',
            'mailcatch.com', 'spamgourmet.com', 'emailtemporario.com.br', 'temporarioemail.com.br',
            'burnermail.io', 'mailnull.com', 'mailforspam.com', 'tmpmail.org', 'tmpmail.net',
            'inboxkitten.com', 'getairmail.com', 'moakt.com', 'mintemail.com', 'luxusmail.org',
            'mail-temporaire.fr', 'pokemail.net', 'example.com', 'example.org', 'example.net',
            'test.com', 'localhost',
        ];
        $mapa = array_fill_keys($lista, true);
    }

    return isset($mapa[$dominio]);
}

function form_contato_dominio_recebe(string $email): bool
{
    $dominio = explode('@', $email, 2)[1] ?? '';
    if ($dominio === '' || !function_exists('dns_get_record')) {
        return true;
    }

    $mx = @dns_get_record($dominio, DNS_MX);
    if (is_array($mx) && $mx !== []) {
        return true;
    }

    if ($mx === false) {
        return true;
    }

    $endereco = @dns_get_record($dominio, DNS_A);
    if (is_array($endereco) && $endereco !== []) {
        return true;
    }

    if ($endereco === false) {
        return true;
    }

    $ipv6 = @dns_get_record($dominio, DNS_AAAA);
    if ($ipv6 === false) {
        return true;
    }

    return $ipv6 !== [];
}

function form_contato_whats_valido(string $whats): bool
{
    if ($whats === '') {
        return true;
    }

    $digitos = preg_replace('/\D+/', '', $whats) ?? '';
    if (str_starts_with($digitos, '55') && strlen($digitos) >= 12) {
        $digitos = substr($digitos, 2);
    }

    if (str_starts_with($digitos, '0')) {
        $digitos = substr($digitos, 1);
    }

    if (preg_match('/^[1-9]{2}(?:9[0-9]{8}|[2-5][0-9]{7})$/', $digitos) !== 1) {
        return false;
    }

    if (preg_match('/^(\d)\1+$/', $digitos) === 1 || preg_match('/(\d)\1{6,}/', $digitos) === 1) {
        return false;
    }

    return true;
}

function form_contato_mensagem_valida(string $mensagem): bool
{
    if (form_contato_tamanho($mensagem) < 3 || form_contato_tamanho($mensagem) > 2000) {
        return false;
    }

    $semLink = preg_replace('/https?:\/\/\S+|www\.\S+/i', ' ', $mensagem) ?? $mensagem;
    $letras = form_contato_letras($semLink);
    if (strlen($letras) < 2) {
        return false;
    }

    $base = form_contato_sem_acento($mensagem);
    $palavras = preg_split('/\s+/', trim($base));
    if ($palavras === false) {
        return false;
    }

    $ruins = 0;
    $analisadas = 0;
    foreach ($palavras as $palavra) {
        $soLetras = form_contato_letras($palavra);
        if (strlen($soLetras) < 8) {
            continue;
        }

        $analisadas++;
        if (form_contato_aleatorio($soLetras)) {
            $ruins++;
        }
    }

    if ($ruins >= 1 && $ruins === $analisadas && count($palavras) <= 2) {
        return false;
    }

    return $ruins < 2;
}

function form_contato_ip(): string
{
    $remoto = isset($_SERVER['REMOTE_ADDR']) ? trim((string) $_SERVER['REMOTE_ADDR']) : '';
    $remotoValido = filter_var($remoto, FILTER_VALIDATE_IP) !== false;
    if ($remotoValido && form_contato_ip_privado($remoto)) {
        $encaminhado = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? (string) $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
        $escolhido = '';
        foreach (explode(',', $encaminhado) as $parte) {
            $candidato = trim($parte);
            if (filter_var($candidato, FILTER_VALIDATE_IP) !== false && !form_contato_ip_privado($candidato)) {
                $escolhido = $candidato;
            }
        }

        if ($escolhido !== '') {
            return $escolhido;
        }

        if (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $real = trim((string) $_SERVER['HTTP_X_REAL_IP']);
            if (filter_var($real, FILTER_VALIDATE_IP) !== false) {
                return $real;
            }
        }
    }

    return $remotoValido ? $remoto : '0.0.0.0';
}

function form_contato_ip_privado(string $ip): bool
{
    return filter_var(
        $ip,
        FILTER_VALIDATE_IP,
        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
    ) === false;
}

function form_contato_limite(string $chave, int $maximo, int $janela): bool
{
    $dir = sys_get_temp_dir() . '/gallosound-form';
    if (!is_dir($dir) && !@mkdir($dir, 0700, true) && !is_dir($dir)) {
        return true;
    }

    $arquivo = $dir . '/' . hash('sha256', $chave) . '.json';
    $ponteiro = @fopen($arquivo, 'c+');
    if ($ponteiro === false) {
        return true;
    }

    $liberado = true;
    try {
        if (!flock($ponteiro, LOCK_EX)) {
            return true;
        }

        $bruto = stream_get_contents($ponteiro);
        $lista = json_decode(is_string($bruto) ? $bruto : '', true);
        $agora = time();
        $recentes = [];
        if (is_array($lista)) {
            foreach ($lista as $item) {
                if (is_int($item) && ($agora - $item) < $janela) {
                    $recentes[] = $item;
                }
            }
        }

        if (count($recentes) >= $maximo) {
            $liberado = false;
        } else {
            $recentes[] = $agora;
        }

        rewind($ponteiro);
        ftruncate($ponteiro, 0);
        fwrite($ponteiro, json_encode($recentes) ?: '[]');
        fflush($ponteiro);
    } finally {
        flock($ponteiro, LOCK_UN);
        fclose($ponteiro);
    }

    return $liberado;
}
