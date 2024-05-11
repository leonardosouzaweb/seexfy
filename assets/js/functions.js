document.addEventListener("DOMContentLoaded", function () {
    const step1 = document.querySelector(".step1");
    const step2 = document.querySelector(".step2");
    const backBtn = document.querySelector(".buttonsNav button:first-of-type");
    const continueBtn = document.querySelector(".buttonsNav button:last-of-type");
    const agreeBtn = document.querySelector(".step1 button");
    const checkboxes = document.querySelectorAll(".form-check input[type='checkbox']");

    step2.style.display = "none";

    function showStep2() {
        step1.style.display = "none";
        step2.style.display = "block";
    }

    function showStep1() {
        step2.style.display = "none";
        step1.style.display = "block";
    }

    function handleCheckbox(event) {
        const checkbox = event.target;
        const formCheck = checkbox.parentElement;
        if (checkbox.checked) {
            formCheck.classList.add("active");
        } else {
            formCheck.classList.remove("active");
        }
    }

    function handleFormCheckClick(event) {
        const formCheck = event.currentTarget;
        const checkbox = formCheck.querySelector("input[type='checkbox']");
        checkbox.checked = !checkbox.checked;
        handleCheckbox({ target: checkbox });
    }

    backBtn.addEventListener("click", showStep1);
    continueBtn.addEventListener("click", showStep2);

    agreeBtn.addEventListener("click", showStep2);

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", handleCheckbox);
    });

    document.querySelectorAll('.form-check').forEach(function (formCheck) {
        formCheck.addEventListener('click', handleFormCheckClick);
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