<div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="codeForm" method="post">
                    <div id="codeInputs">
                        <img src="<?php echo $base_url; ?>/images/icons/normal/icCheck.svg" class="guard" id="modalImage">
                        <h2 id="modalTitle">Cadastro de Código</h2>
                        <p class="text-center" id="modalText">Crie um código de 4 dígitos. Ele será solicitado sempre que você acessar a plataforma.</p>
                        <div class="code">
                            <input type="text" class="form-control code-input" id="digit1" tabindex="1" maxlength="1" required>
                            <input type="text" class="form-control code-input" id="digit2" tabindex="2" maxlength="1" required>
                            <input type="text" class="form-control code-input" id="digit3" tabindex="3" maxlength="1" required>
                            <input type="text" class="form-control code-input" id="digit4" tabindex="4" maxlength="1" required>
                        </div>
                        <div id="errorMessage"></div>
                        <button type="submit" class="btn btn-primary" id="submitButton">Cadastrar Código</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
