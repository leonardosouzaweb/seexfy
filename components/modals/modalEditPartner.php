<!-- Modal Editar Parceira(o) -->
<div class="modal fade" id="modalEditPartner" tabindex="-1" aria-labelledby="modalEditPartnerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h2>Editar Parceira(o)</h2>
        <p>Preencha as informações da(o) sua(seu) parceira(o)</p>

        <form action="../components/modals/partials/updateUser.php" method="POST">
          <!-- ID oculto do usuário -->
          <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

          <label>Idade:</label>
          <input type="number" name="partner_idade" class="form-control" required value="<?= htmlspecialchars($partner['idade'] ?? '') ?>">

          <label>Orientação Sexual:</label>
          <select name="partner_orientacao" class="form-select" required>
            <option value="">Selecione...</option>
            <?php
            $opcoesOrientacao = ["Heterossexual", "Homossexual", "Bissexual", "Pansexual", "Assexual", "Outro"];
            foreach ($opcoesOrientacao as $opt) {
              $selected = (($partner['orientacao'] ?? '') === $opt) ? 'selected' : '';
              echo "<option value=\"" . htmlspecialchars($opt) . "\" $selected>" . htmlspecialchars($opt) . "</option>";
            }
            ?>
          </select>

          <label class="mt-3">Signo</label>
          <select name="partner_signo" class="form-select" required>
            <option value="">Selecione</option>
            <?php
            $signos = ["Áries", "Touro", "Gêmeos", "Câncer", "Leão", "Virgem", "Libra", "Escorpião", "Sagitário", "Capricórnio", "Aquário", "Peixes"];
            foreach ($signos as $signo) {
              $selected = (($partner['signo'] ?? '') === $signo) ? 'selected' : '';
              echo "<option value=\"" . htmlspecialchars($signo) . "\" $selected>" . htmlspecialchars($signo) . "</option>";
            }
            ?>
          </select>

          <div class="others d-flex justify-content-between gap-2 mt-2">
            <div class="flex-fill">
              <label>Altura</label>
              <input type="text" name="partner_altura" id="partnerAlturaInput" class="form-control" required value="<?= htmlspecialchars($partner['altura'] ?? '') ?>" placeholder="Ex: 1,75">
            </div>

            <div class="flex-fill">
              <label>Fuma?</label>
              <select name="partner_fuma" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="Sim" <?= (($partner['fuma'] ?? '') === 'Sim') ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= (($partner['fuma'] ?? '') === 'Não') ? 'selected' : '' ?>>Não</option>
              </select>
            </div>

            <div class="flex-fill">
              <label>Bebe?</label>
              <select name="partner_bebe" class="form-select" required>
                <option value="">Selecione...</option>
                <option value="Sim" <?= (($partner['bebe'] ?? '') === 'Sim') ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= (($partner['bebe'] ?? '') === 'Não') ? 'selected' : '' ?>>Não</option>
              </select>
            </div>
          </div>

          <label class="mt-2">Experiências</label>
          <textarea id="partnerExperienciaTextarea" name="partner_experiencia" class="form-control" required><?= htmlspecialchars($partner['experiencia'] ?? '') ?></textarea>

          <div id="partnerExperienciaSuggestions" class="mt-2">
            <span class="suggestion-chip">Mesmo Ambiente</span>
            <span class="suggestion-chip">Troca de Carícias</span>
            <span class="suggestion-chip">Troca de Carícias (Elas)</span>
            <span class="suggestion-chip">Troca de Carícias (Eles)</span>
            <span class="suggestion-chip">Bi Feminino</span>
            <span class="suggestion-chip">Bi Masculino</span>
            <span class="suggestion-chip">Ménage Feminino</span>
            <span class="suggestion-chip">Ménage Masculino</span>
            <span class="suggestion-chip">Ménage Feminino c/ Bi</span>
            <span class="suggestion-chip">Ménage Masculino c/ Bi</span>
            <span class="suggestion-chip">Troca de Casais</span>
            <span class="suggestion-chip">Grupal</span>
          </div>

          <button type="submit" class="mt-4 btn btn-dark w-100">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  // Máscara simples para campo de altura no parceiro (formato 0,00)
  function aplicarMascaraAltura(input) {
    input.addEventListener('input', function(e) {
      let value = e.target.value;

      value = value.replace(/[^\d]/g, '');

      if (value.length > 3) {
        value = value.slice(0, 3);
      }

      if (value.length === 3) {
        value = value.slice(0,1) + ',' + value.slice(1);
      } else if (value.length === 2) {
        value = value.slice(0,1) + ',' + value.slice(1);
      }

      e.target.value = value;
    });
  }

  aplicarMascaraAltura(document.getElementById('partnerAlturaInput'));

  // Sugestões de experiências clicáveis no parceiro
  const partnerTextarea = document.getElementById('partnerExperienciaTextarea');
  const partnerSuggestions = document.getElementById('partnerExperienciaSuggestions');

  partnerSuggestions.addEventListener('click', (e) => {
    if (e.target.classList.contains('suggestion-chip')) {
      const texto = e.target.textContent.trim();

      if (partnerTextarea.value.trim() === '') {
        partnerTextarea.value = texto;
      } else {
        const partes = partnerTextarea.value.split(',').map(s => s.trim());
        if (!partes.includes(texto)) {
          partnerTextarea.value += ', ' + texto;
        }
      }
    }
  });
</script>
