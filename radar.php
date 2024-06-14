<?php
include_once 'includes/head.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./entrar");
    exit();
}

include_once 'config/db.php';

$user_id = $_SESSION['user_id'];
$sqlUser = "SELECT id, maritalStatus, username, avatar FROM users WHERE id = ?";
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
                    <button id="activeLocation" class="btn-active-location">Ativar localização</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/functions.js"></script>
        <script>
        $(document).ready(function() {
            $('button#activeLocation').click(function() {
                var button = $(this);

                // Verifica se o botão já está em processo de carregamento para evitar cliques repetidos
                if (button.hasClass('loading') || button.is(':disabled')) {
                    return; // Se estiver em processo de carregamento ou desabilitado, sai da função
                }

                // Adiciona classe de carregamento e desabilita o botão
                button.addClass('loading').attr('disabled', 'disabled');

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        var address = "";

                        obterEndereco(latitude, longitude, function(address) {
                            $.ajax({
                                url: 'api/saveLocation.php',
                                method: 'POST',
                                data: {
                                    latitude: latitude,
                                    longitude: longitude,
                                    address: address
                                },
                                success: function(response) {
                                    window.location.href = 'explorar.php';
                                },
                                error: function(xhr, status, error) {
                                    alert('Erro ao salvar localização.');
                                    console.error(xhr.responseText);
                                },
                                complete: function() {
                                    // Remove classe de carregamento e habilita o botão novamente
                                    button.removeClass('loading').removeAttr('disabled');
                                }
                            });
                        });
                    });
                } else {
                    alert('Geolocalização não é suportada por este navegador.');
                    // Remove classe de carregamento e habilita o botão novamente
                    button.removeClass('loading').removeAttr('disabled');
                }
            });

            function obterEndereco(latitude, longitude, callback) {
                var apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&key=AIzaSyBdpWnU3SpD_Tk3wT2QF0Myo6U-TiUmQRg';

                $.getJSON(apiUrl, function(data) {
                    if (data && data.results && data.results.length > 0) {
                        var address = data.results[0].formatted_address;
                        callback(address);
                    } else {
                        callback('Endereço não encontrado');
                    }
                });
            }
        });
    </script>

</body>
</html>
