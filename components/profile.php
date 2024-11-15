<div class="profileP">
    <div class="container">
        <div class="avatar">
            <div>
                <img src="<?php echo $base_url; ?>/images/defaultAvatar.svg">
                <div class="upload">
                    <img src="<?php echo $base_url; ?>/images/icons/black/iconUpload.svg">
                </div>
            </div>
            <div>
                <span>Username</span>
                <p>Cidade</p>
            </div>
            <div>
                <button>Interagir</button>
            </div>
        </div>

        <div class="profileDetailtSingle">
            <h3>Informações <img src="<?php echo $base_url; ?>/images/icons/black/iconEditProfile.svg" data-bs-toggle="modal" data-bs-target="#modalEditUser"></h3>
            <ul>
                <li>Idade: <span></span></li>
                <li>Orientação Sexual: <span></span></li>
                <li>Signo: <span></span></li>
                <li>Altura: <span></span></li>
                <li>Fuma: <span></span></li>
                <li>Bebe: <span></span></li>
                <li>Experiência no Liberal: <span></span></li>
            </ul>

            <h3>Interesses</h3>
            <p>Mulheres</p>

            <h3>Galeria de Fotos</h3>
            <div class="photos">
                <?php include_once '../components/gallery.php' ?>
            </div>
        </div>

        <div class="profileDetailGroup" style="display:none">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="man-tab" data-bs-toggle="tab" data-bs-target="#man-tab-pane" type="button" role="tab" aria-controls="man-tab-pane" aria-selected="true"><img src="<?php echo $base_url; ?>/images/icons/normal/icMan.svg">Homem</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="woman-tab" data-bs-toggle="tab" data-bs-target="#woman-tab-pane" type="button" role="tab" aria-controls="woman-tab-pane" aria-selected="false"><img src="<?php echo $base_url; ?>/images/icons/normal/icWoman.svg">Mulher</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="man-tab-pane" role="tabpanel" aria-labelledby="man-tab" tabindex="0">
                    <h3>Informações</h3>
                    <ul>
                        <li>Idade: <span></span></li>
                        <li>Orientação Sexual: <span></span></li>
                        <li>Signo: <span></span></li>
                        <li>Altura: <span></span></li>
                        <li>Fuma: <span></span></li>
                        <li>Bebe: <span></span></li>
                        <li>Experiência no Liberal: <span></span></li>
                    </ul>
                    
                    <h3>Interesses</h3>
                    <p></p>

                    <h3>Galeria de Fotos</h3>
                    <div class="empty" style="display:none">
                        <img src="<?php echo $base_url; ?>/images/icons/normal/icImage.svg">
                        <span>Adicionar imagens</span>
                    </div>
                    <div class="photos">
                        <?php include_once '<?php echo $base_url; ?>/pages/layouts/components/gallery-user.php' ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="woman-tab-pane" role="tabpanel" aria-labelledby="woman-tab" tabindex="0">
                    <h3>Informações</h3>
                    <ul>
                        <li>Idade: <span></span></li>
                        <li>Orientação Sexual: <span></span></li>
                        <li>Signo: <span></span></li>
                        <li>Altura: <span></span></li>
                        <li>Fuma: <span></span></li>
                        <li>Bebe: <span></span></li>
                        <li>Experiência no Liberal: <span></span></li>
                    </ul>

                    
                    <h3>Interesses</h3>
                    <p></p>

                    <h3>Galeria de Fotos</h3>
                    <div class="empty" style="display:none">
                        <img src="<?php echo $base_url; ?>/images/icons/normal/icImage.svg">
                        <span>Adicionar imagens</span>
                    </div>
                    <div class="photos">
                        <?php include_once '../components/gallery.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>