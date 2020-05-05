// adicionando função scroll
document.querySelectorAll('.scroll').forEach((item)=>{
    item.addEventListener('click', topFunction);
})
// When the user clicks on the button, scroll to the top of the document
function topFunction(e) {
    e.preventDefault();
    let id = '#'+this.getAttribute("data-action");
    let go = $(id).position().top;
    $('html, body').animate({scrollTop:go}, 'slow');
}

var slide = setInterval(slideAction, 5000);
window.load =  slide;

// função SLIDE HOME
function slideAction() {
    if($(".slideAction").next().length){
        $(".slideAction").fadeOut().removeClass("slideAction").next().fadeIn().addClass("slideAction");
        $(".active").removeClass("active").next().addClass("active");
    } else {
        $(".slideAction").fadeOut().removeClass("slideAction");
        $('#slidearea0').fadeIn().addClass("slideAction");
        $(".active").removeClass("active");
        $("#pointerBanner0").addClass("active");
    }

}
// CLICK POINTER TROCA SLIDE
let pointer = 0;
document.querySelectorAll('.banner .pointer').forEach((item, index)=>{
    item.addEventListener('click', function(e){
        e.preventDefault();
        clearInterval(slide);
        slide = false;

        pointer = index;

        $(".slideAction").fadeOut().removeClass("slideAction");
        $('#slidearea'+pointer).fadeIn().addClass("slideAction");

        $(".active").removeClass("active");
        $("#pointerBanner"+pointer).addClass("active");
        
        setTimeout(()=>{
            clearInterval(slide);
            slide = false;
            slide = setInterval(slideAction, 5000);
        }, 5000);
    });
});


document.querySelector("nav").style.transition = "all 0.3s linear";
document.querySelector(".menu-opener").addEventListener("click", function(){
    if(document.querySelector("nav").classList == 'navHide') {
        document.querySelector("nav").classList.remove('navHide');
        document.querySelector("nav").classList.add('navShow');
    } else {
        document.querySelector("nav").classList.remove('navShow');
        document.querySelector("nav").classList.add('navHide');
    }
});
document.querySelector("main").addEventListener("click", function(){
    document.querySelector("nav").classList.add('navHide');
    document.querySelector("nav").classList.remove('navShow');
});
document.querySelectorAll("nav a").forEach((item)=>{
    item.addEventListener("click", function(){
        document.querySelector("nav").classList.add('navHide');
        document.querySelector("nav").classList.remove('navShow');
    });
});

let serv = 0;
let btnScrollTop = document.querySelector('#btnScrollTop');
function scrollFunction() {
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    
    clearInterval(slide); // parando o slide
    slide=false;

    btnScrollTop.classList.remove('btnScrollTopHide');
    btnScrollTop.classList.add('btnScrollTopShow');
  } else {
    btnScrollTop.classList.remove('btnScrollTopShow');
    btnScrollTop.classList.add('btnScrollTopHide');
    if(slide == false) {
        slide = setInterval(slideAction, 5000);
    }
  }
    let numberServ = document.querySelector('#startNumber').offsetTop;
    if( numberServ < document.body.scrollTop ||  numberServ < document.documentElement.scrollTop && serv == 0) {
        document.querySelectorAll('.number').forEach((item)=>{
            item.classList.add('numberShow');
            item.classList.remove('number');
            let max = item.attributes.getNamedItem("max").value;
            let n =0;
            numberSoma(item, max, n);
        });
        serv++;
    }
}

window.onscroll = function() {scrollFunction()};


// function soma rapida
function numberSoma(item, valor, n) {
    let int = setInterval(frame, 1);
    function frame() {
        if(n >= valor) {
            clearInterval(int);
        } else {
            n = parseFloat(n+2656);
            item.innerHTML = n.toLocaleString('pt-BR');
        }
    }
    
}

document.querySelector("#mensagem").addEventListener('click', function(e){
    e.preventDefault();
    let n = document.querySelector('#nome').value;
    let em = document.querySelector('#email').value;
    let a = document.querySelector('#assunto').value;
    let m = document.querySelector('#msg').value;

    if(n.length < 3) {
        alert('preencha campo NOME corretamente');
        document.querySelector("#nome").style.background = '#ffcccc';
        document.querySelector("#nome").focus();
        return;
    }
    if(em.length < 3) {
        alert('preencha campo EMAIL corretamente');
        document.querySelector("#email").style.background = '#ffcccc';
        document.querySelector("#email").focus();
        return;
    }
    if(a.length < 3) {
        alert('preencha campo ASSUNTO corretamente');
        document.querySelector("#assunto").style.background = '#ffcccc';
        document.querySelector("#assunto").focus();
        return;
    }
    if(m.length < 3) {
        alert('preencha campo MENSAGEM');
        document.querySelector("#msg").style.background = '#ffcccc';
        document.querySelector("#msg").focus();
        return;
    }

    const url = 'https://gallosound.websiteseguro.com/new_site_black/action_email.php';
    const params = {
        method:'POST',
        body:JSON.stringify({
            nome:n,
            email:em,
            ass:a,
            mensagem:m
        })
    };
    fetch(url, params)
        .then((r)=>r.json())
        .then((json)=>{
            console.log(json);
            if(json.email == false) {
                alert('erro no campo email');
                document.querySelector("#email").style.background = '#ffcccc';
                document.querySelector("#email").focus();
                return;
            }
            if(json.envio ==  true) {
                alert('EMAIL ENVIADO COM SUCESSO!')
                document.querySelector('#nome').value = "";
                document.querySelector('#email').value = "";
                document.querySelector('#assunto').value = "";
                document.querySelector('#msg').value = "";
                document.querySelector("#nome").style.background = '';
                document.querySelector("#email").style.background = '';
                document.querySelector("#assunto").style.background = '';
                document.querySelector("#msg").style.background = '';
            }
        });

});

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