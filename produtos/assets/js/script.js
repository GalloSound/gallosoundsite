
document.querySelector(".menuMobile").addEventListener("click", function(){
	if(document.querySelector(".menu nav ul").classList == 'ulMobile show') {
		document.querySelector(".menu nav ul").classList.remove('show');
	} else {
		document.querySelector(".menu nav ul").classList.add('show');
	}
});
document.querySelector(".column").addEventListener("click", function(){
	document.querySelector(".menu nav ul").classList.remove('show');
});

// capturando os links para analytics
let url = '';
var captureOutboundLink = function(e) {
	e.preventDefault();
	url = this.getAttribute('href');
	ga('send', 'event', 'outbound', 'click', url, {
	 'transport': 'beacon',
	 'hitCallback': function(){document.location = url;}
	});
	window.location.href = url;
}

document.querySelectorAll('body a').forEach((item)=>{
	item.addEventListener('click', captureOutboundLink);
});



active = function() {
	if(this.getAttribute("id") == null) {

		document.querySelectorAll("nav li").forEach((item)=>{
			item.classList.remove('active');
		});

		this.classList.add('active');
		document.querySelector(".menu nav ul").classList.remove('show');
	} else {
		document.querySelector(".servicosDesk").classList.remove('showServicos');
	}
}

document.querySelectorAll("nav li").forEach((item)=>{
	item.addEventListener('click', active);
});

let width = document.querySelector("#servicosDesk").offsetWidth;
let left = document.querySelector("#servicosDesk").offsetLeft;
document.querySelector(".servicosDesk").style.left = left;
document.querySelector(".servicosDesk").style.width = width;
document.querySelector(".servicosDesk").style.transition = "max-height 0.3s linear";

document.querySelector("#servicosDesk").addEventListener("mouseover", function() {
	document.querySelector(".servicosDesk").classList.add('showServicos');
});

document.querySelector("#servicosDesk").addEventListener("mouseleave", function() {
	document.querySelector(".servicosDesk").classList.remove('showServicos');
});

// verificando smartphone / tablet / desk
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