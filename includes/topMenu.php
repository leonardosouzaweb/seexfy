<div class="topMenu">
    <div class="menu">
        <img id="menuIcon" src="<?php echo $base_url; ?>assets/images/icons/iconMenu.svg" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <ul class="menuList">
            <a href="<?php echo $base_url; ?>home"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconHomeBlack.svg"> Explorar <small>Encontre pessoas</small></li></a>
            <a href="<?php echo $base_url; ?>eventos"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconEventBlack.svg"> Eventos <small>Os melhores eventos</small></li></a>
            <a href="<?php echo $base_url; ?>radar"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconRadarBlack.svg"> Radar <small>Hora do match!</small></li></a>
            <a href="<?php echo $base_url; ?>assinatura"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconAssBlack.svg"> Assinatura <small>Não vai esquecer em</small></li></a>
            <a href="<?php echo $base_url; ?>ajuda"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconHelpBlack.svg"> Ajuda <small>Podemos te ajudar!</small></li></a>
            <a href="<?php echo $base_url; ?>logout"><li><img src="<?php echo $base_url; ?>assets/images/icons/iconLogoutBlack.svg"> Sair <small>Já vai embora?</small></li></a>
        </ul>
    </div>
    <div class="logo">
        <a href="<?php echo $base_url; ?>home"><img src="<?php echo $base_url; ?>assets/images/logo.svg" alt="Logo Seexyfy"></a>
    </div>

    <div class="nav">
        <div>
            <!-- <img src="assets/images/icons/iconFilter.svg"> -->
        </div>
        <div>
            <a href="<?php echo $base_url; ?>pesquisar"><img src="<?php echo $base_url; ?>assets/images/icons/iconSearch.svg"></a>
        </div>
        <div>
            <div class="avatar">
                <a href="<?php echo $base_url; ?>perfil/<?php echo ($_SESSION["username"]); ?>">
                    <img src="<?php echo $base_url; ?>assets/images/icons/icUser.svg">
                </a>
            </div>
        </div>
    </div>
    <div class="overlay" style="display:none"></div>
</div>
