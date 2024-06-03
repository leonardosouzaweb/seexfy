<div class="topMenu">
    <div class="menu">
        <img id="menuIcon" src="assets/images/icons/iconMenu.svg" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <ul class="menuList">
            <a href="./home.php"><li>Explorar</li></a>
            <a href="events.php"><li>Eventos</li></a>
            <a href="radar.php"><li>Radar</li></a>
            <a href="assinatura.php"><li>Assinatura</li></a>
            <a href="configuracoes.php"><li>Configurações</li></a>
            <a href="ajuda.php"><li>Ajuda</li></a>
            <a href="./"><li>Sair</li></a>
        </ul>
    </div>
    <div class="logo">
        <a href="home.php"><img src="assets/images/logo.svg" alt="Logo Seexyfy"></a>
    </div>

    <div class="nav">
        <div>
            <!-- <img src="assets/images/icons/iconFilter.svg"> -->
        </div>
        <div>
            <a href="search.php"><img src="assets/images/icons/iconSearch.svg"></a>
        </div>
        <div>
            <div class="avatar">
                <a href="profile.php"><img src="<?php echo ($user['avatar']); ?>"></a>
            </div>
        </div>
    </div>
    <div class="overlay" style="display:none"></div>
</div>
