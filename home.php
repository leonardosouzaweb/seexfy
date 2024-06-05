<?php
include_once 'includes/head.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}

include_once 'config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, maritalStatus, username, city, interests, fullname, age, sexualOrientation, sign, height, smokes, drink, experience, description, agePartner, sexualOrientationPartner, signPartner, heightPartner, smokesPartner, drinkPartner, experiencePartner, description, gender, avatar, verification FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user['verification'] == 0) {
    // O usuário não verificou a conta, exibir modal aqui
    echo "<script>
            $(document).ready(function(){
                $('#verification').modal('show');
            });
          </script>";
}

$stmt->close();
?>

<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>

    <div class="home">
        <div class="wrapper">
            <?php 
                include_once 'includes/topMenu.php';
            ?>

            <div class="content">
                <h2>Explorar</h2>
                <?php 
                    include_once 'includes/explore.php';
                ?>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    <?php include_once 'includes/verification.php'?>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
    <script>
        $(document).ready(function() {
            $('#verifyAccountBtn').click(function() {
                var user_id = "<?php echo $user['id']; ?>";
                var filePhoto = $('#filePhoto')[0].files[0];
                var formData = new FormData();
                formData.append('user_id', user_id);
                formData.append('filePhoto', filePhoto);

                $.ajax({
                    url: 'api/verifyUser.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#verification').modal('hide');
                        if (response.trim() === "success") {
                            location.reload(); 
                        } else {
                            
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
