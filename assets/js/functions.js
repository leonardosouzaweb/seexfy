document.addEventListener("DOMContentLoaded", function() {
    const steps = document.querySelectorAll(".step");
    let currentStep = 0;

    function showStep(step) {
        steps.forEach((s, index) => {
            s.style.display = index === step ? "block" : "none";
        });
    }

    document.querySelectorAll(".next").forEach(button => {
        button.addEventListener("click", function() {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    document.querySelectorAll(".back").forEach(button => {
        button.addEventListener("click", function() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    showStep(currentStep);
    
});

function showStep(step) {
    const steps = document.querySelectorAll('.register > .wrapper > div[class^="step"]');
    steps.forEach(function (s) {
        s.style.display = "none";
    });
    step.style.display = "block";
}

const menuIcon = document.getElementById("menuIcon");
const menuList = document.querySelector(".menuList");
const overlay = document.querySelector(".overlay");
let menuOpen = false;

menuIcon.addEventListener("click", function() {
    menuIcon.src = menuOpen ? "assets/images/icons/iconMenu.svg" : "assets/images/icons/iconClose.svg";
    menuList.style.display = menuOpen ? "none" : "block";
    overlay.style.display = menuOpen ? "none" : "block";
    menuOpen = !menuOpen;
});

function setActiveClass() {
    var path = window.location.pathname;
    var fileName = path.split('/').pop().split('.')[0];
    var menuItems = document.querySelectorAll('.bottomMenu div');

    menuItems.forEach(function(item) {
        if (item.id === fileName) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', setActiveClass);
window.addEventListener('popstate', setActiveClass);

