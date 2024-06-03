<?php
    include_once 'includes/head.php';
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit(); 
    }

    include_once 'config/db.php';

    $user_id = $_SESSION['user_id'];
    $sqlUser = "SELECT maritalStatus, username, avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();
?>
<body>
    <div class="empty">
        <img src="assets/images/logo.svg">
    </div>

    <div class="home">
        <div class="wrapper">
            <?php 
                include_once 'includes/topMenu.php';
            ?>

            <div class="content">
                <div class="radar">
                    <img src="assets/images/icons/IconRadar2x.svg">
                    <h2>Radar</h2>
                    <p>Clique no botão abaixo para encontrar pessoas próximas a você.</p>
                    <button id="activeLocation">Ativar localização</button>
                </div>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#activeLocation").click(function(){
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        console.log("Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude);
                        $("#activeLocation").text("Localização Ativada").addClass("active");
                        setTimeout(function() {
                            window.location.href = "explore.php";
                        }, 2000);
                    }, function(error) {
                        console.error("Erro ao obter a localização:", error);
                        alert("Para utilizar esta funcionalidade, por favor, habilite a geolocalização no seu navegador.");
                    });
                } else {
                    alert("Desculpe, seu navegador não suporta geolocalização.");
                }
            });
        });
    </script>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/blockImage.js"></script>
</body>
</html>