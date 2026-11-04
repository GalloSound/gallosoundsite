<?php

if (!defined('BASE_URL') || !isset($pagina) || !is_array($pagina)) {
    http_response_code(500);
    echo 'Página indisponível.';
    return;
}

if (!function_exists('produto_e')) {
    function produto_e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('produto_asset')) {
    function produto_asset(mixed $path): string
    {
        $path = trim((string) ($path ?? ''));
        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path) === 1) {
            return produto_e($path);
        }

        return produto_e(BASE_URL . '/' . ltrim($path, '/'));
    }
}

if (!function_exists('produto_lista')) {
    function produto_lista(mixed $valor): array
    {
        return is_array($valor) ? $valor : [];
    }
}

$slug = trim((string) ($pagina['slug'] ?? ''), '/');
$paginaUrl = produto_e(BASE_URL . '/' . rawurlencode($slug) . '/');
$base = produto_e(BASE_URL);
$og = produto_lista($pagina['og'] ?? null);
$banner = produto_lista($pagina['banner'] ?? null);
$slidesBanner = produto_lista($pagina['slides'] ?? null);
if ($slidesBanner === []) {
    $slidesBanner = [[
        'h1' => $pagina['h1'] ?? '',
        'h2' => $pagina['h2'] ?? '',
        'imagem' => $banner['imagem'] ?? '',
        'alt' => $banner['alt'] ?? '',
    ]];
}
$recursos = produto_lista($pagina['recursos'] ?? null);
$trabalhos = produto_lista($pagina['trabalhos'] ?? null);
$depoimentos = produto_lista($pagina['depoimentos'] ?? null);
$botoes = produto_lista($pagina['botoes'] ?? null);
$textoOrcamento = (string) ($botoes['orcamento'] ?? '');
$textoEnviar = (string) ($botoes['enviar'] ?? '');
$textoTopo = (string) ($botoes['topo'] ?? '');
$textoWhatsapp = (string) ($botoes['whatsapp'] ?? '');
$ultimoDepoimento = count($depoimentos) - 1;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
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

    <title><?= produto_e($pagina['title'] ?? '') ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="author" content="Alex Gallo" />
    <meta content="<?= produto_e($pagina['description'] ?? '') ?>" name="description" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="Follow" />
    <meta name="rating" content="general" />
    <meta name="DC.Identifier" content="<?= $paginaUrl ?>" />
    <meta name="url" content="<?= $paginaUrl ?>" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <meta property="og:url" content="<?= $paginaUrl ?>" />
    <meta property="og:title" content="<?= produto_e($og['title'] ?? '') ?>" />
    <meta property="og:type" content="<?= produto_e($og['type'] ?? 'website') ?>" />
    <meta property="og:description" content="<?= produto_e($og['description'] ?? '') ?>" />
    <meta property="og:image" content="<?= produto_asset($og['image'] ?? '') ?>" />
    <link href="<?= $base ?>/assets/font/fonts.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= $base ?>/assets/css/style_min.css" />
    <style>
        @media (max-width: 450px) {
            .banner .slidearea {
                text-align: center;
            }

            .banner h1 {
                width: 100%;
                font-size: 28px;
                line-height: 1.15;
                text-align: center;
                text-wrap: balance;
            }
        }
    </style>
    <link rel="icon" href="<?= $base ?>/assets/images/favicon.ico" rel="shortcut icon" />
</head>

<body id="toBody">
    <header>
        <div class="header">
            <div class="logo">
                <div class="logoimg"><img src="<?= $base ?>/assets/images/gallosound.png" alt="gallosound logo">
                </div>
            </div>
            <div class="menu">
                <img class="menu-opener" src="<?= $base ?>/assets/images/menu.png" alt="menu-opener" />
                <nav class="navHide">
                    <ul>
                        <li data-action="home" class="scroll"><a>Home</a></li>
                        <li data-action="servicos" class="scroll"><a>Serviços</a></li>
                        <li data-action="trabalhos" class="scroll"><a>Trabalhos</a></li>
                        <li data-action="contato" class="scroll"><a>Contato</a></li>
                        <li data-action="sobre" class="scroll"><a>Sobre</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section id="banner" class="banner">
            <div class="sliders" style="margin-left:0;">
                <div class="slide">
                    <?php if (count($slidesBanner) === 1) : ?>
                        <?php $slideBanner = produto_lista($slidesBanner[0]); ?>
                        <div class="slidearea">
                            <h1><?= produto_e($slideBanner['h1'] ?? '') ?></h1>
                            <h2><?= produto_e($slideBanner['h2'] ?? '') ?></h2>
                            <img src="<?= produto_asset($slideBanner['imagem'] ?? '') ?>" alt="<?= produto_e($slideBanner['alt'] ?? '') ?>" width="50%">
                            <a href="#" data-action="contato" class="button desk btnWhatsApp"><?= produto_e($textoOrcamento) ?></a>
                        </div>
                    <?php else : ?>
                        <?php foreach ($slidesBanner as $indiceSlide => $slideBanner) : ?>
                            <?php $slideBanner = produto_lista($slideBanner); ?>
                            <div id="slidearea<?= (int) $indiceSlide ?>" class="slidearea<?= $indiceSlide === 0 ? ' slideAction' : '' ?>">
                                <h1><?= produto_e($slideBanner['h1'] ?? '') ?></h1>
                                <h2><?= produto_e($slideBanner['h2'] ?? '') ?></h2>
                                <img src="<?= produto_asset($slideBanner['imagem'] ?? '') ?>" alt="<?= produto_e($slideBanner['alt'] ?? '') ?>" width="50%">
                                <a href="#" data-action="contato" class="button desk btnWhatsApp"><?= produto_e($textoOrcamento) ?></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (count($slidesBanner) > 1) : ?>
                <div class="sliders-pointers">
                    <?php foreach ($slidesBanner as $indiceSlide => $slideBanner) : ?>
                        <div id="pointerBanner<?= (int) $indiceSlide ?>" class="pointer<?= $indiceSlide === 0 ? ' active' : '' ?>"></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <section id="servicos" class="default light">
            <div class="section-title">Serviços</div>
            <div class="section-desc">O que podemos fazer por você</div>
            <div class="section-body">
                <div class="section-services">
                    <?php foreach ($recursos as $recurso) : ?>
                        <?php $recurso = produto_lista($recurso); ?>
                        <?php $linhas = produto_lista($recurso['linhas'] ?? null); ?>
                        <div class="section-service">
                            <img src="<?= produto_asset($recurso['imagem'] ?? '') ?>" alt="<?= produto_e($recurso['alt'] ?? '') ?>" />
                            <h4><?= produto_e($recurso['titulo'] ?? '') ?></h4>
                            <?php if ($linhas !== []) : ?>
                                <h3>
                                    <?php foreach ($linhas as $indiceLinha => $linha) : ?>
                                        <?php $linha = produto_lista($linha); ?>
                                        <?= produto_e($linha['antes'] ?? '') ?><strong style="color:red;"><?= produto_e($linha['destaque'] ?? '') ?></strong><?= produto_e($linha['depois'] ?? '') ?>
                                        <?php if ($indiceLinha < count($linhas) - 1) : ?>
                                            <br />
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </h3>
                            <?php endif; ?>
                            <p><?= produto_e($recurso['paragrafo'] ?? '') ?><strong><?= produto_e($recurso['destaque'] ?? '') ?></strong><?= produto_e($recurso['resto'] ?? '') ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section id="trabalhos" class="default trabalhos_desk">
            <div class="section-title">Trabalhos</div>
            <div class="section-desc">O que nós fazemos</div>
            <div class="section-body">
                <div class="section-projects">
                    <div class="section-projects--photos">
                        <?php foreach ($trabalhos as $trabalho) : ?>
                            <?php $trabalho = produto_lista($trabalho); ?>
                            <div class="section-projects--photo">
                                <div class="section-projects--photoarea">
                                    <div class="section-projects--photoinfo">
                                        <h5><?= produto_e($trabalho['titulo'] ?? '') ?></h5>
                                        <p><?= produto_e($trabalho['texto'] ?? '') ?></p>
                                    </div>
                                    <img src="<?= produto_asset($trabalho['imagem'] ?? '') ?>" alt="<?= produto_e($trabalho['alt'] ?? '') ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" data-action="contato" class="button desk btnWhatsApp"><?= produto_e($textoOrcamento) ?></a>
                </div>
            </div>
        </section>
        <section id="trabalhos-mobile" class="default trabalhos_mobile">
            <div class="section-title">Trabalhos</div>
            <div class="section-desc">O que nós fazemos</div>
            <div class="section-body">
                <div class="section-projects">
                    <div class="section-projects--photos" style="margin-bottom:20px">
                        <?php foreach ($trabalhos as $trabalho) : ?>
                            <?php
                            $trabalho = produto_lista($trabalho);
                            $tituloMobile = (string) ($trabalho['titulo_mobile'] ?? $trabalho['titulo'] ?? '');
                            $idMobile = trim((string) ($trabalho['id_mobile'] ?? ''));
                            $idImagem = trim((string) ($trabalho['id_imagem'] ?? ''));
                            ?>
                            <div class="section-projects--photo">
                                <div class="section-projects--photoarea"<?= $idMobile !== '' ? ' id="' . produto_e($idMobile) . '"' : '' ?>>
                                    <div class="section-projects--photoinfo">
                                        <h5><?= produto_e($tituloMobile) ?></h5>
                                        <p><?= produto_e($trabalho['texto'] ?? '') ?></p>
                                    </div>
                                    <img
                                        <?= $idImagem !== '' ? 'id="' . produto_e($idImagem) . '"' : '' ?>
                                        src="<?= produto_asset($trabalho['imagem'] ?? '') ?>"
                                        alt="<?= produto_e($trabalho['alt'] ?? '') ?>"
                                        style="margin-top:12px"
                                        loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="#" data-action="contato" class="button desk btnWhatsApp"><?= produto_e($textoOrcamento) ?></a>
                </div>
            </div>
        </section>
        <section id="sobre" class="default light">
            <div class="section-title">Sobre Nós</div>
            <div class="section-desc">Gallo Sound</div>
            <div class="section-body">
                <div class="section-aboutus">
                    <div class="section-aboutus--left">
                        <p>Iniciou suas atividades em 1.957, atuando há mais de 60 anos neste segmento, caracteriza-se
                            por uma empresa familiar, situada em uma cidade com aproximadamente 420.000 habitantes no
                            interior do estado de São Paulo. Permanece na mesma localização desde sua fundação</p>
                    </div>
                    <div class="section-aboutus--right">
                        <img src="<?= $base ?>/media/pirua_gallo.jpg" alt="image" />
                    </div>
                </div>
            </div>
        </section>
        <section id="depoimentos" class="default testimonials">
            <div class="section-title">Depoimentos</div>
            <div class="section-desc">avaliações publicas no google</div>
            <div class="section-body">
                <div class="section-testimonials">
                    <div class="sliders" style="margin-left:0;">
                        <?php foreach ($depoimentos as $indice => $depoimento) : ?>
                            <?php $depoimento = produto_lista($depoimento); ?>
                            <div<?= $indice === $ultimoDepoimento ? ' id="startNumber"' : '' ?> class="slide">
                                <div class="slidearea">
                                    <div class="section-testimonials--name"><?= produto_e($depoimento['nome'] ?? '') ?></div>
                                    <div class="section-testimonials--role"></div>
                                    <img class="section-testimonials--quoteimg" src="<?= $base ?>/assets/images/quote.png" alt="quote image" />
                                    <div class="section-testimonials--quote"><?= produto_e($depoimento['texto'] ?? '') ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <section id="servicos_clientes" class="default dark">
            <div class="section-title">Serviços e Clientes</div>
            <div class="section-desc">deste 1957 trabalhando com profissionalismo e qualidade</div>
            <div class="section-body">
                <div class="section-facts">
                    <div class="section-fact">
                        <h3 max="1356561" class="number">0</h3>
                        <div class="section-fact-line"></div>
                        <h4>Serviços Realizados</h4>
                        <p>com o avanço rápido da tecnologia já realizamos diversos tipos de serviços, contamos com uma
                            vasta experiência adquiridas ao longo do tempo</p>
                    </div>
                    <div class="section-fact">
                        <h3 max="400000" class="number">0</h3>
                        <div class="section-fact-line"></div>
                        <h4>Clientes Atendidos</h4>
                        <p>pessoas e empresas atendidas durante nossa jornada</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="contato" class="section-map">
            <div class="section-map--area">
                <div class="section-map--info">
                    <address>
                        <div class="section-map--info-title">Contato</div>
                        <div class="section-map--info-desc"></div>
                        <div class="section-map--info-item">
                            <div class="section-map--info-item-img">
                                <img src="<?= $base ?>/assets/images/localizacao.png" alt="localizacao" />
                            </div>
                            Rua Barão do Rio Branco, 357, Vila Arens, Jundiaí-SP.
                        </div>
                        <div class="section-map--info-item">
                            <div class="section-map--info-item-img">
                                <img src="<?= $base ?>/assets/images/telefone.png" alt="telefone" />
                            </div>
                            (11) 3379-2892 - (11) 94757-4606
                        </div>
                        <div class="section-map--info-item">
                            <div class="section-map--info-item-img">
                                <img src="<?= $base ?>/assets/images/clock.png" alt="horario" />
                            </div>
                            Horário de Atendimento <br /> Seg - Sexta: 8:30 as 18:00 <br /> Sábado 8:30 as 12:30
                        </div>
                    </address>
                    <div id="formContact" class="section-contact">
                        <form method="POST">
                            <div class="section-contact--split">
                                <input id="nome" type="text" name="nome" placeholder="NOME" />
                                <input id="email" type="text" name="email" placeholder="EMAIL" />
                            </div>
                            <input id="whats" type="text" name="whats" placeholder="WhatsApp" />
                            <textarea id="msg" name="mensagem" placeholder="MENSAGEM"></textarea>
                            <input id="mensagem" type="submit" value="<?= produto_e($textoEnviar) ?>" class="button" />
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <address>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.777817734832!2d-46.87721483882308!3d-23.196111551227375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cf26c39c4c3283%3A0x1ed5ff5b209f8e15!2sGallo%20Sound!5e0!3m2!1spt-BR!2sbr!4v1588518758047!5m2!1spt-BR!2sbr"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"
                    title="endereco"></iframe>
            </address>
        </section>
    </main>
    <footer>
        <div class="footer--area">
            <div class="footer--item area2">
                Todos os direitos reservados. Gallo Sound.
            </div>
        </div>
    </footer>
    <a href="#" id="btnWhatsApp" class="desk btnWhatsApp">
        <img class="sticky shaked" src="<?= $base ?>/assets/images/whatsapp.png" alt="<?= produto_e($textoWhatsapp) ?>">
    </a>
    <button id="btnScrollTop" data-action="toBody" class="button sticky btnScrollTopHide scroll"><?= produto_e($textoTopo) ?></button>
</body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NJT4VVG4"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</html>
<script src="<?= $base ?>/assets/js/jquery.js"></script>
<script src="<?= $base ?>/assets/js/script.js"></script>
