<div class="headProfile">
    <div>
        <span><?php echo ($user['username']); ?></span>
        <p>Mora em <?php echo ($user['city']); ?></p>
    </div>

    <div>
        <button>Interagir</button>
    </div>
</div>

<div class="infoProfile">
    <div class="detailProfileSingle" style="display:<?php echo $displaySingle; ?>;">
        <span>Informações 
        <?php if ($isOwner): ?>
            <img src="<?php echo $base_url; ?>assets/images/icons/icEdit.svg" data-bs-toggle="modal" data-bs-target="#modalEditUser">
        <?php endif; ?>
        </span>
        <ul>
            <li>Idade <span><?php echo ($user['age']) ? ($user['age']) . ' anos' : '---'; ?></span></li>
            <li>Orientação Sexual <span><?php echo ($user['sexualOrientation']) ? ($user['sexualOrientation']) : '---'; ?></span></li>
            <li>Signo <span><?php echo ($user['sign']) ? ($user['sign']) : '---'; ?></span></li>
            <li>Altura <span><?php echo ($user['height']) ? ($user['height']) . 'cm' : '---'; ?></span></li>
            <li>Fuma <span><?php echo ($user['smokes']) ? ($user['smokes']) : '---'; ?></span></li>
            <li>Bebe <span><?php echo ($user['drink']) ? ($user['drink']) : '---'; ?></span></li>
            <li>Tempo de Experiência <span><?php echo ($user['experience']) ? ($user['experience']) : '---'; ?></span></li>
        </ul>
        <div class="divider"></div>

        <span>Interesses</span>
        <p><?php echo !empty($user['interests']) ? ($user['interests']) : '---'; ?></p>
        <div class="divider"></div>

        <span>Descrição</span>
        <p><?php echo !empty($user['description']) ? ($user['description']) : '---'; ?></p>
        <div class="divider"></div>

        <span>Galeria de Fotos</span>
        <div class="gallery">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="addImage">
                            <img src="<?php echo $base_url; ?>assets/images/icons/iconGallery.svg" class="iconGallery">
                            <p class="iconGallery">Adicionar imagem</p>

                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <div class="detailProfileGroup" style="display:<?php echo $displayGroup; ?>;">
        <ul class="nav nav-tabs" id="infoProfile" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="woman-tab" data-bs-toggle="tab" data-bs-target="#woman-tab-pane" type="button" role="tab" aria-controls="woman-tab-pane" aria-selected="false">Mulher</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="man-tab" data-bs-toggle="tab" data-bs-target="#man-tab-pane" type="button" role="tab" aria-controls="man-tab-pane" aria-selected="false">Homem</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="couple-tab" data-bs-toggle="tab" data-bs-target="#couple-tab-pane" type="button" role="tab" aria-controls="couple-tab-pane" aria-selected="true">Casal</button>
            </li>
        </ul>
        <div class="tab-content" id="infoProfileContent">
            <div class="tab-pane fade show active filter" id="woman-tab-pane" role="tabpanel" aria-labelledby="woman-tab" tabindex="0">
                <!-- MULHER -->
                <span>Informações 
                <?php if ($isOwner): ?>
                    <img src="<?php echo $base_url; ?>assets/images/icons/icEdit.svg" data-bs-toggle="modal" data-bs-target="#modalEditUser">
                <?php endif; ?>
                </span>
                <ul>
                    <li>Idade <span><?php echo ($user['age']) ? ($user['age']) . ' anos' : '---'; ?></span></li>
                    <li>Orientação Sexual <span><?php echo ($user['sexualOrientation']) ? ($user['sexualOrientation']) : '---'; ?></span></li>
                    <li>Signo <span><?php echo ($user['sign']) ? ($user['sign']) : '---'; ?></span></li>
                    <li>Altura <span><?php echo ($user['height']) ? ($user['height']) . 'cm' : '---'; ?></span></li>
                    <li>Fuma <span><?php echo ($user['smokes']) ? ($user['smokes']) : '---'; ?></span></li>
                    <li>Bebe <span><?php echo ($user['drink']) ? ($user['drink']) : '---'; ?></span></li>
                    <li>Tempo de Experiência <span><?php echo ($user['experience']) ? ($user['experience']) : '---'; ?></span></li>
                </ul>
                <div class="divider"></div>

                <span>Interesses</span>
                <p><?php echo !empty($user['interests']) ? ($user['interests']) : '---'; ?></p>
                <div class="divider"></div>

                <span>Descrição</span>
                <p><?php echo !empty($user['description']) ? ($user['description']) : '---'; ?></p>
                <div class="divider"></div>

                <span>Galeria de Fotos</span>
                <div class="gallery">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>120</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>

                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>227</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>
                            
                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>360</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <!-- // -->
            </div>
            <div class="tab-pane fade filter" id="man-tab-pane" role="tabpanel" aria-labelledby="man-tab" tabindex="0">
                <!-- HOMEM -->
                <span>Informações 
                <?php if ($isOwner): ?>
                    <img src="<?php echo $base_url; ?>assets/images/icons/icEdit.svg" data-bs-toggle="modal" data-bs-target="#modalEditPartner">
                <?php endif; ?>
                </span>
                <ul>
                    <li>Idade <span><?php echo ($user['agePartner']) ? ($user['agePartner']) . ' anos' : '---'; ?></span></li>
                    <li>Orientação Sexual <span><?php echo ($user['sexualOrientationPartner']) ? ($user['sexualOrientationPartner']) : '---'; ?></span></li>
                    <li>Signo <span><?php echo ($user['signPartner']) ? ($user['signPartner']) : '---'; ?></span></li>
                    <li>Altura <span><?php echo ($user['heightPartner']) ? ($user['heightPartner']) . 'cm' : '---'; ?></span></li>
                    <li>Fuma <span><?php echo ($user['smokesPartner']) ? ($user['smokesPartner']) : '---'; ?></span></li>
                    <li>Bebe <span><?php echo ($user['drinkPartner']) ? ($user['drinkPartner']) : '---'; ?></span></li>
                    <li>Tempo de Experiência <span><?php echo ($user['experiencePartner']) ? ($user['experiencePartner']) : '---'; ?></span></li>
                </ul>
                <div class="divider"></div>

                <span>Interesses</span>
                <p><?php echo !empty($user['interests']) ? ($user['interests']) : '---'; ?></p>
                <div class="divider"></div>

                <span>Descrição</span>
                <p><?php echo !empty($user['description']) ? ($user['description']) : '---'; ?></p>
                <div class="divider"></div>

                <span>Galeria de Fotos</span>
                <div class="gallery">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>120</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>

                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>227</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <!-- // -->
            </div>
            <div class="tab-pane fade filter" id="couple-tab-pane" role="tabpanel" aria-labelledby="couple-tab" tabindex="0">
                <!-- CASAL -->
                <span>Galeria de Fotos</span>
                <div class="gallery">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>120</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>

                            <div class="swiper-slide">
                                <div class="like">
                                    <img src="<?php echo $base_url; ?>assets/images/icons/iconHeart.svg">
                                    <small>227</small>
                                </div>
                                <img src="<?php echo $base_url; ?>assets/images/gallery/1.png">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
                <!-- // -->
            </div>
        </div>
    </div>
    <div class="space"></div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="title">
                    <span>Editar Informações <img src="<?php echo $base_url; ?>assets/images/icons/icClose.svg" data-bs-dismiss="modal" aria-label="Close"></span>
                </div>

                <label for="ageInput">Idade</label>
                <input type="text" class="form-control" id="ageInput" value="<?php echo ($user['age']); ?>">

                <label for="orientationInput">Orientação Sexual</label>
                <input type="text" class="form-control" id="orientationInput" value="<?php echo ($user['sexualOrientation']); ?>">

                <label for="signInput">Signo</label>
                <input type="text" class="form-control" id="signInput" value="<?php echo ($user['sign']); ?>">

                <div class="itens">
                    <div>
                        <label for="heightInput">Altura</label>
                        <input type="text" class="form-control" id="heightInput" value="<?php echo ($user['height']); ?>">
                    </div>

                    <div>
                        <label for="smokesInput">Fuma</label>
                        <input type="text" class="form-control" id="smokesInput" value="<?php echo ($user['smokes']); ?>">
                    </div>

                    <div>
                        <label for="drinkInput">Bebe</label>
                        <input type="text" class="form-control" id="drinkInput" value="<?php echo ($user['drink']); ?>">
                    </div>
                </div>

                <label for="experienceInput">Tempo de Experiência no Meio Liberal</label>
                <input type="text" class="form-control" id="experienceInput" value="<?php echo ($user['experience']); ?>">

                <label for="descriptionInput">Descrição</label>
                <textarea class="form-control" id="descriptionInput"></textarea>

                <button onclick="saveUserData()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPartner" tabindex="-1" aria-labelledby="modalEditPartnerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="title">
                    <span>Editar Informações2 <img src="<?php echo $base_url; ?>assets/images/icons/icClose.svg" data-bs-dismiss="modal" aria-label="Close"></span>
                </div>

                <label for="ageInputPartner">Idade</label>
                <input type="text" class="form-control" id="ageInputPartner" value="<?php echo ($user['agePartner']); ?>">

                <label for="sexualOrientationPartner">Orientação Sexual</label>
                <input type="text" class="form-control" id="sexualOrientationPartner" value="<?php echo ($user['sexualOrientationPartner']); ?>">

                <label for="signInputPartner">Signo</label>
                <input type="text" class="form-control" id="signInputPartner" value="<?php echo ($user['signPartner']); ?>">

                <div class="itens">
                    <div>
                        <label for="heightInputPartner">Altura</label>
                        <input type="text" class="form-control" id="heightInputPartner" value="<?php echo ($user['heightPartner']); ?>">
                    </div>

                    <div>
                        <label for="smokesInputPartner">Fuma</label>
                        <input type="text" class="form-control" id="smokesInputPartner" value="<?php echo ($user['smokesPartner']); ?>">
                    </div>

                    <div>
                        <label for="drinkInputPartner">Bebe</label>
                        <input type="text" class="form-control" id="drinkInputPartner" value="<?php echo ($user['drinkPartner']); ?>">
                    </div>
                </div>

                <label for="experienceInputPartner">Tempo de Experiência no Meio Liberal</label>
                <input type="text" class="form-control" id="experienceInputPartner" value="<?php echo ($user['experiencePartner']); ?>">

                <button onclick="saveUserPartner()">Salvar</button>
            </div>
        </div>
    </div>
</div>