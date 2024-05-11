function gerarNumeroAleatorioUnico() {
    let numerosDisponiveis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    let numeroAleatorio = '';

    for (let i = 0; i < 6; i++) {
        // Escolhe um índice aleatório da lista de números disponíveis
        const indice = Math.floor(Math.random() * numerosDisponiveis.length);

        // Adiciona o número selecionado à sequência e remove-o da lista
        numeroAleatorio += numerosDisponiveis.splice(indice, 1);
    }

    return numeroAleatorio;
}

window.addEventListener('DOMContentLoaded', (event) => {
    // Seleciona todas as imagens com a classe "marca-dagua"
    const imagens = document.querySelectorAll('.marca');
    
    // Para cada imagem
    imagens.forEach((imagem) => {
        // Cria um elemento canvas
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Define as dimensões do canvas como as dimensões da imagem
        canvas.width = imagem.width;
        canvas.height = imagem.height;

        // Desenha a imagem na tela
        ctx.drawImage(imagem, 0, 0);

        // Gerar número aleatório de 6 dígitos sem repetição
        const marcaDaguaTexto = gerarNumeroAleatorioUnico();

        // Configurações da marca d'água
        const marcaDaguaTamanho = 13;
        const marcaDaguaCor = 'rgba(255, 255, 255, 0.1)'; // Cor da marca d'água (branca semi-transparente)
        const marcaDaguaIntervalo = 28; // Intervalo entre as marca d'água em pixels

        // Desenha a marca d'água em uma grade sobre a imagem
        ctx.font = `${marcaDaguaTamanho}px Arial`;
        ctx.fillStyle = marcaDaguaCor;

        for (let y = 0; y < canvas.height; y += marcaDaguaIntervalo) {
            for (let x = 0; x < canvas.width; x += ctx.measureText(marcaDaguaTexto).width + marcaDaguaIntervalo) {
                ctx.fillText(marcaDaguaTexto, x, y);
            }
        }

        // Substitui a imagem original pelo canvas com a marca d'água
        imagem.parentNode.replaceChild(canvas, imagem);
    });
});
