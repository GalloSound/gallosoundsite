// adicionando função scroll
document.querySelectorAll(".scroll").forEach((item) => {
    item.addEventListener("click", topFunction);
});
// When the user clicks on the button, scroll to the top of the document
function topFunction(e) {
    e.preventDefault();
    let action = this.getAttribute("data-action");

    if (action === "trabalhos" && window.matchMedia("(max-width: 768px)").matches) {
        action = "trabalhos-mobile";
    }

    let id = "#" + action;
    let target = $(id);

    if (!target.length) {
        return;
    }

    let go = target.position().top;
    $("html, body").animate({ scrollTop: go }, "slow");
}

var slide = setInterval(slideAction, 6000);

// função SLIDE HOME
function slideAction() {
    if ($(".slideAction").next().length) {
        $(".slideAction")
            .fadeOut()
            .removeClass("slideAction")
            .next()
            .fadeIn()
            .addClass("slideAction");
        $(".active").removeClass("active").next().addClass("active");
    } else {
        $(".slideAction").fadeOut().removeClass("slideAction");
        $("#slidearea0").fadeIn().addClass("slideAction");
        $(".active").removeClass("active");
        $("#pointerBanner0").addClass("active");
    }
}
// CLICK POINTER TROCA SLIDE
let pointer = 0;
document.querySelectorAll(".banner .pointer").forEach((item, index) => {
    item.addEventListener("click", function (e) {
        e.preventDefault();
        clearInterval(slide);
        slide = false;

        pointer = index;

        $(".slideAction").fadeOut().removeClass("slideAction");
        $("#slidearea" + pointer)
            .fadeIn()
            .addClass("slideAction");

        $(".active").removeClass("active");
        $("#pointerBanner" + pointer).addClass("active");

        setTimeout(() => {
            clearInterval(slide);
            slide = false;
            slide = setInterval(slideAction, 5000);
        }, 5000);
    });
});
let w = window.screen.width;
if (w <= 450) {
    // adicionando imagens
    function appendServiceImage(containerId, imageId, src, altText) {
        var elementInsert = document.getElementById(containerId);
        if (!elementInsert || document.getElementById(imageId)) {
            return;
        }

        let img1 = document.createElement("img");
        img1.setAttribute("src", src);
        img1.setAttribute("alt", altText);
        img1.setAttribute("id", imageId);
        img1.setAttribute("style", "margin-top:12px");
        img1.setAttribute("loading", "lazy");
        img1.setAttribute("decoding", "async");
        elementInsert.appendChild(img1);
    }

    function addIMG() {
        if (document.documentElement.scrollTop !== 0 || document.body.scrollTop !== 0) {
            appendServiceImage("imgYaris", "haveImgYaris", "media/multimidia_Yaris.jpg", "multimidia Toyota Yaris");
            appendServiceImage("imgCorolla", "haveCorolla", "media/multimidia_Corolla.jpg", "Central multimidia Toyota Corolla");
            appendServiceImage("imgCivic", "haveCivic", "media/multimidia_civic.jpg", "Central multimidia Honda Civic");
            appendServiceImage("imgSensor", "haveSensor", "media/sensor_estacionamento.jpg", "sensor de estacionamento");
            appendServiceImage("imgLed", "haveLeds", "media/leds_.jpg", "Kit Farol Leds");
            appendServiceImage("imgFilm", "haveFilm", "media/film.jpg", "film pelicula controle solar");
        }
    }
} else {
    function addIMG() {

    }
}


const navElement = document.querySelector("nav");
const menuOpener = document.querySelector(".menu-opener");
const mainElement = document.querySelector("main");
if (navElement) {
    navElement.style.transition = "all 0.3s linear";
}
if (menuOpener && navElement) {
    menuOpener.addEventListener("click", function () {
        if (navElement.classList.contains("navHide")) {
            navElement.classList.remove("navHide");
            navElement.classList.add("navShow");
        } else {
            navElement.classList.remove("navShow");
            navElement.classList.add("navHide");
        }
    });
}
if (mainElement && navElement) {
    mainElement.addEventListener("click", function () {
        navElement.classList.add("navHide");
        navElement.classList.remove("navShow");
    });
}
document.querySelectorAll("nav a").forEach((item) => {
    item.addEventListener("click", function () {
        if (!navElement) {
            return;
        }
        navElement.classList.add("navHide");
        navElement.classList.remove("navShow");
    });
});


// scroll
let serv = 0;
let btnScrollTop = document.querySelector("#btnScrollTop");

function iniciarContadores() {
    if (serv !== 0) {
        return;
    }

    const numeros = document.querySelectorAll(".number");
    if (!numeros.length) {
        return;
    }

    serv = 1;
    numeros.forEach((item) => {
        item.classList.add("numberShow");
        item.classList.remove("number");
        const max = item.getAttribute("max");
        if (!max) {
            return;
        }
        numberSoma(item, max, 0);
    });
}

function contadoresVisiveis() {
    const secao = document.getElementById("servicos_clientes");
    if (!secao) {
        return false;
    }

    const rect = secao.getBoundingClientRect();
    return rect.top < window.innerHeight && rect.bottom > 0;
}

function scrollFunction() {
    if (
        document.body.scrollTop > 200 ||
        document.documentElement.scrollTop > 200
    ) {
        clearInterval(slide); // parando o slide
        slide = false;

        if (btnScrollTop) {
            btnScrollTop.classList.remove("btnScrollTopHide");
            btnScrollTop.classList.add("btnScrollTopShow");
        }
    } else {
        if (btnScrollTop) {
            btnScrollTop.classList.remove("btnScrollTopShow");
            btnScrollTop.classList.add("btnScrollTopHide");
        }
        if (slide == false) {
            slide = setInterval(slideAction, 5000);
        }
    }

    if (contadoresVisiveis()) {
        iniciarContadores();
    }
}

const secaoContadores = document.getElementById("servicos_clientes");
if (secaoContadores && "IntersectionObserver" in window) {
    const observerContadores = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                iniciarContadores();
                observerContadores.disconnect();
            }
        });
    }, { threshold: 0 });
    observerContadores.observe(secaoContadores);
}

window.addEventListener("scroll", function () {
    scrollFunction();
    addIMG();
});

// function soma rapida quantidade de serviços e clientes
function numberSoma(item, valor, n) {
    const int = setInterval(frame, 1);
    const targetValue = parseFloat(valor);
    function frame() {
        if (!Number.isFinite(targetValue) || n >= targetValue) {
            item.textContent = Number.isFinite(targetValue)
                ? Math.round(targetValue).toLocaleString("pt-BR")
                : "0";
            clearInterval(int);
            return;
        }

        n += 2656;
        if (n > targetValue) {
            n = targetValue;
        }
        item.textContent = Math.round(n).toLocaleString("pt-BR");
    }
}

function normalizeEmail(value) {
    if (!value || typeof value !== "string") {
        return "";
    }
    return value.trim().toLowerCase();
}

function normalizePhone(value) {
    if (!value || typeof value !== "string") {
        return "";
    }

    var digits = value.replace(/\D/g, "");
    if (!digits) {
        return "";
    }

    if (digits.indexOf("55") !== 0) {
        digits = "55" + digits;
    }

    return "+" + digits;
}

function normalizeName(value) {
    if (!value || typeof value !== "string") {
        return "";
    }
    return value.trim().toLowerCase();
}

function buildEnhancedUserData() {
    var payload = {};
    var emailInput = document.querySelector("#email");
    var whatsInput = document.querySelector("#whats");
    var nomeInput = document.querySelector("#nome");

    var email = normalizeEmail(emailInput ? emailInput.value : "");
    var phone = normalizePhone(whatsInput ? whatsInput.value : "");
    var fullName = normalizeName(nomeInput ? nomeInput.value : "");

    if (email) {
        payload.email = email;
    }
    if (phone) {
        payload.phone_number = phone;
    }

    if (fullName) {
        var names = fullName.split(/\s+/);
        if (names.length > 1) {
            payload.address = {
                first_name: names[0],
                last_name: names.slice(1).join(" "),
                country: "BR",
            };
        }
    }

    return payload;
}

function setEnhancedUserDataInPage() {
    if (typeof gtag !== "function") {
        return;
    }

    var userData = buildEnhancedUserData();
    if (!Object.keys(userData).length) {
        return;
    }

    gtag("set", "user_data", userData);
}

var lastWhatsAppClickAt = 0;

function trackWhatsAppClick(url) {
    var now = Date.now();
    if (now - lastWhatsAppClickAt < 1200) {
        return;
    }
    lastWhatsAppClickAt = now;

    setEnhancedUserDataInPage();
    gtag_report_conversion(url);
}

// verificando smartphone / tablet / desk / botão WhatsApp
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    document.querySelectorAll(".btnWhatsApp").forEach((item) => {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            trackWhatsAppClick("https://api.whatsapp.com/send?phone=5511947574606");
        });
    });
} else {
    document.querySelectorAll(".btnWhatsApp").forEach((item) => {
        item.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            trackWhatsAppClick("https://web.whatsapp.com/send?phone=5511947574606");
        });
    });
}

setInterval(function () {
    shakeButton();
}, 1500);

function shakeButton() {
    $(".shaked").toggleClass("shake");
}


// formulário envio email — a mesma regra de conteúdo está em inc/form-contato.php
const mensagemBtn = document.querySelector("#mensagem");
if (mensagemBtn && mensagemBtn.form) {
    const formContato = mensagemBtn.form;
    const valorOriginalBtn = mensagemBtn.value;
    const avisosForm = {
        nome: "Informe um nome com letras, como usamos no atendimento.",
        email: "Informe um e-mail completo, de um endereço que você acessa.",
        whats: "Informe um WhatsApp com DDD. Ex.: (11) 90000-0000.",
        mensagem: "Escreva uma mensagem curta sobre o que você precisa.",
        aguarde: "Aguarde alguns segundos e envie de novo.",
        limite: "Recebemos vários envios deste acesso. Aguarde um pouco e tente de novo.",
        recarregue: "Atualize a página e envie o formulário de novo.",
        bloqueio: "Não foi possível enviar. Revise os dados e tente de novo.",
    };

    function semAcentoForm(valor) {
        return String(valor || "")
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
    }

    function letrasForm(valor) {
        return semAcentoForm(valor).replace(/[^a-z]/g, "");
    }

    function textoAleatorioForm(valor) {
        var letras = letrasForm(valor);
        var tamanho = letras.length;
        var i;
        var t;
        var fatia;
        if (tamanho < 4) {
            return false;
        }
        if (/(.)\1{4,}/.test(letras)) {
            return true;
        }
        var teclas = ["qwertyuiop", "asdfghjkl", "zxcvbnm", "poiuytrewq", "lkjhgfdsa", "mnbvcxz"];
        for (i = 0; i <= tamanho - 4; i++) {
            fatia = letras.substr(i, 4);
            for (t = 0; t < teclas.length; t++) {
                if (teclas[t].indexOf(fatia) !== -1) {
                    return true;
                }
            }
        }
        if (tamanho < 6) {
            return false;
        }
        if (/[bcdfghjklmnpqrstvwxz]{5,}/.test(letras)) {
            return true;
        }
        var alfabeto = ["abcdefghijklmnopqrstuvwxyz", "zyxwvutsrqponmlkjihgfedcba"];
        for (i = 0; i <= tamanho - 5; i++) {
            fatia = letras.substr(i, 5);
            for (t = 0; t < alfabeto.length; t++) {
                if (alfabeto[t].indexOf(fatia) !== -1) {
                    return true;
                }
            }
        }
        var vogais = letras.match(/[aeiouy]/g);
        var proporcao = (vogais ? vogais.length : 0) / tamanho;
        if (tamanho >= 8 && proporcao < 0.18) {
            return true;
        }
        if (tamanho >= 12 && proporcao > 0.92) {
            return true;
        }
        return tamanho >= 8 && bigramaRaroForm(letras);
    }

    function bigramaRaroForm(letras) {
        var raras = {
            bq: 1, bg: 1, bj: 1, bk: 1, bv: 1, bw: 1, bx: 1, bz: 1,
            cb: 1, cf: 1, cg: 1, cj: 1, cq: 1, cv: 1, cw: 1, cx: 1, cz: 1,
            dq: 1, dx: 1, dz: 1, fq: 1, fv: 1, fx: 1, fz: 1, gq: 1, gv: 1, gx: 1, gz: 1,
            hj: 1, hk: 1, hv: 1, hx: 1, hz: 1, jb: 1, jd: 1, jf: 1, jg: 1, jh: 1, jk: 1,
            jl: 1, jm: 1, jp: 1, jq: 1, jr: 1, jt: 1, jv: 1, jw: 1, jx: 1, jz: 1,
            kb: 1, kd: 1, kf: 1, kj: 1, kq: 1, kv: 1, kx: 1, kz: 1,
            lq: 1, lx: 1, lz: 1, mq: 1, mx: 1, mz: 1, pq: 1, pv: 1, px: 1, pz: 1,
            qa: 1, qb: 1, qc: 1, qd: 1, qe: 1, qf: 1, qg: 1, qh: 1, qi: 1, qj: 1, qk: 1,
            ql: 1, qm: 1, qn: 1, qo: 1, qp: 1, qq: 1, qr: 1, qs: 1, qt: 1, qv: 1, qw: 1,
            qx: 1, qy: 1, qz: 1,
            tq: 1, tv: 1, tx: 1, tz: 1, vb: 1, vf: 1, vj: 1, vk: 1, vq: 1, vx: 1, vz: 1,
            wq: 1, wv: 1, wx: 1, wz: 1, xb: 1, xc: 1, xd: 1, xf: 1, xg: 1, xh: 1, xj: 1,
            xk: 1, xl: 1, xm: 1, xn: 1, xp: 1, xq: 1, xr: 1, xs: 1, xu: 1, xv: 1, xw: 1,
            xz: 1, yq: 1, yx: 1, yz: 1, zb: 1, zc: 1, zd: 1, zf: 1, zg: 1, zh: 1, zj: 1,
            zk: 1, zl: 1, zm: 1, zn: 1, zp: 1, zq: 1, zr: 1, zs: 1, zt: 1, zv: 1, zw: 1,
            zx: 1, jj: 1, kk: 1, qq: 1, vv: 1, ww: 1, xx: 1, yy: 1, zz: 1
        };
        var achou = 0;
        var i;
        var par;
        for (i = 0; i < letras.length - 1; i++) {
            par = letras.substr(i, 2);
            if (raras[par]) {
                achou++;
            }
        }
        if (achou >= 2) {
            return true;
        }
        if (achou < 1 || letras.length < 10) {
            return false;
        }
        var vogais = letras.match(/[aeiouy]/g);
        return ((vogais ? vogais.length : 0) / letras.length) < 0.34;
    }

    function caixaAleatoriaForm(valor) {
        try {
            var letras = String(valor || "").replace(/[^\p{L}]/gu, "");
            if (letras.length < 5) {
                return false;
            }
            var anterior = null;
            var trocas = 0;
            var i;
            for (i = 0; i < letras.length; i++) {
                var char = letras.charAt(i);
                var maiuscula = char === char.toUpperCase() && char !== char.toLowerCase();
                if (anterior !== null && anterior !== maiuscula) {
                    trocas++;
                }
                anterior = maiuscula;
            }
            return trocas >= 4 && trocas / letras.length > 0.55;
        } catch (erroCaixa) {
            return false;
        }
    }

    function nomeValidoForm(valor) {
        var nome = String(valor || "").replace(/\s+/g, " ").trim();
        var okLetras = false;
        var palavras;
        var i;
        if (nome.length < 3 || nome.length > 80) {
            return false;
        }
        try {
            okLetras = /^[\p{L}]+(?:[ '\-][\p{L}]+)*$/u.test(nome);
        } catch (erroRegex) {
            okLetras = /^[A-Za-zÀ-ÿ]+(?:[ '\-][A-Za-zÀ-ÿ]+)*$/.test(nome);
        }
        if (!okLetras || nome.split(" ").length > 8 || caixaAleatoriaForm(nome)) {
            return false;
        }
        if (letrasForm(nome).length < 3 || !/[aeiouy]/.test(letrasForm(nome))) {
            return false;
        }
        palavras = nome.split(" ");
        for (i = 0; i < palavras.length; i++) {
            if (textoAleatorioForm(palavras[i])) {
                return false;
            }
        }
        return true;
    }

    function emailValidoForm(valor) {
        var email = String(valor || "").trim().toLowerCase();
        var partes;
        var local;
        var dominio;
        var letras;
        var pedacos;
        var i;
        if (email.length < 6 || email.length > 160 || !/^[^\s@]+@[^\s@]+\.[a-z]{2,24}$/.test(email)) {
            return false;
        }
        partes = email.split("@");
        if (partes.length !== 2) {
            return false;
        }
        local = partes[0].split("+")[0];
        dominio = partes[1];
        if (!/^[a-z0-9](?:[a-z0-9._-]*[a-z0-9])?$/.test(local)) {
            return false;
        }
        if (!/^[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?(?:\.[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?)+$/.test(dominio)) {
            return false;
        }
        letras = letrasForm(local);
        if (letras.length < 2) {
            return local.replace(/\D/g, "").length >= 3 && local.replace(/\D/g, "").length <= 15;
        }
        if (textoAleatorioForm(letras)) {
            return false;
        }
        pedacos = local.split(/[._-]+/);
        for (i = 0; i < pedacos.length; i++) {
            if (!pedacos[i] || textoAleatorioForm(pedacos[i])) {
                return false;
            }
        }
        return true;
    }

    function whatsValidoForm(valor) {
        var digitos = String(valor || "").replace(/\D/g, "");
        if (digitos === "") {
            return true;
        }
        if (digitos.indexOf("55") === 0 && digitos.length >= 12) {
            digitos = digitos.slice(2);
        }
        if (digitos.charAt(0) === "0") {
            digitos = digitos.slice(1);
        }
        if (!/^[1-9]{2}(?:9[0-9]{8}|[2-5][0-9]{7})$/.test(digitos)) {
            return false;
        }
        if (/^(\d)\1+$/.test(digitos) || /(\d)\1{6,}/.test(digitos)) {
            return false;
        }
        return true;
    }

    function mensagemValidaForm(valor) {
        var mensagem = String(valor || "").trim();
        var semLink;
        var palavras;
        var ruins = 0;
        var analisadas = 0;
        var i;
        var so;
        if (mensagem.length < 3 || mensagem.length > 2000) {
            return false;
        }
        semLink = mensagem.replace(/https?:\/\/\S+|www\.\S+/gi, " ");
        if (letrasForm(semLink).length < 2) {
            return false;
        }
        palavras = semAcentoForm(mensagem).trim().split(/\s+/);
        for (i = 0; i < palavras.length; i++) {
            so = letrasForm(palavras[i]);
            if (so.length < 8) {
                continue;
            }
            analisadas++;
            if (textoAleatorioForm(so)) {
                ruins++;
            }
        }
        if (ruins >= 1 && ruins === analisadas && palavras.length <= 2) {
            return false;
        }
        return ruins < 2;
    }

    function mostrarErroForm(campo, texto) {
        var mapa = { nome: "nome", email: "email", whats: "whats", mensagem: "msg" };
        var aviso = formContato.querySelector("#formErro");
        ["nome", "email", "whats", "msg"].forEach(function (id) {
            var el = formContato.querySelector("#" + id);
            if (!el) {
                return;
            }
            el.style.background = "";
            el.removeAttribute("aria-invalid");
        });
        if (aviso) {
            aviso.textContent = texto || "";
            aviso.style.display = texto ? "block" : "none";
        }
        if (mapa[campo]) {
            var alvo = formContato.querySelector("#" + mapa[campo]);
            if (alvo) {
                alvo.style.background = "#ffcccc";
                alvo.setAttribute("aria-invalid", "true");
                alvo.focus();
            }
        }
    }

    ["nome", "email", "whats", "msg"].forEach(function (id) {
        var el = formContato.querySelector("#" + id);
        if (!el) {
            return;
        }
        el.addEventListener("input", function () {
            var aviso = formContato.querySelector("#formErro");
            el.style.background = "";
            el.removeAttribute("aria-invalid");
            if (aviso) {
                aviso.textContent = "";
                aviso.style.display = "none";
            }
        });
    });

    formContato.addEventListener("submit", function (e) {
        e.preventDefault();
        if (mensagemBtn.disabled) {
            return;
        }

        function gtag_report_conversion_form() {
            if (typeof gtag !== "function") {
                return;
            }
            setEnhancedUserDataInPage();
            gtag("event", "conversion", {
                send_to: "AW-1011588590/YuQjCMLE0dMZEO67ruID",
            });
        }

        var nomeEl = formContato.querySelector("#nome");
        var emailEl = formContato.querySelector("#email");
        var whatsEl = formContato.querySelector("#whats");
        var msgEl = formContato.querySelector("#msg");
        var isca = formContato.querySelector('input[name="gs_hp"]');
        var tokenEl = formContato.querySelector("#formToken");
        var token = tokenEl ? tokenEl.value : "";
        var n = nomeEl ? nomeEl.value : "";
        var em = emailEl ? emailEl.value : "";
        var wa = whatsEl ? whatsEl.value : "";
        var m = msgEl ? msgEl.value : "";

        if (isca && isca.value.trim() !== "") {
            mostrarErroForm("bloqueio", avisosForm.bloqueio);
            return;
        }
        if (!/^[0-9]{10}\.[a-f0-9]{32}$/.test(token)) {
            mostrarErroForm("recarregue", avisosForm.recarregue);
            return;
        }
        if (!nomeValidoForm(n)) {
            mostrarErroForm("nome", avisosForm.nome);
            return;
        }
        if (!emailValidoForm(em)) {
            mostrarErroForm("email", avisosForm.email);
            return;
        }
        if (!whatsValidoForm(wa)) {
            mostrarErroForm("whats", avisosForm.whats);
            return;
        }
        if (!mensagemValidaForm(m)) {
            mostrarErroForm("mensagem", avisosForm.mensagem);
            return;
        }

        var url = typeof window.GALLO_FORM_URL === "string" && window.GALLO_FORM_URL !== ""
            ? window.GALLO_FORM_URL
            : "https://gallosound.com.br/action_email.php";
        mensagemBtn.disabled = true;
        mensagemBtn.value = "Enviando...";
        mensagemBtn.setAttribute("aria-busy", "true");
        mensagemBtn.style.cursor = "wait";
        mensagemBtn.style.opacity = "0.72";
        formContato.setAttribute("aria-busy", "true");
        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                nome: n,
                email: em,
                whats: wa,
                mensagem: m,
                gs_hp: isca ? isca.value : "",
                form_token: token,
            }),
        })
            .then(function (r) {
                return r.json();
            })
            .then(function (json) {
                var campo;
                var texto;
                if (!json || json.envio !== true) {
                    campo = json && json.campo ? json.campo : (json && json.email === false ? "email" : "bloqueio");
                    texto = json && json.aviso ? json.aviso : (avisosForm[campo] || avisosForm.bloqueio);
                    mostrarErroForm(campo, texto);
                    return;
                }

                try {
                    gtag_report_conversion_form();
                } catch (erroMedicao) {
                    // A medicao nao pode esconder a confirmacao do envio.
                }

                if (nomeEl) {
                    nomeEl.value = "";
                }
                if (emailEl) {
                    emailEl.value = "";
                }
                if (whatsEl) {
                    whatsEl.value = "";
                }
                if (msgEl) {
                    msgEl.value = "";
                }
                mostrarErroForm("", "");
                var aviso = formContato.querySelector("#formErro");
                if (aviso) {
                    aviso.style.display = "none";
                }
                mensagemBtn.style.opacity = "";
                mensagemBtn.style.cursor = "";
                mensagemBtn.style.background = "#2f8f4e";
                mensagemBtn.style.color = "#fff";
                mensagemBtn.value = "Enviado com sucesso";
                mensagemBtn.removeAttribute("aria-busy");
                formContato.removeAttribute("aria-busy");
                setTimeout(function () {
                    mensagemBtn.disabled = false;
                    mensagemBtn.style.background = "";
                    mensagemBtn.style.color = "";
                    mensagemBtn.value = valorOriginalBtn;
                }, 2500);
            })
            .catch(function () {
                mostrarErroForm(
                    "bloqueio",
                    "Não foi possível enviar agora. Tente de novo em instantes ou chame no WhatsApp."
                );
            })
            .finally(function () {
                if (mensagemBtn.value !== "Enviando...") {
                    return;
                }
                mensagemBtn.disabled = false;
                mensagemBtn.removeAttribute("aria-busy");
                mensagemBtn.style.cursor = "";
                mensagemBtn.style.opacity = "";
                mensagemBtn.value = valorOriginalBtn;
                formContato.removeAttribute("aria-busy");
            });
    });
}
/*
// verificando smartphone / tablet / desk
if (
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
        navigator.userAgent
    )
) {
    document.querySelectorAll(".btnWhatsApp").forEach((item) => {
        item.href = "https://api.whatsapp.com/send?phone=5511947574606";
    });
} else {
    document.querySelectorAll(".btnWhatsApp").forEach((item) => {
        item.href = "https://web.whatsapp.com/send?phone=5511947574606";
        item.target = "blank";
    });
}
    */

/*
function slider() {
    document.querySelectorAll('.banner .slide').forEach((item, index)=>{
        if(index == slide) {
            item.classList.add('action');
            
        } else {
            item.classList.remove('action');
        }
        
    });
    if(slide == 2) {
        slide = 0;
    } else {
        slide++;
    }
}


function goToByScroll(id) {
    let go = document.querySelector("#"+id).offsetTop;
    let here = '';
    if(iOS = /^(iPhone|iPad|iPod)/.test(navigator.platform)) {
        here = document.body.scrollTop;
    } else {
        here = document.documentElement.scrollTop;
    }

    let inter = setInterval(frame, 1);
    function frame() {
        if (here == go) {
          clearInterval(inter);
        } else {
            if(here > go) {
                here--;
            } else {
                here++;
            }
            window.scrollTo(0, here);
        }
    }
}



$('#slidearea1').fadeOut();$('#slidearea2').fadeIn();
$('#slidearea1').slideDown();$('#slidearea2').fadeIn();

*/
