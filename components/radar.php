<div class="radarP">
    <div class="container">
        <h1>Radar</h1>

        <!-- BLOCO INICIAL -->
        <div class="radarActive" id="radarActive">
            <img src="<?php echo $base_url; ?>/images/location.png" alt="Localização">
            <button id="activateLocation" class="btn btn-primary mt-2">Ativar localização</button>
            <small class="d-block">Ao ativar a localização, você autoriza a Seexfy a mostrar pessoas próximas a você!</small>
        </div>

        <!-- LOADING SPINNER -->
        <div id="radarLoading" class="d-none mt-5 text-center spinner">
            <div class="spinner-border text-danger" role="status" style="width: 3rem; height: 3rem;"></div>
            <p class="mt-3 fw-bold">Estamos localizando <br> novas pessoas...</p>
        </div>

        <!-- RESULTADOS -->
        <div id="radarResults" class="cardsRadar d-none">
            <!-- Cards aparecem aqui -->
        </div>
    </div>
</div>

<script>
  // Função para formatar distância dinamicamente
  function formatDistance(meters) {
    if (meters < 1000) {
      return `${Math.round(meters)} m`;
    } else {
      return `${(meters / 1000).toFixed(2)} km`;
    }
  }

  document.getElementById('activateLocation').addEventListener('click', function () {
    const radarActive = document.getElementById('radarActive');
    const radarLoading = document.getElementById('radarLoading');
    const radarResults = document.getElementById('radarResults');

    radarActive.classList.add('d-none');
    radarLoading.classList.remove('d-none');

    fetch('../api/getNearbyByIP.php')
      .then(res => res.json())
      .then(data => {
        console.log("Resposta da API:", data); // DEBUG

        setTimeout(() => {
          radarLoading.classList.add('d-none');

          if (data.success) {
            radarResults.classList.remove('d-none');
            radarResults.innerHTML = '';

            if (data.users.length === 0) {
              radarResults.innerHTML = `
                <p class="text-muted">Nenhuma pessoa próxima foi encontrada no momento.</p>
              `;
            } else {
              data.users.forEach(user => {
                const idadeTexto = user.idade ? `, ${user.idade}` : '';

                const avatarUrl = (user.avatar && (user.avatar.startsWith('http://') || user.avatar.startsWith('https://')))
                  ? user.avatar
                  : (user.avatar ? "<?php echo $base_url; ?>/" + user.avatar : "<?php echo $base_url; ?>/images/defaultAvatar.svg");

                // Usa a distância em metros para formatar dinamicamente
                const distanceText = formatDistance(user.distance_m);

                const card = document.createElement('div');
                card.className = 'user-card';
                card.style.cursor = 'pointer';
                card.addEventListener('click', () => {
                  window.location.href = `${"<?php echo $base_url; ?>"}/profile/${encodeURIComponent(user.username)}`;
                });

                card.innerHTML = `
                  <img src="${avatarUrl}" class="card-img-top" alt="${user.username}">
                  <div class="info">
                    <span>${user.username}${idadeTexto}</span>
                    <small>${distanceText}</small>
                  </div>
                  <div class="mask"></div>
                `;
                radarResults.appendChild(card);
              });
            }

            console.log("HTML dos cards:", radarResults.innerHTML); // DEBUG HTML
          } else {
            alert(data.error || 'Não foi possível localizar você.');
            radarActive.classList.remove('d-none');
          }
        }, 3000);
      })
      .catch((err) => {
        console.error("Erro na requisição:", err);
        radarLoading.classList.add('d-none');
        radarActive.classList.remove('d-none');
        alert('Erro na requisição. Tente novamente.');
      });
  });
</script>
