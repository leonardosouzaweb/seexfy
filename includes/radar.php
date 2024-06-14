<?php
$loggedUserId = $_SESSION['user_id'];

$sql = "SELECT u.id, u.username, u.city, u.maritalStatus, u.avatar
        FROM users u
        WHERE u.id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $loggedUserId);
$stmt->execute();
$result = $stmt->get_result();

$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

if (count($users) > 0) {
    echo '<div class="scroll">';
    foreach ($users as $user) {
        echo '<div class="user" data-id="' . $user["id"] . '">';
        echo '<img src="'. $base_url .'assets/uploads/' . $user["avatar"] . '">';
        echo '<div class="info">';
        echo '<span>' . $user["username"] . '</span>';
        echo '<small>' . $user["city"] . '</small>';
        echo '</div>';
        echo '<div class="mask"></div>';
        echo '</div>';
    }
    echo '</div>';
    echo '<div class="space"></div>';
} else {
    echo "<p>Nenhum usuário encontrado</p>";
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
