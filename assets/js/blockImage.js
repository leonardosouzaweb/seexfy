function gerarNumeroAleatorioUnico() {
    let numerosDisponiveis = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    let numeroAleatorio = '';

    for (let i = 0; i < 6; i++) {
        const indice = Math.floor(Math.random() * numerosDisponiveis.length);

        numeroAleatorio += numerosDisponiveis.splice(indice, 1);
    }

    return numeroAleatorio;
}

window.addEventListener('DOMContentLoaded', (event) => {
    const imagens = document.querySelectorAll('.marca');
        imagens.forEach((imagem) => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = imagem.width;
        canvas.height = imagem.height;

        ctx.drawImage(imagem, 0, 0);

        const marcaDaguaTexto = gerarNumeroAleatorioUnico();

        const marcaDaguaTamanho = 13;
        const marcaDaguaCor = 'rgba(255, 255, 255, 0.1)'; 
        const marcaDaguaIntervalo = 28; 
        ctx.font = `${marcaDaguaTamanho}px Arial`;
        ctx.fillStyle = marcaDaguaCor;

        for (let y = 0; y < canvas.height; y += marcaDaguaIntervalo) {
            for (let x = 0; x < canvas.width; x += ctx.measureText(marcaDaguaTexto).width + marcaDaguaIntervalo) {
                ctx.fillText(marcaDaguaTexto, x, y);
            }
        }

        imagem.parentNode.replaceChild(canvas, imagem);
    });
});
