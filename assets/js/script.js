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
    let numberStartElement = document.querySelector("#startNumber");
    if (!numberStartElement) {
        return;
    }
    let numberServ = numberStartElement.offsetTop;
    if (
        numberServ < document.body.scrollTop ||
        (numberServ < document.documentElement.scrollTop && serv == 0)
    ) {
        document.querySelectorAll(".number").forEach((item) => {
            item.classList.add("numberShow");
            item.classList.remove("number");
            let max = item.attributes.getNamedItem("max").value;
            let n = 0;
            numberSoma(item, max, n);
        });
        serv++;
    }
}

window.addEventListener("scroll", function () {
    scrollFunction();
    addIMG();
});

// function soma rapida quantidade de serviços e clientes
function numberSoma(item, valor, n) {
    let int = setInterval(frame, 1);
    let targetValue = parseFloat(valor);
    function frame() {
        if (n >= targetValue) {
            clearInterval(int);
        } else {
            n = parseFloat(n + 2656);
            item.textContent = n.toLocaleString("pt-BR");
        }
    }
}

// verificando smartphone / tablet / desk / botão WhatsApp
if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    document.querySelectorAll('.btnWhatsApp').forEach((item)=>{
		item.addEventListener('click', function(){
			gtag_report_conversion('https://api.whatsapp.com/send?phone=5511947574606');
		})
    });
} else {
    document.querySelectorAll('.btnWhatsApp').forEach((item)=>{
		item.addEventListener('click', function(){
			gtag_report_conversion('https://web.whatsapp.com/send?phone=5511947574606');
		});
	});
}

setInterval(function () {
    shakeButton();
}, 1500);

function shakeButton() {
    $(".shaked").toggleClass("shake");
}


// formulário envio email
const mensagemBtn = document.querySelector("#mensagem");
if (mensagemBtn) {
    mensagemBtn.addEventListener("click", function (e) {
        e.preventDefault();

        function gtag_report_conversion_form() {
            if (typeof gtag !== "function") {
                return;
            }
            gtag("event", "conversion", {
                send_to: "AW-1011588590/YuQjCMLE0dMZEO67ruID",
            });
        }

    let n = document.querySelector("#nome").value;
    let em = document.querySelector("#email").value;
    let wa = document.querySelector("#whats").value;
    let m = document.querySelector("#msg").value;

        if (n.length < 3) {
            document.querySelector("#nome").style.background = "#ffcccc";
            document.querySelector("#nome").focus();
            return;
        }
        if (em.length < 3) {
            document.querySelector("#email").style.background = "#ffcccc";
            document.querySelector("#email").focus();
            return;
        }
        if (m.length < 3) {
            document.querySelector("#msg").style.background = "#ffcccc";
            document.querySelector("#msg").focus();
            return;
        }

        const url = "https://gallosound.com.br/action_email.php";
        const params = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                nome: n,
                email: em,
                whats: wa,
                mensagem: m,
            }),
        };
        fetch(url, params)
            .then((r) => r.json())
            .then((json) => {
                if (json.email === false) {
                    document.querySelector("#email").style.background = "#ffcccc";
                    document.querySelector("#email").focus();
                    return;
                }
                if (json.envio === true) {
                    // ação conversão do form site
                    gtag_report_conversion_form();

                    document.querySelector("#nome").value = "";
                    document.querySelector("#email").value = "";
                    document.querySelector("#whats").value = "";
                    document.querySelector("#msg").value = "";
                    document.querySelector("#nome").style.background = "";
                    document.querySelector("#email").style.background = "";
                    document.querySelector("#msg").style.background = "";
                    mensagemBtn.style.background = "#33cc33";
                    mensagemBtn.style.color = "#000";
                    mensagemBtn.value = "Enviado com Sucesso";
                    setTimeout(function () {
                        mensagemBtn.style.background = "#B28756";
                        mensagemBtn.style.color = "#FFF";
                        mensagemBtn.value = "ENVIAR";
                    }, 2000);
                }
            })
            .catch(function () {
                mensagemBtn.style.background = "#ffcccc";
                mensagemBtn.style.color = "#000";
                mensagemBtn.value = "Erro ao enviar";
                setTimeout(function () {
                    mensagemBtn.style.background = "#B28756";
                    mensagemBtn.style.color = "#FFF";
                    mensagemBtn.value = "ENVIAR";
                }, 2000);
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
