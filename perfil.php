<?php
include_once 'includes/head.php';
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header("Location: ./entrar");
    exit(); 
}

include_once 'config/db.php';

$username = $_GET['username'];
$sqlUser = "SELECT maritalStatus, username, city, interests, fullname, age, sexualOrientation, sign, height, smokes, drink, experience, description, agePartner, sexualOrientationPartner, signPartner, heightPartner, smokesPartner, drinkPartner, experiencePartner, description, gender, avatar FROM users WHERE username = ?";
$stmt = $conn->prepare($sqlUser);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verificar se o usuário logado é o dono do perfil
$isOwner = ($_SESSION['username'] === $username);

if ($user && isset($user['maritalStatus'])) {
    $maritalStatus = $user['maritalStatus'];
    if ($maritalStatus == "Solteiro" || $maritalStatus == "Solteira") {
        $displaySingle = "block";
        $displayGroup = "none";
    } elseif ($maritalStatus == "Casado" || $maritalStatus == "Casada") {
        $displaySingle = "none";
        $displayGroup = "block";
    } else {
        $displaySingle = "none";
        $displayGroup = "none";
    }
} else {
    $displaySingle = "none";
    $displayGroup = "none";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo $username; ?></title>
    <!-- Seus estilos CSS aqui -->
</head>
<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>

    <div class="home">
        <div class="wrapper">
            <?php include_once 'includes/topMenu.php'; ?>

            <div class="content">
                <?php include_once 'includes/profile.php'; ?>
            </div>

            <?php include_once 'includes/bottomMenu.php'; ?>
        </div>
    </div>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.getElementById('avatarImage').addEventListener('click', function() {
            document.getElementById('avatarInput').click();
        });

        document.getElementById('avatarInput').addEventListener('change', function() {
            var formData = new FormData(document.getElementById('avatarUploadForm'));
            
            fetch('../api/uploadAvatar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('avatarImage').src = data.newAvatarPath;
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });
        document.addEventListener('DOMContentLoaded', function () {
            function applyHeightMask(input) {
                input.addEventListener('input', function () {
                    let value = input.value;
                    value = value.replace(/[^0-9]/g, '');

                    if (value.length > 1) {
                        value = value.slice(0, 1) + '.' + value.slice(1);
                    }

                    value = value.slice(0, 4);
                    input.value = value;

                    const numberValue = parseFloat(value);
                    if (isNaN(numberValue) || numberValue <= 0 || numberValue >= 3) {
                        input.classList.add('error');
                    } else {
                        input.classList.remove('error');
                    }
                });
            }

            const heightInput = document.getElementById('heightInput');
            const heightPartnerInput = document.getElementById('heightPartnerInput');

            applyHeightMask(heightInput);
            applyHeightMask(heightPartnerInput);
            
        });

        var swiper = new Swiper(".swiper", {
            slidesPerView: "auto",
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        document.querySelectorAll('.like').forEach(item => {
            item.addEventListener('click', event => {
                var img = item.querySelector('img');
                if (img.src.includes('iconHeart.svg')) {
                    img.src = 'assets/images/icons/iconHeartActive.svg';
                } else {
                    img.src = 'assets/images/icons/iconHeart.svg';
                }
            });
        });
    </script>

    <script>
        function saveUserData() {
            var age = document.getElementById("ageInput").value;
            var orientation = document.getElementById("orientationInput").value;
            var sign = document.getElementById("signInput").value;
            var height = document.getElementById("heightInput").value;
            var smokes = document.getElementById("smokesInput").value;
            var drink = document.getElementById("drinkInput").value;
            var experience = document.getElementById("experienceInput").value;
            var description = document.getElementById("descriptionInput").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../api/updateUserDetail.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    document.getElementById("modalEditUser").style.display = "none";
                    location.reload();
                }
            };

            var data = "age=" + age + "&orientation=" + orientation + "&sign=" + sign + "&height=" + height + "&smokes=" + smokes + "&drink=" + drink + "&experience=" + experience + "&description=" + description;

            console.log("Data: " + data);
            xhr.send(data);
        }

        function saveUserPartner() {
            var agePartner = document.getElementById("ageInputPartner").value;
            var sexualOrientationPartner = document.getElementById("sexualOrientationPartner").value;
            var signPartner = document.getElementById("signInputPartner").value;
            var heightPartner = document.getElementById("heightInputPartner").value;
            var smokesPartner = document.getElementById("smokesInputPartner").value;
            var drinkPartner = document.getElementById("drinkInputPartner").value;
            var experiencePartner = document.getElementById("experienceInputPartner").value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../api/updateUserDetailPartner.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                    document.getElementById("modalEditPartner").style.display = "none";
                    location.reload();
                }
            };

            var dataPartner = "agePartner=" + agePartner + "&sexualOrientationPartner=" + sexualOrientationPartner + "&signPartner=" + signPartner + "&heightPartner=" + heightPartner + "&smokesPartner=" + smokesPartner + "&drinkPartner=" + drinkPartner + "&experiencePartner=" + experiencePartner;

            console.log("DataPartner: " + dataPartner);
            xhr.send(dataPartner);
        }
    </script>
</body>
</html>
