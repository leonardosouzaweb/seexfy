<div class="chatP">
    <div class="container">
        <ul class="nav nav-tabs mb-3" id="chatTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="conversas-tab" data-bs-toggle="tab" data-bs-target="#conversas" type="button" role="tab">Conversas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="solicitacoes-tab" data-bs-toggle="tab" data-bs-target="#solicitacoes" type="button" role="tab">Solicitações</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="arquivadas-tab" data-bs-toggle="tab" data-bs-target="#arquivadas" type="button" role="tab">Arquivadas</button>
            </li>
        </ul>

        <div class="tab-content" id="chatTabContent">
            <!-- Lista de conversas -->
            <div class="tab-pane fade show active" id="conversas" role="tabpanel">
                <div id="chatList">
                    <ul>
                        <li data-username="Usuário 1">
                            <div>
                                <img src="../images/stories/1.png" alt="Avatar">
                                <div class="infoUser">
                                    <strong>Usuário 1</strong>
                                    <small>São Paulo, SP</small>
                                </div>
                            </div>
                            <span class="badge bg-success" title="Online"></span>
                        </li>
                        <li data-username="Usuário 2">
                            <div>
                                <img src="../images/stories/2.png" alt="Avatar">
                                <div class="infoUser">
                                    <strong>Usuário 2</strong>
                                    <small>Rio de Janeiro, RJ</small>
                                </div>
                            </div>
                            <span class="badge bg-secondary" title="Offline"></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Conteúdo das abas de solicitações e arquivadas -->
            <div class="tab-pane fade" id="solicitacoes" role="tabpanel">
                <p>Lista de solicitações aqui...</p>
            </div>
            <div class="tab-pane fade" id="arquivadas" role="tabpanel">
                <p>Conversas arquivadas aqui...</p>
            </div>
        </div>

        <!-- Janela de chat (oculta inicialmente) -->
        <div id="chatWindow" style="display: none;">
            <div class="card">
                <div class="head">
                    <img src="../images/icons/black/iconBack.svg" id="closeChat" class="icon">
                    <img src="../images/stories/1.png" alt="Avatar">
                    <span id="chatUserName"></span>
                </div>
                <div class="body">
                    <div class="receipt">
                        <span>Usuário 1:</span>
                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.</p>
                        <small>12:30</small>
                    </div>
                    <div class="send">
                        <span>Você:</span>
                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.</p>
                        <small>12:30</small>
                    </div>
                    <div class="receipt">
                        <span>Usuário 1:</span>
                        <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type.</p>
                        <small>12:30</small>
                    </div>
                </div>
                <div class="message">
                    <button id="openExtraOptions"><img src="../images/icons/black/iconPlus.svg" class="icon"></button>
                    <form id="chatForm">
                        <input type="text" class="form-control" placeholder="Digite sua mensagem" aria-label="Mensagem">
                        <button type="submit"><img src="../images/icons/black/iconSend.svg" class="icon"></button>
                    </form>
                </div>
            </div>
        </div>

        <div id="extraOptions" style="display: none; position: fixed; bottom: 0; left: 0; width: 100%; height:100%; background-color: rgba(0, 0, 0, 0.5); z-index: 10;">
            <div class="bar">
                <div class="actions">
                    <div>
                        <img src="../images/icons/black/iconUploadPhoto.svg">
                        <span>Imagem</span>
                    </div>
                    <div>
                        <img src="../images/icons/black/iconLocation.svg">
                        <span>Localização</span>
                    </div>
                    <div>
                        <img src="../images/icons/black/iconGift.svg">
                        <span>Presentear</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>