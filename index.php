<?php require 'Config.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-27874578-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-27874578-1');

        // tag convesão de cliques
        gtag('config', 'AW-1011588590');

        function gtag_report_conversion(url) {
            var callback = function () {
                if (typeof (url) != 'undefined') {
                    //window.location = url;
                    window.open(url, '_blank');
                }
            };

            gtag('event', 'conversion', {
                'send_to': 'AW-1011588590/GsJwCO-50uEBEO67ruID', 'event_callback': callback
            });

            return false;
        }

        <!-- Event snippet for Enviar formulário de lead conversion page In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
        function gtag_report_conversionForm(url) {
            var callback = function () { if (typeof (url) != 'undefined') { window.location = url; } }; gtag('event', 'conversion', { 'send_to': 'AW-1011588590/tj_kCN_byrQDEO67ruID', 'event_callback': callback }); return false;
        }
    </script>
    <title>GALLO SOUND | Central Multimidia | Insulfilm jundiai | Sensor Estacionamento</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="author" content="Alex Gallo">
    <meta
        content="Gallo Sound, tradição e qualidade em som automotivo em Jundiaí e região. Trabalhamos com insulfilm, Som, Alarme, Trava Elétrica, vidro elétrico, modulo de conforto, Atualização de GPS e muito mais. Venha nos conhecer"
        name="description">
    <meta name="keywords"
        content="central multimidia, insulfilm jundiai, modulo de conforto, pelicula de proteção solar, sensor de re">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="Follow" />
    <meta name="rating" content="general" />
    <meta name="DC.Identifier" content="<?= BASE_URL;?>">
    <meta name="url" content="<?= BASE_URL;?>" />
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1" />
    <meta property="og:url" content="<?= BASE_URL;?>">
    <meta property="og:title" content="Gallo Sound">
    <meta property="og:type" content="website">
    <meta property="og:description"
        content="Gallo Sound, tradição e qualidade em som automotivo em Jundiaí e região. Trabalhamos com central multimidia, insulfilm, modulo de conforto e muito mais. Venha nos conhecer">
    <meta property="og:image" content="<?= BASE_URL;?>/media/gallosound.jpg">
    <link href="<?= BASE_URL;?>/assets/font/fonts.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL;?>/assets/css/style_min.css" />
    <link rel="icon" href="<?= BASE_URL;?>/assets/images/favicon.ico" />
</head>

<body id="toBody">
    <header>
        <div class="header">
            <div class="logo">
                <div class="logoimg"><img src="<?= BASE_URL;?>/assets/images/gallosound.png"
                        alt="gallosound logo"></div>
            </div>
            <div class="menu">
                <img class="menu-opener" src="<?= BASE_URL;?>/assets/images/menu.png" alt="menu-opener" />
                <nav class="navHide">
                    <ul>
                        <li data-action="home" class="scroll"><a>Home</a></li>
                        <li data-action="servicos" class="scroll"><a>Serviços</a></li>
                        <li data-action="trabalhos" class="scroll"><a>Trabalhos</a></li>
                        <li data-action="contato" class="scroll"><a>Contato</a></li>
                        <li data-action="sobre" class="scroll"><a>Sobre</a></li>
                        <li data-action="trabalheconosco" class="scroll"><a style="color:red;"># temos vagas</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <section id="banner" class="banner">
            <div class="sliders" style="margin-left:0;">
                <div class="slide">
                    <div id="slidearea0" class="slidearea slideAction">
                        <h1>Mais de 50 Anos<br /><span>com Você</span></h1>
                        <h2>Central Multimídia | Insul-Film | Sensor de Estacionamento</h2>
                        <img src="assets/images/multimidia_home_2.jpg" alt="" width="50%"  >
                        <div class="imgslide" ></div>
                        <a href="#" data-action="contato" class="scroll button">Entre em Contato</a>
                    </div>
                    <div id="slidearea1" class="slidearea slideAction">
                        <h1>Central<br /><span>Multimídia</span></h1>
                        <h2>carPlay e Android Auto, câmera de ré, Waze, Google Maps, GPS off-line, YOUTUBE, NETFLIX,
                            e muito mais!</h2>
                        <a href="#" data-action="contato" class="scroll button" class="button">Entre em Contato</a>
                    </div>
                    <div id="slidearea2" class="slidearea slideAction">
                        <h1>Película<br /><span>controle Solar</span></h1>
                        <h2>Bloqueio de 99% dos raios UV, Mais proteção e conforto - automóvel, residência e indústria
                        </h2>
                        <a href="#" data-action="contato" class="scroll button">Entre em Contato</a>
                    </div>
                    <div id="slidearea3" class="slidearea slideAction">
                        <h1>Som<br /><span>Automotivo</span></h1>
                        <h2>Do original ao hi-end, sempre os melhores para o que você deseja</h2>
                        <a href="#" data-action="contato" class="scroll button" class="button">Entre em Contato</a>
                    </div>
                </div>
            </div>
            <div class="sliders-pointers">
                <div id="pointerBanner0" class="pointer active"></div>
                <div id="pointerBanner1" class="pointer"></div>
                <div id="pointerBanner2" class="pointer"></div>
                <div id="pointerBanner3" class="pointer"></div>
            </div>
        </section>
        <section id="servicos" class="default light">
            <div class="section-title">Serviços</div>
            <div class="section-desc">O que podemos fazer por você</div>
            <div class="section-body">
                <div class="section-services">
                    <div class="section-service">
                        <img src="<?= BASE_URL;?>/assets/images/multimidia.png" alt="central multimidia" />
                        <h4>Central Multimídia</h4>
                        <p>Instalação e Venda das melhores Centrais Multimídias do mercado, com diversas funcionalidades
                            como, <strong>carPlay, Android Auto, câmera de ré, Waze, Google Maps, GPS off-line,
                                YOUTUBE, NETFLIX </strong> e muito mais!!!</p>
                    </div>
                    <div class="section-service">
                        <img src="<?= BASE_URL;?>/assets/images/insulfilm.png" alt="insulfilm" />
                        <h4>Insul-Film</h4>
                        <p>Aplicação de películas de controle solar para automóvel, residência e indústria.</p>
                    </div>
                    <div class="section-service">
                        <img src="<?= BASE_URL;?>/assets/images/sensor.png" alt="sensor de estacionamento" />
                        <h4>Sensor de Estacionamento</h4>
                        <p>Evite arranhões no parachoque, estacione com facilidade e segurança, instale um sensor de
                            estacionamento.</p>
                    </div>
                    <div class="section-service">
                        <img src="<?= BASE_URL;?>/assets/images/alto-falante.png" alt="alto-falante" />
                        <h4>Som automotivo</h4>
                        <p>Venda e instalação de alto-falantes, caixas acústicas, módulos de potência, processadores
                            digitais, fontes automotivas e outros</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="trabalhos" class="default">
            <div class="section-title">Trabalhos</div>
            <div class="section-desc">O que nós fazemos</div>
            <div class="section-body">
                <div class="section-projects">
                    <div class="section-projects--photos">
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Multimídia Yaris</h5>
                                    <p>Você mais conectado com seu carro</p>
                                </div>
                                <img src="media/multimidia_Yaris.jpg" alt="multimidia Toyota Yaris" />
                            </div>
                        </div>
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Multimídia Corolla</h5>
                                    <p>Você mais conectado com seu carro</p>
                                </div>
                                <img src="media/multimidia_Corolla.jpg" alt="multimidia Renegade" />
                            </div>
                        </div>
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Central Multimídia Civic</h5>
                                    <p>Você mais conectado com seu carro</p>
                                </div>
                                <img src="media/multimidia_civic.jpg" alt="multimidia new civic" />
                            </div>
                        </div>
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Sensor de Estacionamento</h5>
                                    <p>Estacione com facilidade e segurança</p>
                                </div>
                                <img src="media/sensor_estacionamento.jpg" alt="sensor estacionamento" />
                            </div>
                        </div>
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Kit Ultra Led</h5>
                                    <p>Melhora a visibilidade e segurança</p>
                                </div>
                                <img src="media/leds_.jpg" alt="Kit Leds Farol" />
                            </div>
                        </div>
                        <div class="section-projects--photo">
                            <div class="section-projects--photoarea">
                                <div class="section-projects--photoinfo">
                                    <h5>Película controle Solar</h5>
                                    <p>Mais proteção e conforto</p>
                                </div>
                                <img src="media/film.jpg" alt="film" />
                            </div>
                        </div>
                    </div>
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
                            por uma empresa familiar, situada em uma cidade com aproximadamente 370.126 habitantes no
                            interior do estado de São Paulo. Permanece na mesma localização desde sua fundação</p>
                    </div>
                    <div class="section-aboutus--right">
                        <img src="media/pirua_gallo.jpg" alt="image" />
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
                        <div class="slide">
                            <div class="slidearea">
                                <div class="section-testimonials--name">Luan Henrique Donato</div>
                                <div class="section-testimonials--role"></div>
                                <img class="section-testimonials--quoteimg"
                                    src="<?= BASE_URL;?>/assets/images/quote.png" alt="quote image" />
                                <div class="section-testimonials--quote">A Gallo sound é super especialista.. Conheço e
                                    super indico a amigos e familiares .. Atendimento top, feedback ao cliente,
                                    confiança no serviço executado . Quero deixa meu comentário todos funcionários estão
                                    de parabéns ,meu contato direto sempre foi com Allan ,Alex e Vitor .. que além de
                                    profissionais ,sabem do que estão falando e expõe o que desejamos de melhor ,tanto
                                    na parte de som , Insulfilm ,leds enfim . Sou um cliente fiel Gallo Sound !.</div>
                            </div>
                        </div>
                        <div class="slide">
                            <div class="slidearea">
                                <div class="section-testimonials--name">Bruno Giovanni Brasil Gangsta</div>
                                <div class="section-testimonials--role"></div>
                                <img class="section-testimonials--quoteimg"
                                    src="<?= BASE_URL;?>/assets/images/quote.png" alt="quote image" />
                                <div class="section-testimonials--quote">Ótimo atendimento, ótimo trabalho e um ambiente
                                    bem legal , nota 10.</div>
                            </div>
                        </div>
                        <div id="startNumber" class="slide">
                            <div class="slidearea">
                                <div class="section-testimonials--name">Edegar Ferreira</div>
                                <div class="section-testimonials--role"></div>
                                <img class="section-testimonials--quoteimg"
                                    src="<?= BASE_URL;?>/assets/images/quote.png" alt="quote image" />
                                <div class="section-testimonials--quote">Muito bem atendido. Serviços executados com
                                    cuidados e técnicas.</div>
                            </div>
                        </div>
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

        <section id="trabalheconosco" class="default light">
            <div class="section-title">Gostaria de fazer parte da nossa equipe?</div>
            <div class="section-desc">Estamos Contratando, Vagas para Instaladores Som/Film! <br /> Entre em contato com
                nosso WhatsApp, Clique e preencha nosso Formulário Digital Abaixo.<br /><br /><br /> <a
                    style="color:red;" href="<?= BASE_URL;?>/gsfacilsite/cadastro/gallosound57671471000149"
                    target="_blank">Formulário</a></div>
        </section>


        <section id="contato" class="section-map">

            <div class="section-map--area">

                <div class="section-map--info">
                    <address>
                        <div class="section-map--info-title">Contato</div>

                        <div class="section-map--info-desc"></div>

                        <div class="section-map--info-item">

                            <div class="section-map--info-item-img">

                                <img src="<?= BASE_URL;?>/assets/images/localizacao.png" alt="localizacao" />

                            </div>

                            Rua Barão do Rio Branco, 357, Vila Arens, Jundiaí-SP.

                        </div>

                        <div class="section-map--info-item">

                            <div class="section-map--info-item-img">

                                <img src="<?= BASE_URL;?>/assets/images/telefone.png" alt="telefone" />

                            </div>

                            (11) 3379-2892 - (11) 94757-4606

                        </div>



                        <div class="section-map--info-item">

                            <div class="section-map--info-item-img">

                                <img src="<?= BASE_URL;?>/assets/images/clock.png" alt="horario" />

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

                            <input id="assunto" type="text" name="assunto" placeholder="ASSUNTO" />

                            <textarea id="msg" name="mensagem" placeholder="MENSAGEM"></textarea>

                            <input id="mensagem" type="submit" value="Enviar" class="button" />

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
        <img class="sticky shaked" src="<?= BASE_URL;?>/assets/images/whatsapp.png"
            alt="Fale Conosco pelo WhatsApp">
    </a>
    <button id="btnScrollTop" data-action="toBody" class="button sticky btnScrollTopHide scroll">TOP</button>

</body>

</html>

<script src="<?= BASE_URL;?>/assets/js/jquery.js"></script>

<script src="<?= BASE_URL;?>/assets/js/script_min.js"></script>