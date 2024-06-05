<div class="modal-body">
	<div class="headProfile">
		<div class="avatar">
			<img src="./assets/uploads/<?php echo $row["avatar"]; ?>">
		</div>
		<div class="infoTitle">
			<h3><?php echo $row["username"]; ?></h3>
			<p><?php echo $row["city"]; ?></p>
			<!-- <span class="badge"><img src="assets/images/icons/iconBadge.svg">Verificado</span> -->
		</div>
	</div>
	<div class="infoProfile">
		<span>Informações</span>
		<ul>
			<li>Idade <span><?php echo $row["age"]; ?></span></li>
			<li>Orientação Sexual <span><?php echo $row["sexualOrientation"]; ?></span></li>
			<li>Signo <span><?php echo $row["sign"]; ?></span></li>
			<li>Altura <span><?php echo $row["height"]; ?></span></li>
			<li>Fuma <span><?php echo $row["smokes"]; ?></span></li>
			<li>Bebe <span><?php echo $row["drink"]; ?></span></li>
			<li>Tempo de Experiência <span><?php echo $row["experience"]; ?></span></li>
		</ul>
		<div class="divider"></div>
		<span>Interesses</span>
		<p><?php echo $row["interests"]; ?></p>
		<div class="divider"></div>
		<span>Descrição</span>
		<p><?php echo $row["description"]; ?></p>

		<a href="./perfil/<?php echo $row["username"]; ?>"><button data-bs-dismiss="modal" aria-label="Close">Curtir</button></a>
	</div>
</div>