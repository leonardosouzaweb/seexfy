<?php include_once '../inc/globalHead.php'?>
<main>
    <div class="register">
        <form id="registerForm" method="POST">
            <div class="step step1">
                <img src="<?php echo $base_url; ?>/images/logo.svg">
                <h2>Olá</h2>
                <p>Antes de iniciar o cadastro, siga atentamente às nossas regras!</p>
                <div>
                    <span>Dados pessoais</span>
                    <p>Para usá-lo você concorda que trataremos dados sensíveis fornecidos por você, no
                    cadastro como: preferências e orientação sexual, que poderão ficar visíveis na plataforma.</p>
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

            <!-- Step 2: Interests Selection -->
            <div class="step step2" style="display: none;">
                <h2>Quais são seus interesses?</h2>
                <p>Lembre-se o que você marcar abaixo serão suas recomendações iniciais.</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Homens" id="homens">
                    <label class="form-check-label" for="homens">Homens</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Homens Transexuais" id="homensTrans">
                    <label class="form-check-label" for="homensTrans">Homens Transexuais</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Mulheres" id="mulheres">
                    <label class="form-check-label" for="mulheres">Mulheres</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Mulheres Transexuais" id="mulheresTrans">
                    <label class="form-check-label" for="mulheresTrans">Mulheres Transexuais</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Casais Homem/Mulher" id="casaishm">
                    <label class="form-check-label" for="casaishm">Casais Homem/Mulher</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Casais Homem/Homem" id="casaishh">
                    <label class="form-check-label" for="casaishh">Casais Homem/Homem</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Casais Mulher/Mulher" id="casaismm">
                    <label class="form-check-label" for="casaismm">Casais Mulher/Mulher</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="interests[]" value="Travestis" id="travestis">
                    <label class="form-check-label" for="travestis">Travestis</label>
                </div>
                <div class="buttonsNav">
                    <div class="back">Voltar</div>
                    <button type="button" class="next" disabled>Continuar</button>
                </div>
            </div>

            <!-- Step 3: Marital Status Selection -->
            <div class="step step3" style="display: none;">
                <h2>Seu status é</h2>
                <p>Solteiro? Casado?</p>
                <select name="marital_status" class="form-select">
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

            <!-- Step 4: Username Selection -->
            <div class="step step4" style="display: none;">
                <h2>Como prefere se chamar?</h2>
                <p>Preencha o nome de usuário, as pessoas poderão encontrar mais facilmente!</p>
                <label>Nome de Usuário</label>
                <div class="username">
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="error-msg" style="display:none;"></div>
                
                <div class="buttonsNav">
                    <div class="back">Voltar</div>
                    <button type="button" class="next" disabled>Continuar</button>
                </div>
            </div>

            <!-- Step 5: Location Selection -->
            <div class="step step5" style="display: none;">
                <h2>Você está em?</h2>
                <p>Vamos usar sua localização para exibir pessoas/casais próximos a você!</p>
                <label>Cidade</label>
                <input type="text" class="form-control" name="city" required>
                <div class="buttonsNav">
                    <div class="back">Voltar</div>
                    <button type="button" class="next" disabled>Continuar</button>
                </div>
            </div>

            <!-- Step 6: Email and Password -->
            <div class="step step6" style="display: none;">
                <h2>Oba! Está acabando.</h2>
                <p>Informe corretamente seu email para ativar sua conta. Ele é privado e não será exibido no perfil.</p>

                <label>Seu melhor e-mail</label>
                <input type="email" class="form-control" name="email" required>
                <label for="password">Senha:</label>
                <input type="password" class="form-control" name="password" id="password" required>

                <label for="password_confirmation">Confirmação de Senha:</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>

                <div class="password-requirements">
                    <p id="lengthRequirement" class="requirement">Mínimo de 8 caracteres</p>
                    <p id="uppercaseRequirement" class="requirement">Pelo menos uma letra maiúscula</p>
                    <p id="specialCharRequirement" class="requirement">Pelo menos um caractere especial</p>
                    <div class="password-error-msg" style="display: none;"></div>
                </div>

                <div class="buttonsNav">
                    <div class="back">Voltar</div>
                    <button type="button" class="next" disabled>Continuar</button>
                </div>
            </div>

            <!-- Step 7: Congratulations -->
            <div class="step step7" style="display: none;">
                <img src="<?php echo $base_url; ?>/images/logo.svg">
                <h2>Parabéns!</h2>
                <p>Você concluiu todos os passos! Para terminar, clique no botão abaixo.</p>
                <button type="submit" id="submitRegister">Concluir Registro</button>
            </div>
        </form>
    </div>
</main>
<?php include_once '../inc/globalFooter.php'?>

<script>
    document.getElementById('submitRegister').addEventListener('click', function (event) {
        event.preventDefault(); // Impede o recarregamento da página

        const formData = new FormData(document.getElementById('registerForm'));
        const interests = Array.from(document.querySelectorAll('input[name="interests[]"]:checked')).map(checkbox => checkbox.value);

        const data = {
            interests: interests,
        };
        formData.forEach((value, key) => {
            if (key in data) {
                if (!Array.isArray(data[key])) {
                    data[key] = [data[key]];
                }
                data[key].push(value);
            } else {
                data[key] = value;
            }
        });

        fetch('http://localhost:3000/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            console.log('Status da resposta:', response.status);
            if (!response.ok) {
                return response.json().then(errorData => {
                    console.log('Erro:', errorData); // Log detalhado do erro
                    throw new Error('Erro na rede');
                });
            }
            return response.json();
        })
        .then(result => {
            console.log('Sucesso:', result); // Exibe o resultado de sucesso no console
            window.location.href = '../auth/login.php';
        })
        .catch(error => {
            console.error('Erro:', error.message); // Exibe o erro no console sem recarregar a página
        });
    });
</script>