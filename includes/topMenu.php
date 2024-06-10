<div class="topMenu">
    <div class="menu">
        <img id="menuIcon" src="<?php echo $base_url; ?>assets/images/icons/iconMenu.svg" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <ul class="menuList">
            <a href="<?php echo $base_url; ?>home"><li>Explorar</li></a>
            <a href="<?php echo $base_url; ?>eventos"><li>Eventos</li></a>
            <a href="<?php echo $base_url; ?>radar"><li>Radar</li></a>
            <a href="<?php echo $base_url; ?>assinatura"><li>Assinatura</li></a>
            <a href="<?php echo $base_url; ?>configuracoes"><li>Configurações</li></a>
            <a href="<?php echo $base_url; ?>ajuda"><li>Ajuda</li></a>
            <a href="<?php echo $base_url; ?>logout"><li>Sair</li></a>
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
