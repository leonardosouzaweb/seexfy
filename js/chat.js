document.addEventListener("DOMContentLoaded", function () {
    const chatListItems = document.querySelectorAll("#chatList li");
    const chatWindow = document.getElementById("chatWindow");
    const chatUserName = document.getElementById("chatUserName");
    const closeChatButton = document.getElementById("closeChat");
    const openExtraOptionsButton = document.getElementById("openExtraOptions");
    const extraOptions = document.getElementById("extraOptions");
    const chatForm = document.getElementById("chatForm");
    const messageInput = chatForm.querySelector("input[type='text']");
    const chatTabs = document.getElementById("chatTabs"); // Seletor para as abas de chat

    // Função para abrir a janela de chat
    chatListItems.forEach(item => {
        item.addEventListener("click", function () {
            chatUserName.textContent = item.dataset.username;
            chatWindow.style.display = "block";
            chatTabs.style.display = "none"; // Esconde as abas de chat
            document.getElementById("chatList").style.display = "none"; // Esconde a lista de usuários
        });
    });

    // Fechar a janela de chat
    closeChatButton.addEventListener("click", function () {
        chatWindow.style.display = "none";
        chatTabs.style.display = "flex"; // Mostra as abas de chat novamente como flex
        document.getElementById("chatList").style.display = "block"; // Mostra a lista de usuários novamente
    });

    // Mostrar a div de opções extras ao clicar no botão "+"
    openExtraOptionsButton.addEventListener("click", function () {
        extraOptions.style.display = "block";
    });

    // Fechar a div de opções extras ao clicar fora da div de botões
    document.addEventListener("click", function (e) {
        if (extraOptions.style.display === "block" && !extraOptions.contains(e.target) && e.target !== openExtraOptionsButton) {
            extraOptions.style.display = "none";
        }
    });

    // Adicionando o evento de envio do formulário de chat
    chatForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Previne o envio padrão do formulário
        const messageText = messageInput.value.trim();
        if (messageText) {
            // Aqui você poderia adicionar a lógica para enviar a mensagem para o backend
            // Para a simulação, vamos adicionar a mensagem diretamente na janela de chat
            const messageElement = document.createElement("div");
            messageElement.className = "send"; // Classe para a mensagem enviada
            messageElement.innerHTML = `<span>Você:</span><p>${messageText}</p><small>${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>`;
            document.querySelector(".body").appendChild(messageElement);
            messageInput.value = ""; // Limpa o campo de entrada
            chatWindow.scrollTop = chatWindow.scrollHeight; // Rolagem para o fim
        }
    });
});
