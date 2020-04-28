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

let btnScrollTop = document.querySelector('#btnScrollTop');
function scrollFunction() {
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
    btnScrollTop.classList.remove('btnScrollTopHide');
    btnScrollTop.classList.add('btnScrollTopShow');
  } else {
    btnScrollTop.classList.remove('btnScrollTopShow');
    btnScrollTop.classList.add('btnScrollTopHide');
  }
}

window.onscroll = function() {scrollFunction()};
    
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