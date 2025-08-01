<!-- Modal Editar Usuário (Homem) -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h2>Editar Perfil</h2>
        <p>Preencha as informações do seu perfil</p>

        <form action="../components/modals/partials/updateUser.php" method="POST">
          <!-- ID oculto do usuário -->
          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

          <div class="d-flex justify-content-between gap-2 mt-2">
            <div class="w-25">
              <label>Idade:</label>
              <input type="number" name="idade" class="form-control" required value="<?= $user['idade'] ?? '' ?>">
            </div>

            <div class="w-75">
              <label>Orientação Sexual:</label>
              <select name="orientacao" class="form-select" required>
                <option value="">Selecione...</option>
                <?php
                $opcoesOrientacao = ["Heterossexual", "Homossexual", "Bissexual", "Pansexual", "Assexual", "Outro"];
                foreach ($opcoesOrientacao as $opt) {
                  $selected = ($user['orientacao'] ?? '') === $opt ? 'selected' : '';
                  echo "<option value=\"$opt\" $selected>$opt</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <label>Signo</label>
          <select name="signo" class="form-select" required>
            <option value="">Selecione</option>
            <?php
            $signos = ["Áries", "Touro", "Gêmeos", "Câncer", "Leão", "Virgem", "Libra", "Escorpião", "Sagitário", "Capricórnio", "Aquário", "Peixes"];
            foreach ($signos as $signo) {
              $selected = ($user['signo'] ?? '') === $signo ? 'selected' : '';
              echo "<option value=\"$signo\" $selected>$signo</option>";
            }
            ?>
          </select>

          <div class="others d-flex justify-content-between gap-2 mt-2">
            <div class="flex-fill">
              <label>Altura</label>
              <input type="text" name="altura" class="form-control" required value="<?= $user['altura'] ?? '' ?>">
            </div>

            <div class="flex-fill">
              <label>Fuma?</label>
              <input type="text" name="fuma" class="form-control" required value="<?= $user['fuma'] ?? '' ?>">
            </div>

            <div class="flex-fill">
              <label>Bebe?</label>
              <input type="text" name="bebe" class="form-control" required value="<?= $user['bebe'] ?? '' ?>">
            </div>
          </div>

          <label class="mt-2">Experiência no Liberal</label>
          <textarea name="experiencia" class="form-control" required value="<?= $user['experiencia'] ?? '' ?>"></textarea>

          <button type="submit" class="mt-4 btn btn-dark w-100">Salvar Informações</button>
        </form>
      </div>
    </div>
  </div>
</div>
