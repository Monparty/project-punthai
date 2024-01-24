// button effect

var buttons = document.querySelectorAll('.button');

Array.prototype.forEach.call(buttons, function (b) {
  b.addEventListener('click', createRipple)
});

function createRipple(event) {
  var ripple = document.createElement('span');
  ripple.classList.add('ripple');
  var max = Math.max(this.offsetWidth, this.offsetHeight);
  ripple.style.width = ripple.style.height = max*2 + 'px';
  var rect = this.getBoundingClientRect();
  ripple.style.left = event.clientX - rect.left - max + 'px';
  ripple.style.top = event.clientY - rect.top - max + 'px';
  this.appendChild(ripple);
}

// showSlides

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
let i;
let slides = document.getElementsByClassName("mySlides");
let dots = document.getElementsByClassName("dot");
if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
}

// end showSlides

// sidebar

function openNav() {
    document.getElementById("mySidebar").style.width = "180px";
    document.getElementById("mainSidebar").style.marginLeft = "180px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("mainSidebar").style.marginLeft= "0";
}
// end sidebar

