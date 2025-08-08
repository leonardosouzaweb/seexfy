$(function () {
  let searchTimer;

  $('#searchInput').on('input', function () {
    const query = $(this).val().trim();
    clearTimeout(searchTimer);

    if (query.length < 2) {
      $('#results').empty();
      $('#searchLoading').hide();
      return;
    }

    $('#searchLoading').show();

    searchTimer = setTimeout(() => {
      $.get('../api/searchUsers.php', { q: query })
        .done(function (data) {
          $('#searchLoading').hide();
          $('#results').empty();

          if (!Array.isArray(data) || data.length === 0) {
            $('#results').html('<p class="text-muted">Nenhum resultado encontrado.</p>');
            return;
          }

          data.forEach(user => {
            const avatar = user.avatar ? `../uploads/${user.avatar}` : `../images/defaultAvatar.svg`;
            const profileUrl = `/seexfy/profile/${encodeURIComponent(user.username)}`;

            $('#results').append(`
              <a href="${profileUrl}" class="user-result" style="display: flex; align-items: center; gap: 15px; margin-bottom: 12px; text-decoration: none; color: inherit;">
                <img src="${avatar}" alt="Avatar" style="border-radius: 10px; width: 45px; height: 45px;">
                <div>
                  <strong>${user.username}</strong><br>
                  <small style="color: gray; display:block; margin-top:-2px;">${user.city}</small>
                </div>
              </a>
            `);
          });
        })
        .fail(function () {
          $('#searchLoading').hide();
          $('#results').html('<p class="text-danger">Erro ao buscar perfis.</p>');
        });
    }, 300);
  });
});
