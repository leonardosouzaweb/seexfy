<div class="radarP">
    <div class="container">
        <h1>Radar</h1>
        <div class="radarActive">
            <img src="<?php echo $base_url; ?>/images/location.png">
            <button id="activateLocation">Ativar localização</button>
            <small>Ao ativar a localização, você autoriza a Seexfy nos mostrar pessoas próximas a você!</small>
        </div>

        <div class="feed" style="display:none">
            <?php include_once '../components/feed/feedRadar.php' ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('activateLocation').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                // Localização permitida, exibir feed e remover radarActive
                document.querySelector('.feed').style.display = 'block';
                document.querySelector('.radarActive').style.display = 'none';
                console.log('Latitude: ' + position.coords.latitude + ', Longitude: ' + position.coords.longitude);
            },
            function(error) {
                // Erro ou permissão negada
                alert('Erro ao obter a localização. Verifique as permissões.');
            }
        );
    } else {
        alert('Geolocalização não é suportada pelo seu navegador.');
    }
});
</script>