<?php 
    include_once 'includes/head.php';
?>
<body>
    <div class="empty">
        <img src="assets/images/logo.svg">
    </div>
    <div class="register">
        <div class="wrapper">
            <div class="step1">
                <img src="assets/images/logo.svg">
                <h2>Olá, seja bem vindo a Seexfy!</h2>
                <small>Antes de iniciar o cadastro, siga atentamente às nossas regras!</small>

                <div>
                    <span>Dados pessoais</span>
                    <p>O Seexfy é um app de encontros, para usá-lo você concorda que trataremos dados sensíveis fornecidos por você, no cadastro
                    como: preferências e orientação sexual, que poderão ficar visíveis na plataforma.</p>
                </div>

                <div>
                    <span>Sem Fakes!</span>
                    <p>Certifique que as informações e fotos compartilhadas no app são verdadeiras.</p>
                </div>

                <div>
                    <span>Siga os valores</span>
                    <p>Somos um ambiente seguro e receptivo, respeite quem participa e reporte comportamentos que não estejam de acordos com nossas regras.</p>
                </div>
                <button>Eu Concordo</button>
            </div>

            <div class="step2">
                <h2>Quais são seus interesses?</h2>
                <small>Lembre-se o que você marcar abaixo serão suas recomendações iniciais.</small>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="homens">
                    <label class="form-check-label" for="homens">Homens</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="homensTrans">
                    <label class="form-check-label" for="homensTrans">Homens Transexuais</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="mulheres">
                    <label class="form-check-label" for="mulheres">Mulheres</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="mulheresTrans">
                    <label class="form-check-label" for="mulheresTrans">Mulheres Transexuais</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="casaishm">
                    <label class="form-check-label" for="casaishm">Casais Homem/Mulher</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="casaishh">
                    <label class="form-check-label" for="casaishh">Casais Homem/Homem</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="casaismm">
                    <label class="form-check-label" for="casaismm">Casais Mulher/Mulher</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="travestis">
                    <label class="form-check-label" for="travestis">Travestis</label>
                </div>

                <div class="buttonsNav">
                    <button>Voltar</button>
                    <button>Continuar</button>
                </div>
            </div>

            <div class="step3">
                <h2>Como você prefere se chamar?</h2>
                <small>Preencha o nome de usuário que mostre o melhor de você!</small>

                <label>Nome de Usuário</label>
                <input type="text" class="form-control">   

                <div class="buttonsNav">
                    <button>Voltar</button>
                    <button>Continuar</button>
                </div>
            </div>

            <div class="step4">
                <h2>Você esta em?</h2>
                <small>Vamos usar sua localização para exibir pessoas/casais próximos a você!</small>

                <label>Cidade</label>
                <input type="text" class="form-control">   

                <div class="buttonsNav">
                    <button>Voltar</button>
                    <button>Continuar</button>
                </div>
            </div>

            <div class="step5" style="display: none;">
                <h2>Oba! Está acabando.</h2>
                <small>Informe corretamente seu email para ativar sua conta. Ele é privado e não será exibido no perfil.</small>

                <label>Seu melhor e-mail</label>
                <input type="email" class="form-control">  

                <label>Senha</label>
                <input type="password" class="form-control">  

                <div class="buttonsNav">
                    <button>Voltar</button>
                    <button>Avançar</button>
                </div>
            </div>

            <div class="step6" style="display: none;">
                <img src="assets/images/icons/iconLogo.svg">
                <h2>Parabéns!</h2>
                <small>Você será redirecionado em alguns segundos para acessar a plataforma!</small>

                <div>
                    <span>Fique atento as Regras!</span>
                    <p>O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem 
                    Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500</p>
                </div>

                <button>Acessar</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html>