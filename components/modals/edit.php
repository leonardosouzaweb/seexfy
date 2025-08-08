<!-- Modal Editar Usuário (Homem) -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h2>Editar Perfil</h2>
        <p>Preencha as informações do seu perfil</p>

        <form action="../components/modals/partials/updateUser.php" method="POST">
          <!-- ID oculto do usuário -->
          <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id'] ?? '') ?>">

          <div class="d-flex justify-content-between gap-2 mt-2">
            <div class="w-25">
              <label>Idade:</label>
              <input type="number" name="idade" class="form-control" required value="<?= htmlspecialchars($user['idade'] ?? '') ?>">
            </div>

            <div class="w-75">
              <label>Orientação Sexual:</label>
              <select name="orientacao" class="form-select" required>
                <option value="">Selecione...</option>
                <?php
                $opcoesOrientacao = ["Heterossexual", "Homossexual", "Bissexual", "Pansexual", "Assexual", "Outro"];
                foreach ($opcoesOrientacao as $opt) {
                  $selected = (($user['orientacao'] ?? '') === $opt) ? 'selected' : '';
                  echo "<option value=\"" . htmlspecialchars($opt) . "\" $selected>" . htmlspecialchars($opt) . "</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <label class="mt-3">Signo:</label>
          <select name="signo" class="form-select" required>
            <option value="">Selecione</option>
            <?php
            $signos = ["Áries", "Touro", "Gêmeos", "Câncer", "Leão", "Virgem", "Libra", "Escorpião", "Sagitário", "Capricórnio", "Aquário", "Peixes"];
            foreach ($signos as $signo) {
              $selected = (($user['signo'] ?? '') === $signo) ? 'selected' : '';
              echo "<option value=\"" . htmlspecialchars($signo) . "\" $selected>" . htmlspecialchars($signo) . "</option>";
            }
            ?>
          </select>

          <div class="others d-flex justify-content-between gap-2 mt-2">
            <div class="flex-fill">
              <label>Altura:</label>
              <input type="text" name="altura" id="alturaInput" class="form-control" required value="<?= htmlspecialchars($user['altura'] ?? '') ?>" placeholder="Ex: 1,75">
            </div>

            <div class="flex-fill">
              <label>Fuma:</label>
              <select name="fuma" class="form-select" required>
                <option value="Sim" <?= (($user['fuma'] ?? '') === 'Sim') ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= (($user['fuma'] ?? '') === 'Não') ? 'selected' : '' ?>>Não</option>
              </select>
            </div>

            <div class="flex-fill">
              <label>Bebe:</label>
              <select name="bebe" class="form-select" required>
                <option value="Sim" <?= (($user['bebe'] ?? '') === 'Sim') ? 'selected' : '' ?>>Sim</option>
                <option value="Não" <?= (($user['bebe'] ?? '') === 'Não') ? 'selected' : '' ?>>Não</option>
              </select>
            </div>
          </div>

          <label class="mt-2">Experiências:</label>
          <textarea id="experienciaTextarea" name="experiencia" class="form-control" required><?= htmlspecialchars($user['experiencia'] ?? '') ?></textarea>

          <div id="experienciaSuggestions" class="mt-2">
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

          <button type="submit" class="mt-4 btn btn-dark w-100">Salvar Informações</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
  
</style>

<script>
  // Máscara simples para campo de altura (formato 0,00)
  const alturaInput = document.getElementById('alturaInput');

  alturaInput.addEventListener('input', function(e) {
    let value = e.target.value;

    // Remove tudo que não for número
    value = value.replace(/[^\d]/g, '');

    // Limita a até 3 dígitos (ex: 175)
    if (value.length > 3) {
      value = value.slice(0, 3);
    }

    // Se tiver 3 dígitos, transforma em formato x,xx
    if (value.length === 3) {
      value = value.slice(0,1) + ',' + value.slice(1);
    } 
    // Se tiver 2 dígitos, transforma em formato x,x
    else if (value.length === 2) {
      value = value.slice(0,1) + ',' + value.slice(1);
    }

    e.target.value = value;
  });

  // Sugestões de experiências clicáveis
  const textarea = document.getElementById('experienciaTextarea');
  const suggestions = document.getElementById('experienciaSuggestions');

  suggestions.addEventListener('click', (e) => {
    if (e.target.classList.contains('suggestion-chip')) {
      const texto = e.target.textContent.trim();

      if (textarea.value.trim() === '') {
        textarea.value = texto;
      } else {
        const partes = textarea.value.split(',').map(s => s.trim());
        if (!partes.includes(texto)) {
          textarea.value += ', ' + texto;
        }
      }
    }
  });
</script>
