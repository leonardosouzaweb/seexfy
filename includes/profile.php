<div class="headProfile">
    <div>
        <form id="avatarUploadForm" enctype="multipart/form-data">
            <div class="avatarProfile">
                <img src="<?php echo $base_url; ?>assets/uploads/users/<?php echo ($user['username']); ?>/<?php echo ($user['avatar']); ?>" id="avatarImage">
                <?php if ($isOwner): ?>
                <input type="file" id="avatarInput" name="avatar" style="display:none;">
                <img src="<?php echo $base_url; ?>assets/images/icons/icCamera.svg" class="upload" id="uploadIcon">
                <?php endif; ?>
            </div>
        </form>
        <div class="infoUser">
            <span><?php echo ($user['username']); ?></span>
            <p><?php echo ($user['city']); ?></p>
        </div>
    </div>

    <?php if (!isset($_SESSION['username']) || $_SESSION['username'] !== $user['username']): ?>
    <div>
        <button id="interactButton" data-username="<?php echo ($user['username']); ?>">Interagir</button>
    </div>
    <?php endif; ?>
</div>

<div class="infoProfile">
    <div class="detailProfileSingle <?php echo $classSingle; ?>" style="display:<?php echo $displaySingle; ?>;">
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
            <?php if ($isOwner): ?>
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" id="photoInput" class="inputfile" name="photoInput" accept="image/*" multiple/>
                <label for="photoInput"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Selecionar foto</span></label>
            </form>
            <?php endif; ?>

            <div class="photo-grid">
                <?php
                    $username = $_GET['username'];
                    $sqlPhotos = "SELECT id, photo_path, likes, is_hidden, is_public FROM users_photos WHERE user_id = (
                        SELECT id FROM users WHERE username = ?
                    )";
                    $stmtPhotos = $conn->prepare($sqlPhotos);
                    $stmtPhotos->bind_param("s", $username);
                    $stmtPhotos->execute();
                    $resultPhotos = $stmtPhotos->get_result();

                    if ($resultPhotos->num_rows > 0) {
                        while ($photo = $resultPhotos->fetch_assoc()) {
                            // Verifica se a foto é pública ou se o usuário logado é o proprietário
                            if ($photo['is_public'] || $isOwner) {
                                $iconClass = $photo['is_hidden'] ? 'bi-eye-slash-fill' : 'bi-eye-fill';
                                echo '<div class="photo-item">';
                                echo '<img class="modal-trigger" src="' . $photo['photo_path'] . '" alt="User Photo">';
                                echo '<div class="photo-actions">';
                                echo '<button class="like-button" data-photo-id="' . $photo['id'] . '">';
                                echo '<i class="bi bi-heart-fill"></i>';
                                echo '<span class="like-count">' . $photo['likes'] . '</span>';
                                echo '</button>';
                                if ($isOwner) {
                                    echo '<button class="hide-button" data-photo-id="' . $photo['id'] . '">';
                                    echo '<i class="bi ' . $iconClass . '"></i>';
                                    echo '</button>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    } else {
                        echo '<p>Você não publicou nenhuma foto!</p>';
                    }
                ?>
            </div>

        </div>
    </div>

    <div class="detailProfileGroup <?php echo $classGroup; ?>" style="display:<?php echo $displayGroup; ?>;">
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
                    <?php if ($isOwner): ?>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="file" id="photoInput" class="inputfile" name="photoInput" accept="image/*" multiple/>
                        <label for="photoInput"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Selecionar foto</span></label>
                    </form>
                    <?php endif; ?>

                    <div class="photo-grid">
                    <?php
                        $username = $_GET['username'];
                        $sqlPhotos = "SELECT photo_path FROM users_photos WHERE user_id = (
                            SELECT id FROM users WHERE username = ?
                        )";
                        $stmtPhotos = $conn->prepare($sqlPhotos);
                        $stmtPhotos->bind_param("s", $username);
                        $stmtPhotos->execute();
                        $resultPhotos = $stmtPhotos->get_result();

                        // Verificar se há fotos
                        if ($resultPhotos->num_rows > 0) {
                            echo '<div class="photo-grid">';
                            while ($photo = $resultPhotos->fetch_assoc()) {
                                echo '<div class="photo-item"><img class="modal-trigger" src="' . $photo['photo_path'] . '" alt="User Photo"></div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<p>Você não publicou nenhuma foto!</p>';
                        }
                    ?>
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
                <?php if ($isOwner): ?>
                <form id="uploadForm" enctype="multipart/form-data">
                    <input type="file" id="photoInput" class="inputfile" name="photoInput" accept="image/*" multiple/>
                    <label for="photoInput"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Selecionar foto</span></label>
                </form>
                <?php endif; ?>

                <div class="photo-grid">
                <?php
                    $username = $_GET['username'];
                    $sqlPhotos = "SELECT photo_path FROM users_photos WHERE user_id = (
                        SELECT id FROM users WHERE username = ?
                    )";
                    $stmtPhotos = $conn->prepare($sqlPhotos);
                    $stmtPhotos->bind_param("s", $username);
                    $stmtPhotos->execute();
                    $resultPhotos = $stmtPhotos->get_result();

                    if ($resultPhotos->num_rows > 0) {
                        echo '<div class="photo-grid">';
                        while ($photo = $resultPhotos->fetch_assoc()) {
                            echo '<div class="photo-item">';
                            echo '<img class="modal-trigger" src="' . $photo['photo_path'] . '" alt="User Photo">';
                            if ($isOwner) {
                                echo '<button class="hide-button" data-photo-id="' . $photo['photo_path'] . '"><i class="bi bi-eye-fill"></i></button>';
                            }
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<p>Você não publicou nenhuma foto!</p>';
                    }
                ?>
                </div>
            </div>

                <!-- // -->
            </div>
            <div class="tab-pane fade filter" id="couple-tab-pane" role="tabpanel" aria-labelledby="couple-tab" tabindex="0">
                <!-- CASAL -->
                <span>Galeria de Fotos</span>
                <div class="gallery">
                    <?php if ($isOwner): ?>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="file" id="photoInput" class="inputfile" name="photoInput" accept="image/*" multiple/>
                        <label for="photoInput"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Selecionar foto</span></label>
                    </form>
                    <?php endif; ?>

                    <div class="photo-grid">
                    <?php
                        $username = $_GET['username'];
                        $sqlPhotos = "SELECT photo_path FROM users_photos WHERE user_id = (
                            SELECT id FROM users WHERE username = ?
                        )";
                        $stmtPhotos = $conn->prepare($sqlPhotos);
                        $stmtPhotos->bind_param("s", $username);
                        $stmtPhotos->execute();
                        $resultPhotos = $stmtPhotos->get_result();

                        // Verificar se há fotos
                        if ($resultPhotos->num_rows > 0) {
                            echo '<div class="photo-grid">';
                            while ($photo = $resultPhotos->fetch_assoc()) {
                                echo '<div class="photo-item"><img class="modal-trigger" src="' . $photo['photo_path'] . '" alt="User Photo"></div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<p>Você não publicou nenhuma foto!</p>';
                        }
                    ?>
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
                    <span class="mb-2">Editar Informações <img src="<?php echo $base_url; ?>assets/images/icons/icClose.svg" data-bs-dismiss="modal" aria-label="Close"></span>
                </div>

                <label for="orientationInput">Orientação Sexual</label>
                <select class="form-select" id="orientationInput">
                    <option value="">Selecione...</option>
                    <?php 
                    $orientations = ['Heterossexual', 'Homossexual', 'Bissexual', 'Assexual', 'Pansexual'];
                    foreach ($orientations as $orientation) {
                        $selected = $user['sexualOrientation'] == $orientation ? 'selected' : '';
                        echo "<option value='$orientation' $selected>$orientation</option>";
                    }
                    ?>
                </select>

                <label for="signInput">Signo</label>
                <select class="form-select" id="signInput">
                    <option value="">Selecione...</option>
                    <?php 
                    $signs = ['Áries', 'Touro', 'Gêmeos', 'Câncer', 'Leão', 'Virgem', 'Libra', 'Escorpião', 'Sagitário', 'Capricórnio', 'Aquário', 'Peixes'];
                    foreach ($signs as $sign) {
                        $selected = $user['sign'] == $sign ? 'selected' : '';
                        echo "<option value='$sign' $selected>$sign</option>";
                    }
                    ?>
                </select>

                <div class="itens">
                    <div>
                        <label for="ageInput">Idade</label>
                        <input type="text" class="form-control" id="ageInput" value="<?php echo ($user['age']); ?>">
                    </div>
                    <div>
                        <label for="heightInput">Altura</label>
                        <input type="text" class="form-control" id="heightInput" value="<?php echo ($user['height']); ?>">
                    </div>

                    <div>
                        <label for="smokesInput">Fuma</label>
                        <select class="form-select" id="smokesInput">
                            <option value="">Selecione...</option>
                            <?php 
                            $smokesOptions = ['Sim', 'Não'];
                            foreach ($smokesOptions as $option) {
                                $selected = $user['smokes'] == $option ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="drinkInput">Bebe</label>
                        <select class="form-select" id="drinkInput">
                            <option value="">Selecione...</option>
                            <?php 
                            $drinkOptions = ['Sim', 'Não'];
                            foreach ($drinkOptions as $option) {
                                $selected = $user['drink'] == $option ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <label for="experienceInput">Tempo de Experiência no Meio Liberal</label>
                <select class="form-select" id="experienceInput">
                    <option value="">Selecione...</option>
                    <option value="1 Ano">1 Ano</option>
                    <option value="2 Anos">2 Anos</option>
                    <option value="3 Anos">3 Anos</option>
                    <option value="4 Ano4">4 Anos</option>
                    <option value="5 Anos">5 Anos</option>
                    <option value="10 Anos">10+ Anos</option>
                </select>

                <label for="descriptionInput">Descrição</label>
                <textarea class="form-control" id="descriptionInput"><?php echo ($user['description']); ?></textarea>

                <button id="saveButton" onclick="saveUserData()" disabled>Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditPartner" tabindex="-1" aria-labelledby="modalEditPartnerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="title">
                    <span class="mb-2">Editar Informações <img src="<?php echo $base_url; ?>assets/images/icons/icClose.svg" data-bs-dismiss="modal" aria-label="Close"></span>
                </div>

                <label for="sexualOrientationPartner">Orientação Sexual</label>
                <select class="form-select" id="sexualOrientationPartner">
                    <option value="">Selecione...</option>
                    <?php 
                    $orientations = ['Heterossexual', 'Homossexual', 'Bissexual', 'Assexual', 'Pansexual'];
                    foreach ($orientations as $orientation) {
                        $selected = $user['sexualOrientation'] == $orientation ? 'selected' : '';
                        echo "<option value='$orientation' $selected>$orientation</option>";
                    }
                    ?>
                </select>

                <label for="signPartner">Signo</label>
                <select class="form-select" id="signPartner">
                    <option value="">Selecione...</option>
                    <?php 
                    $signs = ['Áries', 'Touro', 'Gêmeos', 'Câncer', 'Leão', 'Virgem', 'Libra', 'Escorpião', 'Sagitário', 'Capricórnio', 'Aquário', 'Peixes'];
                    foreach ($signs as $sign) {
                        $selected = $user['sign'] == $sign ? 'selected' : '';
                        echo "<option value='$sign' $selected>$sign</option>";
                    }
                    ?>
                </select>

                <div class="itens">
                    <div>
                        <label for="agePartner">Idade</label>
                        <input type="text" class="form-control" id="agePartner" value="<?php echo ($user['age']); ?>">
                    </div>
                    <div>
                        <label for="heightPartner">Altura</label>
                        <input type="text" class="form-control" id="heightPartner" value="<?php echo ($user['height']); ?>">
                    </div>

                    <div>
                        <label for="smokesPartner">Fuma</label>
                        <select class="form-select" id="smokesPartner">
                            <option value="">Selecione...</option>
                            <?php 
                            $smokesOptions = ['Sim', 'Não'];
                            foreach ($smokesOptions as $option) {
                                $selected = $user['smokes'] == $option ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="drinkPartner">Bebe</label>
                        <select class="form-select" id="drinkPartner">
                            <option value="">Selecione...</option>
                            <?php 
                            $drinkOptions = ['Sim', 'Não'];
                            foreach ($drinkOptions as $option) {
                                $selected = $user['drink'] == $option ? 'selected' : '';
                                echo "<option value='$option' $selected>$option</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <label for="experiencePartner">Tempo de Experiência no Meio Liberal</label>
                <select class="form-select" id="experiencePartner">
                    <option value="">Selecione...</option>
                    <option value="1 Ano">1 Ano</option>
                    <option value="2 Anos">2 Anos</option>
                    <option value="3 Anos">3 Anos</option>
                    <option value="4 Ano4">4 Anos</option>
                    <option value="5 Anos">5 Anos</option>
                    <option value="10 Anos">10+ Anos</option>
                </select>

                <label for="descriptionInput">Descrição</label>
                <textarea class="form-control" id="descriptionInput"><?php echo ($user['description']); ?></textarea>

                <button id="saveButtonPartner" onclick="saveUserPartner()" disabled>Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="photoModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <img class="modal-content" id="modalImg">
    </div>
</div>