<div class="modal-body">
	<div class="headProfile">
		<div class="avatar">
            <img src="./assets/uploads/<?php echo $row["avatar"]; ?>">
		</div>
		<div class="infoTitle">
			<h3><?php echo $row["username"]; ?></h3>
			<p><?php echo $row["city"]; ?></p>
		</div>
	</div>
	<div class="infoProfile">
    <!-- // -->
    <ul class="nav nav-tabs" id="infoProfile" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="woman-tab" data-bs-toggle="tab" data-bs-target="#woman-tab-pane" type="button" role="tab" aria-controls="woman-tab-pane" aria-selected="false">Mulher</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="man-tab" data-bs-toggle="tab" data-bs-target="#man-tab-pane" type="button" role="tab" aria-controls="man-tab-pane" aria-selected="false">Homem</button>
        </li>
    </ul>
    <!-- // -->
    <div class="tab-content" id="infoProfileContent">
        <div class="tab-pane fade show active filter" id="woman-tab-pane" role="tabpanel" aria-labelledby="couple-tab" tabindex="0">
        <ul>
            <li>Idade <span><?php echo ($row['age']) ? ($row['age']) . ' anos' : '---'; ?></span></li>
            <li>Orientação Sexual <span><?php echo ($row['sexualOrientation']) ? ($row['sexualOrientation']) : '---'; ?></span></li>
            <li>Signo <span><?php echo ($row['sign']) ? ($row['sign']) : '---'; ?></span></li>
            <li>Altura <span><?php echo ($row['height']) ? ($row['height']) . 'cm' : '---'; ?></span></li>
            <li>Fuma <span><?php echo ($row['smokes']) ? ($row['smokes']) : '---'; ?></span></li>
            <li>Bebe <span><?php echo ($row['drink']) ? ($row['drink']) : '---'; ?></span></li>
            <li>Tempo de Experiência <span><?php echo ($row['experience']) ? ($row['experience']) : '---'; ?></span></li>
        </ul>
        <div class="divider"></div>
        <span>Interesses</span>
		<p><?php echo ($row['interests']) ? ($row['interests']) : '---'; ?></span></p>
		<div class="divider"></div>
		<span>Descrição</span>
		<p><?php echo ($row['description']) ? ($row['description']) : '---'; ?></span></p>
        <!-- // -->
        </div>
        <div class="tab-pane fade filter" id="man-tab-pane" role="tabpanel" aria-labelledby="woman-tab" tabindex="0">
            <ul>
                <li>Idade <span><?php echo ($row['agePartner']) ? ($row['agePartner']) . ' anos' : '---'; ?></span></li>
                <li>Orientação Sexual <span><?php echo ($row['sexualOrientationPartner']) ? ($row['sexualOrientationPartner']) : '---'; ?></span></li>
                <li>Signo <span><?php echo ($row['signPartner']) ? ($row['signPartner']) : '---'; ?></span></li>
                <li>Altura <span><?php echo ($row['heightPartner']) ? ($row['heightPartner']) . 'cm' : '---'; ?></span></li>
                <li>Fuma <span><?php echo ($row['smokesPartner']) ? ($row['smokesPartner']) : '---'; ?></span></li>
                <li>Bebe <span><?php echo ($row['drinkPartner']) ? ($row['drinkPartner']) : '---'; ?></span></li>
                <li>Tempo de Experiência <span><?php echo ($row['experiencePartner']) ? ($row['experiencePartner']) : '---'; ?></span></li>
            </ul>
            <div class="divider"></div>
            <span>Interesses</span>
            <p><?php echo ($row['interests']) ? ($row['interests']) : '---'; ?></span></p>
            <div class="divider"></div>
            <span>Descrição</span>
            <p><?php echo ($row['description']) ? ($row['description']) : '---'; ?></span></p>
            <!-- // -->
        </div>
    </div>
    <a href="./perfil/<?php echo $row["username"]; ?>"><button data-bs-dismiss="modal" aria-label="Close">Curtir</button></a>
</div>
</div>