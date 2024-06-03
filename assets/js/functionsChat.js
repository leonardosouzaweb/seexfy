document.addEventListener('DOMContentLoaded', function() {
    const sendButton = document.getElementById('send-button');
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');

    sendButton.addEventListener('click', function() {
        const messageContent = messageInput.value.trim();
        if (messageContent !== '') {
            appendMessage(messageContent, 'outgoing');
            messageInput.value = '';
            scrollToBottom();
            // Aqui você pode adicionar a lógica para enviar a mensagem para o servidor ou outro usuário
        }
    });

    function appendMessage(message, type) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', type);
        messageDiv.innerHTML = `<div class="message-content">${message}</div>`;
        chatMessages.appendChild(messageDiv);
    }

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});