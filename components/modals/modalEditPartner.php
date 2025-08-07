<!-- Modal Editar Parceira(o) -->
<div class="modal fade" id="modalEditPartner" tabindex="-1" aria-labelledby="modalEditPartnerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h2>Editar Parceira(o)</h2>
        <p>Preencha as informações da(o) sua(seu) parceira(o)</p>

        <form action="../components/modals/partials/updateUser.php" method="POST">
          <!-- ID oculto do usuário -->
          <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

          <label>Idade:</label>
          <input type="number" name="partner_idade" class="form-control" required value="<?= $partner['idade'] ?? '' ?>">

          <label>Orientação Sexual:</label>
          <select name="partner_orientacao" class="form-select" required>
            <option value="">Selecione...</option>
            <?php
            $opcoesOrientacao = ["Heterossexual", "Homossexual", "Bissexual", "Pansexual", "Assexual", "Outro"];
            foreach ($opcoesOrientacao as $opt) {
              $selected = ($partner['orientacao'] ?? '') === $opt ? 'selected' : '';
              echo "<option value=\"$opt\" $selected>$opt</option>";
            }
            ?>
          </select>

          <label>Signo</label>
          <select name="partner_signo" class="form-select" required>
            <option value="">Selecione</option>
            <?php
            $signos = ["Áries", "Touro", "Gêmeos", "Câncer", "Leão", "Virgem", "Libra", "Escorpião", "Sagitário", "Capricórnio", "Aquário", "Peixes"];
            foreach ($signos as $signo) {
              $selected = ($partner['signo'] ?? '') === $signo ? 'selected' : '';
              echo "<option value=\"$signo\" $selected>$signo</option>";
            }
            ?>
          </select>

          <div class="others d-flex justify-content-between gap-2 mt-2">
            <div class="flex-fill">
              <label>Altura</label>
              <input type="text" name="partner_altura" class="form-control" required value="<?= $partner['altura'] ?? '' ?>">
            </div>

            <div class="flex-fill">
              <label>Fuma?</label>
              <input type="text" name="partner_fuma" class="form-control" required value="<?= $partner['fuma'] ?? '' ?>">
            </div>

            <div class="flex-fill">
              <label>Bebe?</label>
              <input type="text" name="partner_bebe" class="form-control" required value="<?= $partner['bebe'] ?? '' ?>">
            </div>
          </div>

          <label class="mt-2">Experiência no Liberal</label>
          <input type="text" name="partner_experiencia" class="form-control" required value="<?= $partner['experiencia'] ?? '' ?>">

          <button type="submit" class="mt-4 btn btn-dark w-100">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>
