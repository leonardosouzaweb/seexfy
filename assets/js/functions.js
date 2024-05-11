document.addEventListener("DOMContentLoaded", function () {
    const step1 = document.querySelector(".step1");
    const step2 = document.querySelector(".step2");
    const backBtn = document.querySelector(".buttonsNav button:first-of-type");
    const continueBtn = document.querySelector(".buttonsNav button:last-of-type");
    const agreeBtn = document.querySelector(".step1 button");
    const checkboxes = document.querySelectorAll(".form-check input[type='checkbox']");

    // Esconde o step2 inicialmente
    step2.style.display = "none";

    // Função para mostrar o step2 e esconder o step1
    function showStep2() {
        step1.style.display = "none";
        step2.style.display = "block";
    }

    // Função para mostrar o step1 e esconder o step2
    function showStep1() {
        step2.style.display = "none";
        step1.style.display = "block";
    }

    // Adiciona ou remove a classe 'active' na form-check quando o input é marcado ou desmarcado
    function handleCheckbox(event) {
        const checkbox = event.target;
        const formCheck = checkbox.parentElement;
        if (checkbox.checked) {
            formCheck.classList.add("active");
        } else {
            formCheck.classList.remove("active");
        }
    }

    // Adiciona event listener para os botões voltar e continuar
    backBtn.addEventListener("click", showStep1);
    continueBtn.addEventListener("click", showStep2);

    // Adiciona event listener para o botão "Eu Concordo"
    agreeBtn.addEventListener("click", showStep2);

    // Adiciona event listener para cada checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", handleCheckbox);
    });
});



function setActiveNav() {
    var path = window.location.pathname;
    var navMenu = document.querySelectorAll('.bottomMenu div');

    navMenu.forEach(function(navElement) {
        if (navElement.id && path.includes(navElement.id)) {
            navElement.classList.add('active');
        }
    });
}

setActiveNav();