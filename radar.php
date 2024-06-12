<?php
    include_once 'includes/head.php';
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./entrar");
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
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <?php include_once 'includes/topMenu.php'; ?>
    <div class="home">
        <div class="wrapper">
            <div class="content">
                <div class="radar">
                    <img src="<?php echo $base_url; ?>assets/images/icons/IconRadar2x.svg">
                    <h2>Radar</h2>
                    <p>Clique no botão abaixo para encontrar pessoas próximas a você.</p>
                    <button id="activeLocation">Ativar localização</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    
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
                            window.location.href = "explorar.php";
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
</body>
</html>