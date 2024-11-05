document.addEventListener("DOMContentLoaded", function () {
    const chatListItems = document.querySelectorAll("#chatList li");
    const chatWindow = document.getElementById("chatWindow");
    const chatUserName = document.getElementById("chatUserName");
    const closeChatButton = document.getElementById("closeChat");
    const openExtraOptionsButton = document.getElementById("openExtraOptions");
    const extraOptions = document.getElementById("extraOptions");
    const chatForm = document.getElementById("chatForm");
    const messageInput = chatForm.querySelector("input[type='text']");
    const chatBody = document.querySelector(".body");

    // Inicialização do display de extraOptions
    extraOptions.style.display = "none"; // Garante que está oculto inicialmente

    // Função para abrir a janela de chat
    chatListItems.forEach(item => {
        item.addEventListener("click", function () {
            chatUserName.textContent = item.dataset.username;
            chatWindow.style.display = "block";
            document.getElementById("chatTabs").style.display = "none"; // Esconde as abas de chat
            document.getElementById("chatList").style.display = "none"; // Esconde a lista de usuários
        });
    });

    // Fechar a janela de chat
    closeChatButton.addEventListener("click", function () {
        chatWindow.style.display = "none";
        document.getElementById("chatTabs").style.display = "flex"; // Mostra as abas de chat novamente
        document.getElementById("chatList").style.display = "block"; // Mostra a lista de usuários novamente
        extraOptions.style.display = "none"; // Esconde as opções extras ao fechar o chat
    });

    // Mostrar a div de opções extras ao clicar no botão "+"
    openExtraOptionsButton.addEventListener("click", function (e) {
        e.stopPropagation(); // Evita que o evento de clique se propague
        if (extraOptions.style.display === "none" || extraOptions.style.display === "") {
            extraOptions.style.display = "block"; // Mostra as opções extras
            console.log("Extra options shown"); // Debug log
        } else {
            extraOptions.style.display = "none"; // Esconde as opções extras
            console.log("Extra options hidden"); // Debug log
        }
    });

    // Fechar a div de opções extras ao clicar fora da div de botões
    document.addEventListener("click", function (e) {
        // Verifica se as opções extras estão visíveis e se o clique não ocorreu dentro delas nem no botão de abrir
        if (extraOptions.style.display === "block" && !extraOptions.contains(e.target) && e.target !== openExtraOptionsButton) {
            extraOptions.style.display = "none"; // Esconde as opções extras
            console.log("Extra options closed by clicking outside"); // Debug log
        }
    });

    // Adicionando o evento de envio do formulário de chat
    chatForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const messageText = messageInput.value.trim();
        if (messageText) {
            const messageElement = document.createElement("div");
            messageElement.className = "send";
            messageElement.innerHTML = `<span>Você:</span><p>${messageText}</p><small>${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</small>`;
            chatBody.appendChild(messageElement);
            messageInput.value = ""; // Limpa o campo de entrada
            chatWindow.scrollTop = chatWindow.scrollHeight; // Rolagem para o fim
        }
    });

    // Fechar as opções extras ao clicar na máscara
    extraOptions.addEventListener("click", function (e) {
        if (e.target === extraOptions) {
            extraOptions.style.display = "none"; // Esconde as opções extras
            console.log("Extra options closed by clicking on the mask"); // Debug log
        }
    });
});
