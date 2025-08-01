
<div class="notificationP">
  <div class="container">
    <h1>Notificações</h1>
    <div id="notifications-container">
      <p class="text-center text-muted">Carregando notificações...</p>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  fetch('./../api/getNotifications.php')
    .then(response => {
      if (!response.ok) throw new Error('Erro na requisição');
      return response.json();
    })
    .then(data => {
      console.log('🔔 Notificações recebidas:', data);
      const container = document.getElementById('notifications-container');
      container.innerHTML = '';

      if (!Array.isArray(data) || data.length === 0) {
        container.innerHTML = `
          <div class="text-center mt-4">
            <img src="../images/no-notifications.svg" alt="Sem notificações" style="max-width: 120px;">
            <p class="mt-2 text-muted">Você não tem notificações no momento.</p>
          </div>
        `;
        return;
      }

      data.forEach(notification => {
        const toast = document.createElement('div');
        toast.classList.add('toast', 'show', 'mb-3');
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-id', notification.id);

        toast.innerHTML = `
          <div class="toast-header">
            <img src="${notification.avatar ? '../uploads/' + notification.avatar : '../images/defaultAvatar.svg'}" class="rounded me-2" width="20" height="20">
            <strong class="me-auto">${notification.username}</strong>
            <small class="text-muted">${new Date(notification.created_at).toLocaleString('pt-BR')}</small>
            <button type="button" class="btn-close ms-2 mb-1 remove-notification" data-id="${notification.id}" aria-label="Fechar"></button>
          </div>
          <div class="toast-body">
            ${notification.message}
          </div>
        `;

        container.appendChild(toast);
      });

      // Adiciona eventos para os botões de fechar
      document.querySelectorAll('.remove-notification').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const id = e.currentTarget.dataset.id;

          fetch('../api/deleteNotification.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id)
          })
          .then(res => res.json())
          .then(res => {
            if (res.success) {
              // Recarrega a página após a exclusão
              window.location.reload();
            } else {
              alert('Erro ao excluir notificação.');
            }
          })
          .catch(() => {
            alert('Erro ao conectar com o servidor.');
          });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao carregar notificações:', error);
      document.getElementById('notifications-container').innerHTML = '<p class="text-danger">Erro ao carregar notificações.</p>';
    });
});
</script>
