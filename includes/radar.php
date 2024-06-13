<?php
$loggedUserId = $_SESSION['user_id'];

// Obter localização do usuário logado
$sqlLocationLoggedUser = "SELECT latitude, longitude FROM user_locations WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sqlLocationLoggedUser);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$resultLocationLoggedUser = $stmt->get_result();
$locationLoggedUser = $resultLocationLoggedUser->fetch_assoc();
$stmt->close();

// Verificar se a localização do usuário logado está disponível
if ($locationLoggedUser) {
    $latitudeLoggedUser = $locationLoggedUser['latitude'];
    $longitudeLoggedUser = $locationLoggedUser['longitude'];

    // Consulta para obter usuários e a localização mais recente
    $sql = "SELECT u.id, u.username, u.city, u.maritalStatus, u.avatar, ul.latitude, ul.longitude
            FROM users u
            LEFT JOIN (
                SELECT user_id, latitude, longitude
                FROM user_locations
                WHERE created_at IN (
                    SELECT MAX(created_at)
                    FROM user_locations
                    GROUP BY user_id
                )
            ) ul ON u.id = ul.user_id
            WHERE u.id != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $loggedUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="scroll">';
        while ($row = $result->fetch_assoc()) {
            $distance = "N/A"; // Valor padrão caso a localização não esteja disponível
            if ($row['latitude'] && $row['longitude']) {
                // Calcula a distância usando a fórmula de Haversine
                $theta = $longitudeLoggedUser - $row['longitude'];
                $dist = sin(deg2rad($latitudeLoggedUser)) * sin(deg2rad($row['latitude'])) +  cos(deg2rad($latitudeLoggedUser)) * cos(deg2rad($row['latitude'])) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $kilometers = $miles * 1.609344;
                $distance = round($kilometers, 2) . ' km';
            }

            echo '<div class="user" data-id="' . $row["id"] . '">';
            echo '<img src="'. $base_url .'assets/uploads/users/' . $row["username"] . '/'. $row["avatar"] . '">';
            echo '<div class="info">';
            echo '<span>' . $row["username"] . '</span>';
            echo '<small>Distância: ' . $distance . '</small>';
            echo '</div>';
            echo '<div class="mask"></div>';
            echo '</div>';
        }
        echo '</div>';
        echo '<div class="space"></div>';
    } else {
        echo "<p>Nenhum usuário encontrado</p>";
    }
} else {
    echo "<p>Localização do usuário logado não disponível</p>";
}
?>

<div id="customModal" class="modal">
	<div class="modal-dialog modal-dialog-centered">
		<div id="modal-content" class="modal-content"></div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.user').click(function(){
        var userId = $(this).data('id');
        $.ajax({
            url: 'api/getUserDetail.php',
            method: 'post',
            data: {id: userId},
            success: function(response){
                $('#modal-content').html(response);
                $('#customModal').show();
            }
        });
    });

    $('.close').click(function(){
        $('#customModal').hide();
    });
});
</script>
