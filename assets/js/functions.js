document.addEventListener("DOMContentLoaded", function () {
    const backBtns = document.querySelectorAll(".buttonsNav button:first-of-type");
    const continueBtns = document.querySelectorAll(".buttonsNav button:last-of-type");
    const agreeBtn = document.querySelector(".step1 button");
    const finalizeBtn = document.querySelector(".step5 .buttonsNav button:last-of-type");

    const accessBtn = document.querySelector(".step6 button");
    accessBtn.addEventListener("click", function () {
        window.location.href = "home.php"; 
    });

    function isAtLeastOneInterestSelected() {
        const checkboxes = document.querySelectorAll(".step2 input[type='checkbox']");
        return Array.from(checkboxes).some(checkbox => checkbox.checked);
    }

    function isFieldFilled(field) {
        return field.value.trim() !== "";
    }

    function updateContinueButtonState(step) {
        const continueBtn = step.querySelector(".buttonsNav button:last-of-type");
        switch (step.className) {
            case "step2":
                continueBtn.disabled = !isAtLeastOneInterestSelected();
                break;
            case "step3":
            case "step4":
                const inputField = step.querySelector("input[type='text']");
                continueBtn.disabled = !isFieldFilled(inputField);
                break;
            case "step5":
                const emailField = step.querySelector("input[type='email']");
                const passwordField = step.querySelector("input[type='password']");
                continueBtn.disabled = !isFieldFilled(emailField) || !isFieldFilled(passwordField);
                break;
            default:
                break;
        }
    }

    backBtns.forEach(function(backBtn) {
        backBtn.addEventListener("click", function () {
            const currentStep = document.querySelector('.register > .wrapper > div[class^="step"]:not([style*="none"])');
            const previousStep = currentStep.previousElementSibling;
            showStep(previousStep);
        });
    });

    continueBtns.forEach(function(continueBtn) {
        continueBtn.addEventListener("click", function () {
            const currentStep = document.querySelector('.register > .wrapper > div[class^="step"]:not([style*="none"])');
            const nextStep = currentStep.nextElementSibling;
            if (nextStep) {
                showStep(nextStep);
                updateContinueButtonState(nextStep); 
            } else {
                const lastStep = document.querySelector('.register > .wrapper > div.step6');
                showStep(lastStep);
            }
        });
    });

    agreeBtn.addEventListener("click", function () {
        const step = document.querySelector('.step2');
        showStep(step);
        updateContinueButtonState(step); 
    });

    finalizeBtn.addEventListener("click", function () {
        const step = document.querySelector('.step5');
        showStep(step);
        updateContinueButtonState(step);
    
        // Verifica se o botão clicado foi o de "Avançar"
        if (finalizeBtn.textContent === "Avançar") {
            const nextStep = document.querySelector('.step6');
            showStep(nextStep);
        }
    });

    const checkboxes = document.querySelectorAll(".step2 input[type='checkbox']");
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            const step = document.querySelector('.step2');
            updateContinueButtonState(step); 
        });
    });

    const textFields = document.querySelectorAll(".step3 input[type='text'], .step4 input[type='text'], .step5 input[type='email'], .step5 input[type='password']");
    textFields.forEach(function (textField) {
        textField.addEventListener("input", function () {
            const step = textField.closest("div[class^='step']");
            updateContinueButtonState(step);
        });
    });
    showStep(document.querySelector('.step1'));
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