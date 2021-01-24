let featureSlider,testimonialSlider;

//Nav Events
var menu = document.querySelector('.hamburgerMenu'),
    nav = document.querySelector('.header__nav');


menu.onclick = function () {
    nav.classList.toggle('hideNav');
    menu.classList.toggle('makeCross')
};

window.addEventListener('click', function (e) {

    // if( !(nav.contains(e.target)) && e.target!==nav && e.target!==menu && !(menu.contains(e.target)))

    if (e.target !== nav && e.target !== menu && !(menu.contains(e.target))) {
        nav.classList.add('hideNav');
        menu.classList.remove('makeCross')

    }

});



window.addEventListener('load',()=>{
    loadSliders();

    addNavEvent();

})



function loadSliders() {
    if(window.innerWidth>=768 ){

        featureSlider=new Splide( '.featuresSlider', {
            type      : 'loop',
            perPage   : 3,
            height    : '10rem',
            pagination:false,
            arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        }).mount();

        testimonialSlider = new Splide( '.testimonialSlider', {
            type      : 'loop',
            perPage   : 1,
            height    : '30rem',
            // width:'1000px',
            // pagination:false,
            // arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        } ).mount();

    }
    else if(window.innerWidth<768 && window.innerWidth>500){


        testimonialSlider = new Splide( '.testimonialSlider', {
            type      : 'loop',
            perPage   : 1,
            height    : '35rem',
            // pagination:false,
            arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        } ).mount();


        featureSlider=new Splide( '.featuresSlider', {
            type      : 'loop',
            perPage   : 2,
            height    : '10rem',
            pagination:false,
            arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        }).mount();

    }
    else if ( window.innerWidth<=500){

        testimonialSlider = new Splide( '.testimonialSlider', {
            type      : 'loop',
            perPage   : 1,
            height    : '35rem',
            // pagination:false,
            arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        } ).mount();


        featureSlider=new Splide( '.featuresSlider', {
            type      : 'loop',
            perPage   : 1,
            height    : '10rem',
            pagination:false,
            arrows:false,
            autoplay:true,
            interval:3000,
            speed:500,
            perMove:1,
        }).mount();

    }
}



function addNavEvent() {

    let navAnchor = document.querySelectorAll('.header__nav a');

    navAnchor.forEach(nav =>{
        if (nav.dataset.section!==undefined){
            nav.addEventListener('click',()=>smoothScroll(nav.dataset.section))
        }
    })


}


//======================Smooth Scroll Functions==============================================
function currentYPosition() {
    // Firefox, Chrome, Opera, Safari
    if (self.pageYOffset) return self.pageYOffset;
    // Internet Explorer 6 - standards mode
    if (document.documentElement && document.documentElement.scrollTop)
        return document.documentElement.scrollTop;
    // Internet Explorer 6, 7 and 8
    if (document.body.scrollTop) return document.body.scrollTop;
    return 0;
}


function elmYPosition(eID) {
    var elm = document.getElementById(eID);
    var y = elm.offsetTop;
    var node = elm;
    while (node.offsetParent && node.offsetParent != document.body) {
        node = node.offsetParent;
        y += node.offsetTop;
    } return y;
}


function smoothScroll(eID) {
    var startY = currentYPosition();
    var stopY = elmYPosition(eID)-45;
    var distance = stopY > startY ? stopY - startY : startY - stopY;
    if (distance < 100) {
        scrollTo(0, stopY); return;
    }
    var speed = Math.round(distance / 100);
    if (speed >= 20) speed = 20;
    var step = Math.round(distance / 25);
    var leapY = stopY > startY ? startY + step : startY - step;
    var timer = 0;
    if (stopY > startY) {
        for ( var i=startY; i<stopY; i+=step ) {
            setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
            leapY += step; if (leapY > stopY) leapY = stopY; timer++;
        } return;
    }
    for ( var i=startY; i>stopY; i-=step ) {
        setTimeout("window.scrollTo(0, "+leapY+")", timer * speed);
        leapY -= step; if (leapY < stopY) leapY = stopY; timer++;
    }
}

//==================Smooth Scroll Ends================
