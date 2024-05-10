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