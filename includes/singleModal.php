<div class="modal-body">
	<div class="headProfile">
		<div class="avatar">
			<img src="./assets/uploads/<?php echo $row["avatar"]; ?>">
		</div>
		<div class="infoTitle">
			<h3><?php echo $row["username"]; ?></h3>
			<p><?php echo $row["city"]; ?></p>
			<?php if ($row["id"] == 1 || $row["id"] == 2): ?>
				<span class="badge"><img src="assets/images/icons/iconFounder.svg">Fundador</span>
			<?php endif; ?>
		</div>
	</div>
	<div class="infoProfile">
		<span>Informações</span>
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
		<p>><?php echo ($row['description']) ? ($row['description']) : '---'; ?></span></p>

		<a href="./perfil/<?php echo $row["username"]; ?>"><button data-bs-dismiss="modal" aria-label="Close">Curtir</button></a>
	</div>
</div>