document.addEventListener("DOMContentLoaded", function() {
    const planos = document.querySelectorAll('.form-check-input');
    const step1 = document.querySelector('.step1');
    const step2 = document.querySelector('.step2');
    const step3 = document.querySelector('.step3');
    const planoInfo = step2.querySelector('p');
    const valorInfo = step2.querySelector('h3');
    const planoInput = step2.querySelector('input[type="text"]');
    const btnCancelar = step2.querySelector('button');

    function limparPlanos() {
        planos.forEach(function(plano) {
            plano.checked = false;
        });
    }

    function mostrarStep2(planoSelecionado, valorPlano) {
        step1.style.display = 'none'; 
        step2.style.display = 'block'; 
        planoInfo.textContent = `Você selecionou o plano ${planoSelecionado}:`;
        valorInfo.textContent = `R$ ${valorPlano}`;
        
        planoInput.value = '00020126580014br.gov.bcb.pix0136a75c4cd0-8922-4ff8-8fbf-e2ae803c8f18520400005303986540562.005802BR5916RR202212130939016009Sao Paulo62240520mpqrinter9342269351063042487'; // Exemplo fixo do código Pix
    }

    planos.forEach(function(plano) {
        plano.addEventListener('change', function() {
            if (this.checked) {
                limparPlanos();  
                this.checked = true; 
                let planoSelecionado = this.id;
                let valorPlano;

                switch (planoSelecionado) {
                    case 'mensal':
                        valorPlano = '29,90';
                        break;
                    case 'bimestral':
                        valorPlano = '57,00';
                        break;
                    case 'trimestral':
                        valorPlano = '81,00';
                        break;
                    case 'semestral':
                        valorPlano = '152,00';
                        break;
                    case 'anual':
                        valorPlano = '287,00';
                        break;
                }

                mostrarStep2(planoSelecionado, valorPlano); 
            }
        });
    });

    btnCancelar.addEventListener('click', function() {
        step2.style.display = 'none'; 
        step1.style.display = 'block';
        limparPlanos();
    });
});
