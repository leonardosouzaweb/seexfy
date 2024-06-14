<?php
$loggedUserId = $_SESSION['user_id'];
$sql = "SELECT id, username, city, maritalStatus, avatar FROM users WHERE id != $loggedUserId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="scroll">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="user" data-id="' . $row["id"] . '">';
        echo '<img src="'. $base_url .'assets/uploads/users/' . $row["username"] . '/'. $row["avatar"] . '">';
        echo '<div class="info">';
        echo '<span>' . $row["username"] . '</span>';
        echo '<small>' . $row["city"] . '</small>';
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
