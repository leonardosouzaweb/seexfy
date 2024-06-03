<div class="modal fade" id="single" tabindex="-1" aria-labelledby="singleLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<div class="headProfile">
					<div class="avatar">
						<img src="<?php echo $user["avatar"]; ?>" alt="">
					</div>
					<div class="info">
						<h3><?php echo $user["username"]; ?></h3>
						<p><?php echo $user["city"]; ?></p>
						<!-- <span class="badge"><img src="assets/images/icons/iconBadge.svg">Verificado</span> -->
					</div>
				</div>
				<div class="infoProfile">
					<span>Informações</span>
					<ul>
						<li>Idade <span><?php echo $user["age"]; ?></span></li>
						<li>Orientação Sexual <span><?php echo $user["sexualOrientation"]; ?></span></li>
						<li>Signo <span><?php echo $user["sign"]; ?></span></li>
						<li>Altura <span><?php echo $user["height"]; ?></span></li>
						<li>Fuma <span><?php echo $user["smokes"]; ?></span></li>
						<li>Bebe <span><?php echo $user["drink"]; ?></span></li>
						<li>Tempo de Experiência <span><?php echo $user["experience"]; ?></span></li>
					</ul>
					<div class="divider"></div>
					<span>Interesses</span>
					<p><?php echo $user["interests"]; ?></p>
					<div class="divider"></div>
					<span>Descrição</span>
					<p><?php echo $user["description"]; ?></p>

					<a href="profile.php"><button data-bs-dismiss="modal" aria-label="Close">Curtir</button></a>
				</div>
			</div>
		</div>
	</div>
</div>
