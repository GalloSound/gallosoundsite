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
    btnScrollTop.classList.remove('btnScrollTopHide');
    btnScrollTop.classList.add('btnScrollTopShow');
  } else {
    btnScrollTop.classList.remove('btnScrollTopShow');
    btnScrollTop.classList.add('btnScrollTopHide');
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
    console.log(n);
    console.log(valor);
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

let slide = 1;
window.load = setInterval(slider, 5000);

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

/*
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
*/