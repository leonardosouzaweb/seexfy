<div class="chat-container">
    <div class="chat-list">
        <ul>
            <li onclick="openChat(1)">Chat 1</li>
            <li onclick="openChat(2)">Chat 2</li>
            <li onclick="openChat(3)">Chat 3</li>
        </ul>
    </div>
    <div class="chat-box">
        <div class="chat-header">
            <h2>Chat Box</h2>
        </div>
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will be loaded here -->
        </div>
        <div class="chat-input">
            <input type="text" id="message" placeholder="Type a message">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>