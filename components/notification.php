<div class="notificationP">
  <div class="container">
    <h1>Notificações</h1>
    <div id="notifications-container" style="min-height: 70vh;">
      <p class="text-center text-muted">Carregando notificações...</p>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('notifications-container');

  // Função para aplicar estilos de centralização ao container
  function centralizarContainer() {
    container.style.display = 'flex';
    container.style.flexDirection = 'column';
    container.style.justifyContent = 'center';
    container.style.alignItems = 'center';
    container.style.height = '70vh';
    container.style.textAlign = 'center';
    container.style.color = '#6c757d';
  }

  fetch('./../api/getNotifications.php')
    .then(response => {
      if (!response.ok) throw new Error('Erro na requisição');
      return response.json();
    })
    .then(data => {
      console.log('🔔 Notificações recebidas:', data);
      container.innerHTML = '';

      if (!Array.isArray(data) || data.length === 0) {
        centralizarContainer();

        container.innerHTML = `
          <i class="ph ph-bell-slash" style="font-size: 70px; color: #adb5bd; margin-bottom: 16px;"></i>
          <p class="mt-2 text-muted">Você não tem notificações no momento.</p>
        `;
        return;
      }

      // Remove estilos de centralização para lista de notificações
      container.style.display = '';
      container.style.flexDirection = '';
      container.style.justifyContent = '';
      container.style.alignItems = '';
      container.style.height = '';
      container.style.textAlign = '';
      container.style.color = '';

      data.forEach(notification => {
        const toast = document.createElement('div');
        toast.classList.add('toast', 'show', 'mb-3');
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-id', notification.id);

        const avatarHTML = notification.avatar 
          ? `<img src="../uploads/${notification.avatar}" class="rounded me-2" width="20" height="20" alt="Avatar">`
          : `<i class="ph ph-user-circle me-2" style="font-size: 20px; color: #6c757d;"></i>`;

        toast.innerHTML = `
          <div class="toast-header">
            ${avatarHTML}
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
      container.innerHTML = '<p class="text-danger">Erro ao carregar notificações.</p>';
    });
});
</script>
