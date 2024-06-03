<div class="modal fade" id="couple" tabindex="-1" aria-labelledby="coupleLabel" aria-hidden="true">
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
						<!-- // -->
						</div>
						<div class="tab-pane fade filter" id="man-tab-pane" role="tabpanel" aria-labelledby="woman-tab" tabindex="0">
							<ul>
								<li>Idade <span><?php echo $user["agePartner"]; ?></span></li>
								<li>Orientação Sexual <span><?php echo $user["sexualOrientationPartner"]; ?></span></li>
								<li>Signo <span><?php echo $user["signPartner"]; ?></span></li>
								<li>Altura <span><?php echo $user["heightPartner"]; ?></span></li>
								<li>Fuma <span><?php echo $user["smokesPartner"]; ?></span></li>
								<li>Bebe <span><?php echo $user["drinkPartner"]; ?></span></li>
								<li>Tempo de Experiência <span><?php echo $user["experiencePartner"]; ?></span></li>
							</ul>
							<div class="divider"></div>
							<span>Interesses</span>
							<p><?php echo $user["interests"]; ?></p>
							<div class="divider"></div>
							<span>Descrição</span>
							<p><?php echo $user["description"]; ?></p>
							<!-- // -->
						</div>
					</div>
					<button data-bs-dismiss="modal" aria-label="Close">Curtir</button>
				</div>
			</div>
		</div>
	</div>
</div>