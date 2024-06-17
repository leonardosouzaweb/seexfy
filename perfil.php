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

    // Verifica se a foto é pública e não está oculta
    $sqlPhotos = "SELECT id FROM users_photos WHERE user_id = ? AND is_hidden = 0 AND is_public = 1";
    $stmtPhotos = $conn->prepare($sqlPhotos);
    $stmtPhotos->bind_param("i", $_SESSION['user_id']);
    $stmtPhotos->execute();
    $resultPhotos = $stmtPhotos->get_result();
    $publicPhotos = $resultPhotos->fetch_all(MYSQLI_ASSOC);
    $stmtPhotos->close();
?>
<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <?php include_once 'includes/topMenu.php'; ?>
    <div class="home">
        <div class="wrapper">
            <div class="content">
                <?php include_once 'includes/profile.php'; ?>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pica/5.0.0/pica.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function checkLikedStatus(photoId) {
                fetch('<?php echo $base_url; ?>/api/checkLike.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ photo_id: photoId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.liked) {
                        localStorage.setItem('photo_' + photoId + '_liked', 'true');
                        var likeButton = document.querySelector('.like-button[data-photo-id="' + photoId + '"]');
                        likeButton.classList.add('liked');
                    }
                });
            }

            document.querySelectorAll('.photo-item').forEach(function(photoItem) {
                var photoId = photoItem.getAttribute('data-photo-id');
                checkLikedStatus(photoId);
            });

            document.querySelectorAll('.like-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var photoId = this.getAttribute('data-photo-id');
                    var likeCount = this.querySelector('.like-count');
                    
                    fetch('<?php echo $base_url; ?>/api/likePhoto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ photo_id: photoId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            likeCount.textContent = data.likes;
                            this.classList.add('liked');
                            localStorage.setItem('photo_' + photoId + '_liked', 'true');
                        }
                    });
                });
            });

            document.querySelectorAll('.like-button').forEach(function(button) {
                var photoId = button.getAttribute('data-photo-id');
                var isLiked = localStorage.getItem('photo_' + photoId + '_liked');
                if (isLiked === 'true') {
                    button.classList.add('liked');
                }
            });

            document.querySelectorAll('.hide-button').forEach(function(button) {
                button.addEventListener('click', function() {
                    var photoId = this.getAttribute('data-photo-id');
                    var photoItem = this.closest('.photo-item');
                    var icon = this.querySelector('i');
                    
                    fetch('<?php echo $base_url; ?>/api/hidePhoto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ photo_id: photoId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var overlay = photoItem.querySelector('.overlay');
                            if (!overlay) {
                                overlay = document.createElement('div');
                                overlay.className = 'overlay';
                                overlay.innerHTML = '<img src="../assets/images/icons/iconLockedWhite.svg"> <span>Foto Privada</span>';
                                photoItem.appendChild(overlay);
                                icon.classList.remove('bi-eye-fill');
                                icon.classList.add('bi-eye-slash-fill');
                            } else {
                                photoItem.removeChild(overlay);
                                icon.classList.remove('bi-eye-slash-fill');
                                icon.classList.add('bi-eye-fill');
                            }
                        }
                    });
                });
            });

            document.querySelectorAll('.photo-item').forEach(function(photoItem) {
                photoItem.querySelector('.modal-trigger').addEventListener('click', function(event) {
                    if (photoItem.querySelector('.overlay')) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById('interactButton').addEventListener('click', function() {
            var username = this.getAttribute('data-username');
            if (username) {
                fetch('<?php echo $base_url; ?>api/addInteraction.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username: username })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '<?php echo $base_url; ?>chat';
                    } else {
                        console.error(data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    </script>

    <script>
        var modal = document.getElementById("photoModal");
        var modalImg = document.getElementById("modalImg");
        var images = document.getElementsByClassName("modal-trigger");
        var body = document.body;

        for (var i = 0; i < images.length; i++) {
            images[i].onclick = function () {
                modal.style.display = "block";
                modalImg.src = this.src;
                body.style.overflow = "hidden"; 
            }
        }

        function closeModal() {
            modal.style.display = "none";
            body.style.overflow = "auto"; 
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        document.getElementById('photoInput').addEventListener('change', function() {
            var formData = new FormData();
            var files = this.files;
            var filesProcessed = 0;

            for (var i = 0; i < files.length; i++) {
                resizeImage(files[i], 560, 840, function(resizedFile) {
                    formData.append('photos[]', resizedFile, resizedFile.name);
                    filesProcessed++;

                    if (filesProcessed === files.length) {
                        uploadImage(formData);
                    }
                });
            }
        });

        function resizeImage(file, maxWidth, maxHeight, callback) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                var img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');

                    var width = img.width;
                    var height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height *= maxWidth / width;
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width *= maxHeight / height;
                            height = maxHeight;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;

                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(function(blob) {
                        var resizedFile = new File([blob], file.name, { type: 'image/jpeg', lastModified: Date.now() });
                        callback(resizedFile);
                    }, 'image/jpeg');
                };
            };
        }

        function uploadImage(formData) {
            fetch('../api/uploadImage.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.photo-grid').innerHTML = data.photosHTML;
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    console.error(data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

    <script>
        document.getElementById('avatarImage').addEventListener('click', function() {
            document.getElementById('avatarInput').click();
        });

        document.getElementById('avatarInput').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var img = new Image();
                var reader = new FileReader();

                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.onload = function() {
                        var canvas = document.createElement('canvas');
                        var ctx = canvas.getContext('2d');
                        
                        var desiredSize = 350;
                        canvas.width = desiredSize;
                        canvas.height = desiredSize;

                        var offsetX = 0;
                        var offsetY = 0;
                        var size = Math.min(img.width, img.height);
                        
                        if (img.width > img.height) {
                            offsetX = (img.width - size) / 2;
                        } else {
                            offsetY = (img.height - size) / 2;
                        }

                        ctx.drawImage(img, offsetX, offsetY, size, size, 0, 0, desiredSize, desiredSize);
                        canvas.toBlob(function(blob) {
                            var formData = new FormData();
                            formData.append('avatar', blob, 'avatar.jpg');

                            fetch('../api/uploadAvatar.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    document.getElementById('avatarImage').src = data.newAvatarPath;
                                    location.reload();
                                } else {
                                    console.error(data.error);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                        }, 'image/jpeg');
                    }
                }

                reader.readAsDataURL(file);
            }
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

        // Função para verificar se todos os campos estão preenchidos para o usuário
        function checkFieldsUser() {
            var age = document.getElementById("ageInput").value;
            var orientation = document.getElementById("orientationInput").value;
            var sign = document.getElementById("signInput").value;
            var height = document.getElementById("heightInput").value;
            var smokes = document.getElementById("smokesInput").value;
            var drink = document.getElementById("drinkInput").value;
            var experience = document.getElementById("experienceInput").value;
            var description = document.getElementById("descriptionInput").value;

            var allFilled = age && orientation && sign && height && smokes && drink && experience && description;

            var saveButton = document.getElementById("saveButton");
            saveButton.disabled = !allFilled;
        }

        // Função para verificar se todos os campos estão preenchidos para o parceiro
        function checkFieldsPartner() {
            var agePartner = document.getElementById("ageInputPartner").value;
            var sexualOrientationPartner = document.getElementById("sexualOrientationPartner").value;
            var signPartner = document.getElementById("signInputPartner").value;
            var heightPartner = document.getElementById("heightInputPartner").value;
            var smokesPartner = document.getElementById("smokesInputPartner").value;
            var drinkPartner = document.getElementById("drinkInputPartner").value;
            var experiencePartner = document.getElementById("experienceInputPartner").value;

            var allFilled = agePartner && sexualOrientationPartner && signPartner && heightPartner && smokesPartner && drinkPartner && experiencePartner;

            var saveButton = document.getElementById("saveButtonPartner");
            saveButton.disabled = !allFilled;
        }

        // Adicione listeners para chamar a função checkFields() sempre que houver uma mudança nos campos
        document.getElementById("ageInput").addEventListener("input", checkFieldsUser);
        document.getElementById("orientationInput").addEventListener("input", checkFieldsUser);
        document.getElementById("signInput").addEventListener("input", checkFieldsUser);
        document.getElementById("heightInput").addEventListener("input", checkFieldsUser);
        document.getElementById("smokesInput").addEventListener("input", checkFieldsUser);
        document.getElementById("drinkInput").addEventListener("input", checkFieldsUser);
        document.getElementById("experienceInput").addEventListener("input", checkFieldsUser);
        document.getElementById("descriptionInput").addEventListener("input", checkFieldsUser);

        document.getElementById("ageInputPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("sexualOrientationPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("signInputPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("heightInputPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("smokesInputPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("drinkInputPartner").addEventListener("input", checkFieldsPartner);
        document.getElementById("experienceInputPartner").addEventListener("input", checkFieldsPartner);
    </script>
</body>
</html>
