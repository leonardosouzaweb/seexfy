function setActiveNav() {
    var path = window.location.pathname;
    var navMenu = document.querySelectorAll('.navMenu div');

    navMenu.forEach(function(navElement) {
        if (navElement.id && path.includes(navElement.id)) {
            navElement.classList.add('active');
        }
    });
}

setActiveNav();