<?php include_once '../inc/globalHead.php' ?>
<main>
  <div class="register">
    <form id="registerForm" method="POST" action="confirm.php">
      <!-- Step 1: Regras -->
      <div class="step step1">
        <img src="<?php echo $base_url; ?>/images/logo.svg">
        <h2>Olá</h2>
        <p>Antes de iniciar o cadastro, siga atentamente às nossas regras!</p>
        <div>
          <span>Dados pessoais</span>
          <p>Para usá-lo você concorda que trataremos dados sensíveis fornecidos por você, no cadastro como: preferências e orientação sexual, que poderão ficar visíveis na plataforma.</p>
        </div>
        <div>
          <span>Sem Fakes!</span>
          <p>Certifique que as informações e fotos compartilhadas no site são verdadeiras.</p>
        </div>
        <div>
          <span>Siga os valores</span>
          <p>Somos um ambiente seguro e receptivo, respeite quem participa e reporte comportamentos que não estejam de acordos com nossas regras.</p>
        </div>
        <div class="buttonsNav">
          <div class="next">Eu Concordo</div>
        </div>
      </div>

      <!-- Step 2: Interesses -->
      <div class="step step2" style="display: none;">
        <h2>Quais são seus interesses?</h2>
        <p>Lembre-se o que você marcar abaixo serão suas recomendações iniciais.</p>
        <div class="scroll">
          <?php
              $interests = [
              "Homens",
              "Homens Transexuais",
              "Mulheres",
              "Mulheres Transexuais",
              "Casais Homem/Mulher",
              "Casais Homem/Homem",
              "Casais Mulher/Mulher",
              "Travestis"
              ];
              foreach ($interests as $i => $value) {
              $id = "interest_" . $i;
              echo "
              <div class='form-check'>
                  <input class='form-check-input interest-checkbox' type='checkbox' name='interests[]' value='{$value}' id='{$id}'>
                  <label class='form-check-label' for='{$id}'>{$value}</label>
              </div>
              ";
              }
          ?>
        </div>
        <div class="buttonsNav">
          <div class="back">Voltar</div>
          <button type="button" class="next" disabled>Continuar</button>
        </div>
      </div>

      <!-- Step 3: Status -->
      <div class="step step3" style="display: none;">
        <h2>Seu status é</h2>
        <p>Solteiro? Casado?</p>
        <select name="maritalStatus" id="maritalStatus" class="form-select" required>
          <option value="">Selecione...</option>
          <option value="Solteiro">Solteiro</option>
          <option value="Solteira">Solteira</option>
          <option value="Casado">Casado</option>
          <option value="Casada">Casada</option>
        </select>
        <div class="buttonsNav">
          <div class="back">Voltar</div>
          <button type="button" class="next" disabled>Continuar</button>
        </div>
      </div>

      <!-- Step 4: Nome de usuário -->
      <div class="step step4" style="display: none;">
        <h2>Como prefere se chamar?</h2>
        <p>Preencha o nome de usuário, as pessoas poderão encontrar mais facilmente!</p>
        <label for="username">Nome de Usuário</label>
        <div class="username" data-valid="false">
            <input type="text" class="form-control" id="username" name="username" required>
            <div class="username-feedback mt-1 hidden"></div>
        </div>
        <div class="buttonsNav">
          <div class="back">Voltar</div>
          <button type="button" class="next" disabled>Continuar</button>
        </div>
      </div>

      <!-- Step 5: Localização -->
      <div class="step step5" style="display: none;">
        <h2>Você está em?</h2>
        <p>Selecione sua cidade para exibir pessoas/casais próximos a você!</p>

        <label for="citySearch" class="form-label">Digite o nome da cidade</label>
        <input type="text" class="form-control mb-3" id="citySearch" placeholder="Ex: São Paulo" autocomplete="off">

        <div id="cityOptions" class="cityOptions"></div>

        <input type="hidden" name="city" id="city" required>

        <div class="buttonsNav">
          <div class="back">Voltar</div>
          <button type="button" class="next" disabled>Continuar</button>
        </div>
      </div>

      <!-- Step 6: Email e senha -->
      <div class="step step6" style="display: none;">
        <h2>Oba! Está acabando.</h2>
        <p>Informe corretamente seu email para ativar sua conta. Ele é privado e não será exibido no perfil.</p>

        <label for="email">Seu melhor e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>

        <label for="password">Senha</label>
        <input type="password" class="form-control" name="password" id="password" required>

        <label for="password_confirmation">Confirmação de Senha</label>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>

        <div class="password-requirements mt-3 space-y-1">
            <p id="lengthRequirement" class="requirement text-red-600"><span class="icon">✗</span> Mínimo de 8 caracteres</p>
            <p id="uppercaseRequirement" class="requirement text-red-600"><span class="icon">✗</span> Pelo menos uma letra maiúscula</p>
            <p id="specialCharRequirement" class="requirement text-red-600"><span class="icon">✗</span> Pelo menos um caractere especial</p>
        </div>

        <div class="buttonsNav">
          <div class="back">Voltar</div>
          <button type="button" class="next" disabled>Continuar</button>
        </div>
      </div>

      <!-- Step 7: Conclusão -->
      <div class="step step7" style="display: none;">
        <img src="<?php echo $base_url; ?>/images/logo.svg">
        <h2>Parabéns!</h2>
        <p>Você concluiu todos os passos! Clique no botão abaixo para finalizar seu cadastro.</p>
        <button type="submit" id="submitRegister">Concluir Registro</button>
      </div>
    </form>
  </div>
</main>

<!-- Rodapé -->
<script>
  const baseUrl = "<?php echo $base_url; ?>";

  // Bloqueia espaços no username
  document.getElementById('username').addEventListener('input', function(e) {
    this.value = this.value.replace(/\s/g, '');
  });

  // Aqui você pode colocar seu JS para navegar entre steps e habilitar botões
</script>
<?php include_once '../inc/globalFooter.php' ?>
