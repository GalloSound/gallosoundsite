<?php

if (!defined('BASE_URL') || !isset($pagina) || !is_array($pagina)) {
    http_response_code(500);
    echo 'Página indisponível.';
    return;
}

if (!function_exists('campanha_e')) {
    function campanha_e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('campanha_asset')) {
    function campanha_asset(mixed $path): string
    {
        $path = trim((string) ($path ?? ''));
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return campanha_e($path);
        }

        return campanha_e(BASE_URL . '/' . ltrim($path, '/'));
    }
}

if (!function_exists('campanha_lista')) {
    function campanha_lista(mixed $valor): array
    {
        return is_array($valor) ? $valor : [];
    }
}

if (!function_exists('campanha_id')) {
    function campanha_id(mixed $id): string
    {
        $id = (string) ($id ?? '');
        if (preg_match('/^[a-z0-9-]{1,40}$/', $id) !== 1) {
            return '';
        }

        return $id;
    }
}

if (!function_exists('campanha_video_id')) {
    function campanha_video_id(mixed $id): string
    {
        $id = (string) ($id ?? '');
        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $id) !== 1) {
            return '';
        }

        return $id;
    }
}

if (!function_exists('campanha_whatsapp')) {
    function campanha_whatsapp(string $texto, string $classe = ''): void
    {
        $texto = trim($texto);
        if ($texto === '') {
            return;
        }

        $classes = trim('btn btn-wa btnWhatsApp ' . $classe);
        echo '<a href="#" class="' . campanha_e($classes) . '">' . campanha_e($texto) . '</a>';
    }
}

if (!function_exists('campanha_orcamento')) {
    function campanha_orcamento(string $texto, string $classe = ''): void
    {
        $texto = trim($texto);
        if ($texto === '') {
            return;
        }

        $classes = trim('btn btn-ghost btnWhatsApp ' . $classe);
        echo '<a href="#" class="' . campanha_e($classes) . '">' . campanha_e($texto) . '</a>';
    }
}

$slug = trim((string) ($pagina['slug'] ?? ''), '/');
$paginaUrl = campanha_e(BASE_URL . '/' . rawurlencode($slug) . '/');
$indexar = (bool) ($pagina['indexar'] ?? true);
$canonicalSlug = trim((string) ($pagina['canonical_slug'] ?? $slug), '/');
if ($canonicalSlug === '') {
    $canonicalSlug = $slug;
}
$canonicalUrl = campanha_e(BASE_URL . '/' . rawurlencode($canonicalSlug) . '/');
$robots = $indexar ? 'index, follow' : 'noindex, follow';
$barraVisita = ($pagina['barra_visita'] ?? true) !== false;
$botaoFlutuante = ($pagina['botao_flutuante'] ?? false) === true;
$classeCorpo = 'campanha';
if (!$barraVisita) {
    $classeCorpo .= ' sem-barra';
}
if ($botaoFlutuante) {
    $classeCorpo .= ' com-botao';
}
$base = campanha_e(BASE_URL);
$og = campanha_lista($pagina['og'] ?? null);
$hero = campanha_lista($pagina['hero'] ?? null);
$heroSrc = campanha_asset($hero['imagem'] ?? '');
$botoes = campanha_lista($pagina['botoes'] ?? null);
$textoWhatsapp = (string) ($botoes['whatsapp'] ?? '');
$textoHeader = (string) ($botoes['whatsapp_header'] ?? '');
$textoBarra = (string) ($botoes['whatsapp_barra'] ?? '');
$textoOrcamento = (string) ($botoes['orcamento'] ?? '');
$textoEnviar = (string) ($botoes['enviar'] ?? '');
$textoTopo = (string) ($botoes['topo'] ?? '');
$textoFlutuante = (string) ($botoes['flutuante'] ?? '');
$menu = campanha_lista($pagina['menu'] ?? null);
$chips = campanha_lista($pagina['chips'] ?? null);
$diferenca = campanha_lista($pagina['diferenca'] ?? null);
$comparar = campanha_lista($pagina['comparar'] ?? null);
$recursos = campanha_lista($pagina['recursos'] ?? null);
$videos = campanha_lista($pagina['videos'] ?? null);
$trabalhos = campanha_lista($pagina['trabalhos'] ?? null);
$duvidas = campanha_lista($pagina['duvidas'] ?? null);
$sobre = campanha_lista($pagina['sobre'] ?? null);
$depoimentos = campanha_lista($pagina['depoimentos'] ?? null);
$contato = campanha_lista($pagina['contato'] ?? null);
$mapa = (string) ($contato['mapa'] ?? '');
$mapaOk = preg_match('#^https://www\.google\.com/maps/embed\?#', $mapa) === 1;

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'AutomotiveBusiness',
    'name' => 'Gallo Sound',
    'url' => BASE_URL . '/',
    'image' => BASE_URL . '/' . ltrim((string) ($og['image'] ?? ''), '/'),
    'telephone' => ['+551133792892', '+5511947574606'],
    'foundingDate' => '1957',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'Rua Barão do Rio Branco, 357',
        'addressLocality' => 'Jundiaí',
        'addressRegion' => 'SP',
        'addressCountry' => 'BR',
    ],
    'openingHoursSpecification' => [
        [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '08:30',
            'closes' => '18:00',
        ],
        [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => 'Saturday',
            'opens' => '08:30',
            'closes' => '12:30',
        ],
    ],
];
$schemaJson = json_encode(
    $schema,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <title><?= campanha_e($pagina['title'] ?? '') ?></title>
    <meta name="description" content="<?= campanha_e($pagina['description'] ?? '') ?>" />
    <meta name="author" content="Alex Gallo" />
    <meta name="robots" content="<?= campanha_e($robots) ?>" />
    <meta name="theme-color" content="#fffcf8" />
    <link rel="canonical" href="<?= $canonicalUrl ?>" />
    <meta property="og:url" content="<?= $paginaUrl ?>" />
    <meta property="og:title" content="<?= campanha_e($og['title'] ?? '') ?>" />
    <meta property="og:type" content="<?= campanha_e($og['type'] ?? 'website') ?>" />
    <meta property="og:description" content="<?= campanha_e($og['description'] ?? '') ?>" />
    <meta property="og:image" content="<?= campanha_asset($og['image'] ?? '') ?>" />
    <meta property="og:locale" content="pt_BR" />
    <?php if ($schemaJson !== false) : ?>
        <script type="application/ld+json"><?= $schemaJson ?></script>
    <?php endif; ?>
    <link rel="preconnect" href="https://www.googletagmanager.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/montserrat/v14/JTUSjIg1_i6t8kCHKm459WlhyyTh89Y.woff2" crossorigin />
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/montserrat/v14/JTURjIg1_i6t8kCHKm45_dJE3gnD_vx3rCs.woff2" crossorigin />
    <?php if ($heroSrc !== '') : ?>
        <link rel="preload" as="image" href="<?= $heroSrc ?>" />
    <?php endif; ?>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-1011588590"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'AW-1011588590');
        gtag('config', 'G-1ZGQL4TMP7');
        gtag('config', 'UA-27874578-1');
    </script>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []; w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            }); var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NJT4VVG4');</script>
    <!-- End Google Tag Manager -->

    <script>
        // tag conversão de cliques WhatsApp
        function gtag_report_conversion(url) {
            var ua = navigator.userAgent || '';
            var iOS = /iPad|iPhone|iPod/.test(ua) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
            var iosSafari = iOS && !/CriOS|FxiOS|EdgiOS|OPiOS/.test(ua);

            // Safari cancela window.open fora do toque. No iPhone a navegação
            // precisa ser na mesma aba, via wa.me, para o app abrir.
            if (iosSafari) {
                var phone = String(url || '').match(/[?&]phone=(\d+)/);
                var target = phone ? ('https://wa.me/' + phone[1]) : url;
                var opened = false;
                var openChat = function () {
                    if (opened || !target) {
                        return;
                    }
                    opened = true;
                    window.location.href = target;
                };

                gtag('event', 'conversion', {
                    'send_to': 'AW-1011588590/GsJwCO-50uEBEO67ruID',
                    'event_callback': openChat,
                    'event_timeout': 400
                });
                setTimeout(openChat, 500);
                return false;
            }

            var callback = function () {
                if (typeof (url) != 'undefined') {
                    window.open(url, '_blank');
                }
            };

            gtag('event', 'conversion', {
                'send_to': 'AW-1011588590/GsJwCO-50uEBEO67ruID', 'event_callback': callback
            });

            return false;
        }

    </script>

    <link href="<?= $base ?>/assets/font/fonts.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $base ?>/assets/css/campanha-multimidia.css" />
    <link rel="icon" href="<?= $base ?>/assets/images/favicon.ico" />
</head>

<body id="toBody" class="<?= campanha_e($classeCorpo) ?>">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NJT4VVG4"
    height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header class="topo">
        <div class="wrap topo__bar">
            <a class="logo scroll" data-action="toBody" href="#toBody">
                <img src="<?= $base ?>/assets/images/gallosound.png" alt="Gallo Sound" width="199" height="47" />
            </a>
            <button class="menu-opener" type="button" aria-expanded="false" aria-controls="menu" aria-label="Abrir menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <nav id="menu" class="navHide" aria-label="Seções da página">
                <ul class="menu">
                    <?php foreach ($menu as $item) : ?>
                        <?php
                        $item = campanha_lista($item);
                        $itemId = campanha_id($item['id'] ?? '');
                        if ($itemId === '') {
                            continue;
                        }
                        ?>
                        <li>
                            <a class="scroll" data-action="<?= campanha_e($itemId) ?>" href="#<?= campanha_e($itemId) ?>"><?= campanha_e($item['label'] ?? '') ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li><?php campanha_whatsapp($textoHeader, 'nav-cta'); ?></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section id="banner" class="hero">
            <div class="wrap hero__grid">
                <div class="hero__copy">
                    <p class="hero__kicker"><?= campanha_e($hero['kicker'] ?? '') ?></p>
                    <h1><?= campanha_e($pagina['h1'] ?? '') ?></h1>
                    <p class="hero__lead"><?= campanha_e($hero['lead'] ?? '') ?></p>
                    <div class="hero__acoes">
                        <?php campanha_whatsapp($textoWhatsapp); ?>
                        <?php campanha_orcamento($textoOrcamento); ?>
                    </div>
                    <p class="hero__nota"><?= campanha_e($hero['nota'] ?? '') ?></p>
                    <?php if ($chips !== []) : ?>
                        <ul class="chips">
                            <?php foreach ($chips as $chip) : ?>
                                <li><?= campanha_e($chip) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <?php if ($heroSrc !== '') : ?>
                    <figure class="hero__foto">
                        <img
                            src="<?= $heroSrc ?>"
                            alt="<?= campanha_e($hero['alt'] ?? '') ?>"
                            width="<?= (int) ($hero['largura'] ?? 830) ?>"
                            height="<?= (int) ($hero['altura'] ?? 504) ?>"
                            fetchpriority="high"
                            decoding="async" />
                        <figcaption class="hero__legenda"><?= campanha_e($hero['legenda'] ?? '') ?></figcaption>
                    </figure>
                <?php endif; ?>
            </div>
        </section>

        <section id="diferenca" class="secao secao--branco">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($diferenca['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($diferenca['titulo'] ?? '') ?></h2>
                <p class="secao__intro"><?= campanha_e($diferenca['intro'] ?? '') ?></p>
                <div class="cards">
                    <?php foreach (campanha_lista($diferenca['blocos'] ?? null) as $bloco) : ?>
                        <?php $bloco = campanha_lista($bloco); ?>
                        <article class="card">
                            <h3><?= campanha_e($bloco['titulo'] ?? '') ?></h3>
                            <p><?= campanha_e($bloco['texto'] ?? '') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="chamada">
                    <p><?= campanha_e($diferenca['chamada'] ?? '') ?></p>
                    <?php campanha_whatsapp((string) ($diferenca['cta'] ?? '')); ?>
                </div>
            </div>
        </section>

        <section id="comparar" class="secao">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($comparar['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($comparar['titulo'] ?? '') ?></h2>
                <p class="secao__intro"><?= campanha_e($comparar['intro'] ?? '') ?></p>
                <div class="gap-list">
                    <?php
                    $colunas = campanha_lista($comparar['colunas'] ?? null);
                    $rotuloAnuncio = (string) ($colunas[0] ?? '');
                    $rotuloLoja = (string) ($colunas[1] ?? '');
                    ?>
                    <?php foreach (campanha_lista($comparar['linhas'] ?? null) as $linha) : ?>
                        <?php $linha = campanha_lista($linha); ?>
                        <article class="gap">
                            <p class="gap__rotulo"><?= campanha_e($rotuloAnuncio) ?></p>
                            <h3><?= campanha_e($linha['anuncio'] ?? '') ?></h3>
                            <div class="gap__loja">
                                <p class="gap__rotulo"><?= campanha_e($rotuloLoja) ?></p>
                                <p><?= campanha_e($linha['loja'] ?? '') ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="recursos" class="secao secao--branco">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($recursos['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($recursos['titulo'] ?? '') ?></h2>
                <p class="secao__intro"><?= campanha_e($recursos['intro'] ?? '') ?></p>
                <div class="recursos">
                    <?php foreach (campanha_lista($recursos['itens'] ?? null) as $item) : ?>
                        <?php $item = campanha_lista($item); ?>
                        <article class="recurso">
                            <h3><?= campanha_e($item['titulo'] ?? '') ?></h3>
                            <p><?= campanha_e($item['texto'] ?? '') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="videos" class="secao">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($videos['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($videos['titulo'] ?? '') ?></h2>
                <p class="secao__intro"><?= campanha_e($videos['intro'] ?? '') ?></p>
                <div class="videos">
                    <?php foreach (campanha_lista($videos['testes'] ?? null) as $teste) : ?>
                        <?php
                        $teste = campanha_lista($teste);
                        $videoId = campanha_video_id($teste['id'] ?? '');
                        if ($videoId === '') {
                            continue;
                        }
                        ?>
                        <article>
                            <div class="video">
                                <button type="button" class="video__play" data-video="<?= campanha_e($videoId) ?>" data-title="<?= campanha_e($teste['titulo'] ?? '') ?>">
                                    <img src="<?= campanha_e('https://i.ytimg.com/vi/' . $videoId . '/hqdefault.jpg') ?>" alt="" width="480" height="360" loading="lazy" decoding="async" />
                                    <span class="video__hit">
                                        <span class="video__icon" aria-hidden="true"></span>
                                        <span class="video__name"><?= campanha_e($teste['titulo'] ?? '') ?></span>
                                    </span>
                                </button>
                            </div>
                            <p class="video__texto"><?= campanha_e($teste['texto'] ?? '') ?></p>
                            <noscript>
                                <a href="<?= campanha_e('https://www.youtube.com/watch?v=' . $videoId) ?>">Assistir no YouTube</a>
                            </noscript>
                        </article>
                    <?php endforeach; ?>
                </div>
                <?php
                $bancada = campanha_lista($videos['bancada'] ?? null);
                $bancadaId = campanha_video_id($bancada['id'] ?? '');
                ?>
                <?php if ($bancadaId !== '') : ?>
                    <div class="bancada">
                        <h3><?= campanha_e($bancada['titulo'] ?? '') ?></h3>
                        <p class="secao__intro"><?= campanha_e($bancada['texto'] ?? '') ?></p>
                        <div class="video">
                            <button type="button" class="video__play" data-video="<?= campanha_e($bancadaId) ?>" data-title="<?= campanha_e($bancada['video_titulo'] ?? '') ?>">
                                <img src="<?= campanha_e('https://i.ytimg.com/vi/' . $bancadaId . '/hqdefault.jpg') ?>" alt="" width="480" height="360" loading="lazy" decoding="async" />
                                <span class="video__hit">
                                    <span class="video__icon" aria-hidden="true"></span>
                                    <span class="video__name"><?= campanha_e($bancada['video_titulo'] ?? '') ?></span>
                                </span>
                            </button>
                        </div>
                        <noscript>
                            <a href="<?= campanha_e('https://www.youtube.com/watch?v=' . $bancadaId) ?>">Assistir no YouTube</a>
                        </noscript>
                    </div>
                <?php endif; ?>
                <div class="faixa-cta">
                    <p><?= campanha_e($videos['cta_titulo'] ?? '') ?></p>
                    <?php campanha_whatsapp((string) ($videos['cta'] ?? '')); ?>
                </div>
            </div>
        </section>

        <section id="instalacoes" class="secao secao--branco">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($trabalhos['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($trabalhos['titulo'] ?? '') ?></h2>
                <p class="secao__intro"><?= campanha_e($trabalhos['intro'] ?? '') ?></p>
                <div class="galeria">
                    <?php foreach (campanha_lista($trabalhos['itens'] ?? null) as $trabalho) : ?>
                        <?php $trabalho = campanha_lista($trabalho); ?>
                        <figure class="trabalho">
                            <div class="trabalho__foto">
                                <img
                                    src="<?= campanha_asset($trabalho['imagem'] ?? '') ?>"
                                    alt="<?= campanha_e($trabalho['alt'] ?? '') ?>"
                                    width="<?= (int) ($trabalho['largura'] ?? 800) ?>"
                                    height="<?= (int) ($trabalho['altura'] ?? 600) ?>"
                                    loading="lazy"
                                    decoding="async" />
                            </div>
                            <figcaption>
                                <h3><?= campanha_e($trabalho['titulo'] ?? '') ?></h3>
                                <p><?= campanha_e($trabalho['texto'] ?? '') ?></p>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
                <div class="faixa-cta">
                    <p>Quer ver como a central fica no seu veículo? A resposta está na visita.</p>
                    <?php campanha_whatsapp((string) ($trabalhos['cta'] ?? '')); ?>
                </div>
            </div>
        </section>

        <section id="duvidas" class="secao">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($duvidas['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($duvidas['titulo'] ?? '') ?></h2>
                <div class="faq">
                    <?php foreach (campanha_lista($duvidas['itens'] ?? null) as $duvida) : ?>
                        <?php $duvida = campanha_lista($duvida); ?>
                        <details>
                            <summary><?= campanha_e($duvida['pergunta'] ?? '') ?></summary>
                            <p><?= campanha_e($duvida['resposta'] ?? '') ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="sobre" class="secao secao--branco">
            <div class="wrap sobre__grid">
                <div>
                    <p class="secao__kicker"><?= campanha_e($sobre['kicker'] ?? '') ?></p>
                    <h2 class="secao__titulo"><?= campanha_e($sobre['titulo'] ?? '') ?></h2>
                    <p class="secao__intro"><?= campanha_e($sobre['texto'] ?? '') ?></p>
                </div>
                <figure class="sobre__foto">
                    <img
                        src="<?= campanha_asset($sobre['imagem'] ?? '') ?>"
                        alt="<?= campanha_e($sobre['alt'] ?? '') ?>"
                        width="<?= (int) ($sobre['largura'] ?? 830) ?>"
                        height="<?= (int) ($sobre['altura'] ?? 596) ?>"
                        loading="lazy"
                        decoding="async" />
                    <figcaption class="sobre__legenda"><?= campanha_e($sobre['legenda'] ?? '') ?></figcaption>
                </figure>
            </div>
        </section>

        <section id="depoimentos" class="secao">
            <div class="wrap">
                <p class="secao__kicker"><?= campanha_e($depoimentos['kicker'] ?? '') ?></p>
                <h2 class="secao__titulo"><?= campanha_e($depoimentos['titulo'] ?? '') ?></h2>
                <div class="reviews">
                    <?php foreach (campanha_lista($depoimentos['itens'] ?? null) as $depoimento) : ?>
                        <?php $depoimento = campanha_lista($depoimento); ?>
                        <article class="review">
                            <blockquote><?= campanha_e($depoimento['texto'] ?? '') ?></blockquote>
                            <cite><?= campanha_e($depoimento['nome'] ?? '') ?></cite>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="contato" class="secao secao--branco">
            <div class="wrap">
                <div class="contato__grid">
                    <div>
                        <p class="secao__kicker"><?= campanha_e($contato['kicker'] ?? '') ?></p>
                        <h2 class="secao__titulo"><?= campanha_e($contato['titulo'] ?? '') ?></h2>
                        <p class="contato__texto"><?= campanha_e($contato['texto'] ?? '') ?></p>
                        <p class="reforco"><?= campanha_e($contato['reforco'] ?? '') ?></p>
                        <div class="contato__acoes">
                            <?php campanha_whatsapp($textoWhatsapp); ?>
                        </div>
                        <address>
                            <ul class="contato__dados">
                                <li><?= campanha_e($contato['endereco'] ?? '') ?></li>
                                <li>
                                    <?php
                                    $fones = campanha_lista($contato['fones'] ?? null);
                                    $totalFones = count($fones);
                                    foreach ($fones as $indiceFone => $fone) :
                                        $fone = campanha_lista($fone);
                                        $tel = (string) ($fone['tel'] ?? '');
                                        $exibicao = (string) ($fone['exibicao'] ?? '');
                                        $telOk = preg_match('/^\+[0-9]{12,13}$/', $tel) === 1;
                                        ?>
                                        <?php if ($telOk) : ?>
                                            <a href="tel:<?= campanha_e($tel) ?>"><?= campanha_e($exibicao) ?></a>
                                        <?php else : ?>
                                            <?= campanha_e($exibicao) ?>
                                        <?php endif; ?>
                                        <?php if ($indiceFone < $totalFones - 1) : ?>
                                            <?= ' - ' ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </li>
                                <li>
                                    <?php foreach (campanha_lista($contato['horario'] ?? null) as $indiceHora => $hora) : ?>
                                        <?php if ($indiceHora > 0) : ?>
                                            <br />
                                        <?php endif; ?>
                                        <?= campanha_e($hora) ?>
                                    <?php endforeach; ?>
                                </li>
                            </ul>
                        </address>
                    </div>
                    <div id="formContact" class="formulario">
                        <h3><?= campanha_e($contato['form_titulo'] ?? '') ?></h3>
                        <p class="form-intro"><?= campanha_e($contato['form_texto'] ?? '') ?></p>
                        <form method="POST">
                            <div class="form-linha">
                                <label class="campo">
                                    <span>Nome</span>
                                    <input id="nome" type="text" name="nome" autocomplete="name" maxlength="120" placeholder="Seu nome" />
                                </label>
                                <label class="campo">
                                    <span>E-mail</span>
                                    <input id="email" type="email" name="email" autocomplete="email" inputmode="email" autocapitalize="none" spellcheck="false" maxlength="160" placeholder="seu@email.com" />
                                </label>
                            </div>
                            <label class="campo">
                                <span>WhatsApp</span>
                                <input id="whats" type="tel" name="whats" autocomplete="tel" inputmode="tel" maxlength="20" placeholder="(11) 90000-0000" />
                            </label>
                            <label class="campo">
                                <span>Mensagem</span>
                                <textarea id="msg" name="mensagem" maxlength="2000" placeholder="Modelo do carro e o que você quer ver na visita"></textarea>
                            </label>
                            <input id="mensagem" type="submit" value="<?= campanha_e($textoEnviar) ?>" class="btn btn-ink" />
                        </form>
                    </div>
                </div>
                <?php if ($mapaOk) : ?>
                    <div class="mapa">
                        <iframe
                            src="<?= campanha_e($mapa) ?>"
                            title="<?= campanha_e($contato['mapa_titulo'] ?? '') ?>"
                            loading="lazy"
                            allowfullscreen
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <div class="wrap"><?= campanha_e($pagina['rodape'] ?? '') ?></div>
    </footer>

    <a href="#" id="btnWhatsApp" class="btnWhatsApp" aria-label="<?= campanha_e($textoFlutuante) ?>">
        <img class="shaked" src="<?= $base ?>/assets/images/whatsapp.png" alt="" width="64" height="64" />
    </a>
    <?php if ($barraVisita) : ?>
    <div class="barra-visita">
        <?php campanha_whatsapp($textoBarra); ?>
    </div>
    <?php endif; ?>
    <button id="btnScrollTop" data-action="toBody" class="btnScrollTopHide scroll" type="button"><?= campanha_e($textoTopo) ?></button>
    <script src="<?= $base ?>/assets/js/jquery.js"></script>
    <script src="<?= $base ?>/assets/js/script.js"></script>
    <script>
        document.querySelectorAll("[data-video]").forEach(function (botao) {
            botao.addEventListener("click", function () {
                var id = botao.getAttribute("data-video") || "";
                if (!/^[A-Za-z0-9_-]{11}$/.test(id)) {
                    return;
                }
                var frame = document.createElement("iframe");
                frame.src = "https://www.youtube-nocookie.com/embed/" + id + "?autoplay=1&rel=0";
                frame.title = botao.getAttribute("data-title") || "Vídeo da Gallo Sound";
                frame.allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share";
                frame.allowFullscreen = true;
                botao.replaceWith(frame);
            });
        });

        var abridor = document.querySelector(".menu-opener");
        var navegacao = document.querySelector("nav");
        function marcarMenu(aberto) {
            if (!abridor) {
                return;
            }
            abridor.setAttribute("aria-expanded", aberto ? "true" : "false");
            abridor.setAttribute("aria-label", aberto ? "Fechar menu" : "Abrir menu");
        }
        function fecharMenu() {
            if (!navegacao) {
                return;
            }
            navegacao.classList.add("navHide");
            navegacao.classList.remove("navShow");
            marcarMenu(false);
        }
        if (abridor && navegacao) {
            abridor.addEventListener("click", function () {
                marcarMenu(navegacao.classList.contains("navShow"));
            });
        }
        document.addEventListener("click", function (evento) {
            if (!navegacao || !abridor) {
                return;
            }
            if (abridor.contains(evento.target) || navegacao.contains(evento.target)) {
                return;
            }
            fecharMenu();
        }, true);
        document.querySelectorAll("nav a").forEach(function (item) {
            item.addEventListener("click", function () {
                marcarMenu(false);
            });
        });
    </script>
</body>

</html>
