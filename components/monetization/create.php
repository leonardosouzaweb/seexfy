<div class="monetizationP">
    <div class="container">
        <h1>Assinaturas</h1>
        <span>Defina um valor para seus conteúdos privados.</span>
        <form id="monetizationForm">
            <div class="price">
                <label>Mensal</label>
                <input type="text" class="form-control" id="monthlyPrice" oninput="formatCurrency(this)">
            </div>

            <div class="price">
                <label>Trimestral</label>
                <input type="text" class="form-control" id="quarterlyPrice" oninput="formatCurrency(this)">
            </div>

            <div class="price">
                <label>Anual</label>
                <input type="text" class="form-control" id="annualPrice" oninput="formatCurrency(this)">
            </div>
            <p>Você pode conferir seus ganhos e assinaturas <a href="<?php echo $base_url; ?>/monetization">clicando aqui</a>. 
            As assinaturas funcionam da seguinte maneira, 90% fica para o criador e 10% é para plataforma Seexfy, ao ativar
            você declara que concorda com os termos acima.</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="termsCheck" onchange="toggleSaveButton()">
                <label class="form-check-label" for="termsCheck">Declaro que li e aceito os termos.</label>
            </div>
            <button type="submit" id="saveButton" disabled>Salvar</button>
        </form>
    </div>
</div>

<script>
    // Função para formatar os valores como moeda (R$)
    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
        value = (value / 100).toFixed(2); // Converte para formato de moeda
        value = value.replace('.', ','); // Substitui ponto por vírgula

        input.value = 'R$ ' + value.replace(/(\d)(\d{3})$/, '$1.$2').replace(/(\d)(\d{3})\.(\d{3})$/, '$1,$2.$3');
    }

    // Função para habilitar/desabilitar o botão de salvar
    function toggleSaveButton() {
        const checkBox = document.getElementById("termsCheck");
        const saveButton = document.getElementById("saveButton");
        saveButton.disabled = !checkBox.checked; // Habilita o botão apenas se a checkbox for marcada
    }

    // Redirecionamento ao clicar no botão salvar
    document.getElementById("monetizationForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Impede o envio do formulário
        window.location.href = '<?php echo $base_url; ?>/monetization'; // Redireciona para a página de monetização
    });
</script>