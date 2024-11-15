<div class="heading">
    <div class="container">
        <div class="logo">
            <a href="<?php echo $base_url; ?>/home"><img src="<?php echo $base_url; ?>/images/logo.svg"></a>
        </div>

        <div class="group">
            <div class="search">
                <a href="<?php echo $base_url; ?>/search"><img src="<?php echo $base_url; ?>/images/icons/black/iconSearch.svg"></a>
            </div>

            <div class="notification">
                <span>0</span>
                <a href="<?php echo $base_url; ?>/notification"><img src="<?php echo $base_url; ?>/images/icons/black/iconNotification.svg"></a>
            </div>

            <div class="avatar" data-bs-toggle="offcanvas" href="#menuMobile" role="button" aria-controls="menuMobile">
                <img src="<?php echo $base_url; ?>/images/defaultAvatar.svg">
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile" aria-labelledby="menuMobileLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="menuMobileLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="avatar">
            <div>
                <img src="<?php echo $base_url; ?>/images/defaultAvatar.svg">
            </div>
            <div>
                <span>Username</span>
                <a href="<?php echo $base_url; ?>/profile"><p>Ver Perfil</p></a>
            </div>
        </div>
        <ul>
            <li>
                <a href="<?php echo $base_url; ?>/home">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconHome.svg"> Explorar
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/feed">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconFeed.svg"> Feed
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/radar">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconRadar.svg"> Radar
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/payment">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconAss.svg"> Assinatura
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/help">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconHelp.svg"> Ajuda
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconLogout.svg"> Sair
                </a>
            </li>
        </ul>
    </div>
</div>
