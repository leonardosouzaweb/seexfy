<?php 
include_once 'includes/head.php';
include_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar dados do formulário
    $username = $_POST['username'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $interests = implode(", ", $_POST['interests']);
    $maritalStatus = $_POST['maritalStatus'];

    // Definir o valor de gender baseado em maritalStatus
    $gender = '';
    switch ($maritalStatus) {
        case 'Solteiro':
            $gender = 'Masculino';
            break;
        case 'Solteira':
            $gender = 'Feminino';
            break;
        case 'Casado':
            $gender = 'Casado';
            break;
        case 'Casada':
            $gender = 'Casada';
            break;
    }
    
    // Caminho do avatar padrão
    $defaultAvatar = 'defaultAvatar.svg';


    // Inserir dados na tabela 'users'
    $sql = "INSERT INTO users (username, city, email, password, interests, maritalStatus, gender, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $username, $city, $email, $password, $interests, $maritalStatus, $gender, $defaultAvatar);

    if ($stmt->execute()) {
        header("Location: ./entrar");
        exit();
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<body>
<div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <div class="register">
        <div class="wrapper">
            <form id="registerForm" method="POST">
                <!-- Step 1: Introduction and Agreement -->
                <div class="step step1">
                    <img src="<?php echo $base_url; ?>assets/images/logo.svg">
                    <h2>Olá, seja bem vindo a Seexfy!</h2>
                    <small>Antes de iniciar o cadastro, siga atentamente às nossas regras!</small>
                    <div>
                        <span>Dados pessoais</span>
                        <p>O Seexfy é um app de encontros, para usá-lo você concorda que trataremos dados sensíveis fornecidos por você, no cadastro como: preferências e orientação sexual, que poderão ficar visíveis na plataforma.</p>
                    </div>
                    <div>
                        <span>Sem Fakes!</span>
                        <p>Certifique que as informações e fotos compartilhadas no app são verdadeiras.</p>
                    </div>
                    <div>
                        <span>Siga os valores</span>
                        <p>Somos um ambiente seguro e receptivo, respeite quem participa e reporte comportamentos que não estejam de acordos com nossas regras.</p>
                    </div>
                    <div class="next">Eu Concordo</div>
                </div>

                <!-- Step 2: Interests Selection -->
                <div class="step step2" style="display: none;">
                    <h2>Quais são seus interesses?</h2>
                    <small>Lembre-se o que você marcar abaixo serão suas recomendações iniciais.</small>
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
                        <div class="next">Continuar</div>
                    </div>
                </div>

                <!-- Step 3: Username Selection -->
                <div class="step step3" style="display: none;">
                    <h2>Seu status é</h2>
                    <small>Solteiro? Casado?</small>
                    <select name="maritalStatus" class="form-select">
                        <option value="">Selecione...</option>
                        <option value="Solteiro">Solteiro</option>
                        <option value="Solteira">Solteira</option>
                        <option value="Casado">Casado</option>
                        <option value="Casada">Casada</option>
                    </select>
                    <div class="buttonsNav">
                        <div class="back">Voltar</div>
                        <div class="next">Continuar</div>
                    </div>
                </div>

                <!-- Step 3: Username Selection -->
                <div class="step step4" style="display: none;">
                    <h2>Como prefere se chamar?</h2>
                    <small>Preencha o nome de usuário, as pessoas poderão encontrar mais facilmente!</small>
                    <label>Nome de Usuário</label>
                    <div class="username">
                        <input type="text" class="form-control" name="username" required>
                        <span class="availability-icon"></span>
                    </div>
                    <div class="error-msg" style="display: none; color: #e74c3c; font-size: 12px; background: #e74c3c17; padding: 10px 20px; border-radius: 10px; position: relative; top: -9px;">O nome de usuário não pode conter letras maiúsculas, espaços ou caracteres especiais.</div>
                    <div class="buttonsNav">
                        <div class="back">Voltar</div>
                        <div class="next">Continuar</div>
                    </div>
                </div>

                <!-- Step 4: Location Selection -->
                <div class="step step5" style="display: none;">
                    <h2>Você está em?</h2>
                    <small>Vamos usar sua localização para exibir pessoas/casais próximos a você!</small>
                    <label>Cidade</label>
                    <input type="text" class="form-control" name="city" required>   
                    <div class="buttonsNav">
                        <div class="back">Voltar</div>
                        <div class="next">Continuar</div>
                    </div>
                </div>

                <!-- Step 5: Email and Password -->
                <div class="step step6" style="display: none;">
                    <h2>Oba! Está acabando.</h2>
                    <small>Informe corretamente seu email para ativar sua conta. Ele é privado e não será exibido no perfil.</small>
                    <label>Seu melhor e-mail</label>
                    <input type="email" class="form-control" name="email" required>  
                    <label>Senha</label>
                    <input type="password" class="form-control" name="password" required>  
                    <div class="buttonsNav">
                        <div class="back">Voltar</div>
                        <div class="next">Continuar</div>
                    </div>
                </div>

                <!-- Step 6: Congratulations -->
                <div class="step step7" style="display: none;">
                    <img src="<?php echo $base_url; ?>assets/images/icons/iconLogo.svg">
                    <h2>Parabéns!</h2>
                    <small>Você será redirecionado em alguns segundos para acessar a plataforma!</small>
                    <div>
                        <span>Fique atento às Regras!</span>
                        <p>O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500</p>
                    </div>
                    <button type="submit">Acessar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var timeoutId;

            function checkUsernameAvailability(username) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    $.ajax({
                        url: 'api/checkUser.php',
                        method: 'POST',
                        data: { username: username },
                        success: function(response) {
                            if (response === 'disponivel') {
                                $('.availability-icon').removeClass('indisponivel').addClass('disponivel');
                            } else {
                                $('.availability-icon').removeClass('disponivel').addClass('indisponivel');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Erro ao verificar disponibilidade do nome de usuário:', error);
                        }
                    });
                }, 500);
            }

            function validateUsername(username) {
                var regex = /^[a-z0-9_]+$/i; // Aceita apenas letras minúsculas, números e underscore (_)
                return regex.test(username);
            }

            $('input[name="username"]').on('keyup', function() {
                var username = $(this).val().trim();
                var emojiRegex = /[\uD800-\uDBFF][\uDC00-\uDFFF]/;
                if (emojiRegex.test(username)) {
                    $(this).val(username.replace(emojiRegex, ''));
                }
                if (username === '') {
                    $('.error-msg').hide(); // Esconder mensagem de erro quando o campo estiver vazio
                    $('.availability-icon').removeClass('disponivel indisponivel');
                } else {
                    if (validateUsername(username)) {
                        $('.error-msg').hide();
                        if (username.length >= 3) {
                            checkUsernameAvailability(username);
                        } else {
                            $('.availability-icon').removeClass('disponivel indisponivel');
                        }
                    } else {
                        $('.error-msg').show();
                        $('.availability-icon').removeClass('disponivel indisponivel');
                    }
                }
            });
        });

        $(function() {
            $.ajax({
                url: 'https://servicodados.ibge.gov.br/api/v1/localidades/municipios',
                type: 'GET',
                success: function(response) {
                    var cities = response.map(function(city) {
                        return city.nome;
                    });
                    $("input[name='city']").autocomplete({
                        source: cities
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao obter lista de cidades:', error);
                }
            });
        });
    </script>
</body>
</html>