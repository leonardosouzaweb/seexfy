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
    console.log('Current path:', path); // Log para depurar o caminho atual
    var fileName = path.split('/').pop().split('.')[0];
    console.log('File name:', fileName); // Log para depurar o nome do arquivo
    var menuItems = document.querySelectorAll('.bottomMenu div');

    menuItems.forEach(function(item) {
        var icon = item.querySelector('.menu-icon');
        if (icon) {
            if (item.id === fileName) {
                item.classList.add('active');
                console.log('Adding active class to:', item.id); // Log para depurar a adição da classe active
                // Trocar a imagem quando estiver ativo
                switch (fileName) {
                    case 'home':
                        icon.src = 'assets/images/icons/iconHomeActive.svg';
                        break;
                    case 'eventos':
                        icon.src = 'assets/images/icons/iconEventActive.svg';
                        break;
                    case 'radar':
                        icon.src = 'assets/images/icons/iconRadarActive.svg';
                        break;
                    case 'chat':
                        icon.src = 'assets/images/icons/iconChatActive.svg';
                        break;
                    default:
                        break;
                }
            } else {
                item.classList.remove('active');
                // Voltar para a imagem original quando não estiver ativo
                switch (item.id) {
                    case 'home':
                        icon.src = 'assets/images/icons/iconHome.svg';
                        break;
                    case 'eventos':
                        icon.src = 'assets/images/icons/iconEvent.svg';
                        break;
                    case 'radar':
                        icon.src = 'assets/images/icons/iconRadar.svg';
                        break;
                    case 'chat':
                        icon.src = 'assets/images/icons/iconChat.svg';
                        break;
                    default:
                        break;
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', setActiveClass);
window.addEventListener('popstate', setActiveClass);




