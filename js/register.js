$(function(){
  const steps = $('.step');
  let idx = 0;
  let usernameCheckTimer;

  function showStep(i){
    steps.hide().eq(i).show();
  }
  showStep(idx);

  function updateNext(){
    const $cur = steps.eq(idx);
    let ok = false;

    if ($cur.hasClass('step1')) ok = true;

    if ($cur.hasClass('step2'))
      ok = $cur.find('.form-check-input:checked').length > 0;

    if ($cur.hasClass('step3'))
      ok = !!$('#maritalStatus').val();

    if ($cur.hasClass('step4'))
      ok = $('#username').val().trim().length >= 3 && $('.username').data('valid') === true;

    if ($cur.hasClass('step5'))
      ok = $('#city').val().trim().length > 0;

    if ($cur.hasClass('step6')) {
      const pw = $('#password').val();
      const confirm = $('#password_confirmation').val();
      const email = $('#email').val();
      const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

      const validLength = pw.length >= 8;
      const validUpper = /[A-Z]/.test(pw);
      const validSpecial = /\W/.test(pw);

      toggleRequirement('#lengthRequirement', validLength);
      toggleRequirement('#uppercaseRequirement', validUpper);
      toggleRequirement('#specialCharRequirement', validSpecial);

      ok = validLength && validUpper && validSpecial && pw === confirm && emailValid;
    }

    $cur.find('.next').prop('disabled', !ok);
  }

  function toggleRequirement(selector, condition) {
    const el = $(selector);
    const icon = el.find('.icon');

    el.removeClass('text-red-600 text-green-600');

    if (condition) {
      el.addClass('text-green-600');
      icon.text('✓');
    } else {
      el.addClass('text-red-600');
      icon.text('✗');
    }
  }

  $('.next').click(function(){
    if (idx < steps.length - 1){
      idx++;
      showStep(idx);
      updateNext();
    }
  });

  $('.back').click(function(){
    if (idx > 0){
      idx--;
      showStep(idx);
      updateNext();
    }
  });

  $('input, select').on('input change click keyup', updateNext);

  // Verificação do nome de usuário (com delay após digitação)
  $('#username').on('input', function(){
    const name = $(this).val().trim();

    clearTimeout(usernameCheckTimer);

    if (name.length < 3) {
      $('.username').data('valid', false);
      $('.username-feedback').text('').hide();
      updateNext();
      return;
    }

    usernameCheckTimer = setTimeout(function(){
      $.get('../auth/checkUsername.php', {username: name})
        .done(res => {
          if (res.available === false){
            $('.username').data('valid', false);
            $('.username-feedback')
              .text('Usuário não disponível')
              .removeClass('text-green-600')
              .addClass('text-red-600')
              .show();
          } else {
            $('.username').data('valid', true);
            $('.username-feedback')
              .text('Usuário disponível')
              .removeClass('text-red-600')
              .addClass('text-green-600')
              .show();
          }
          updateNext();
        });
    }, 500); // Delay após parar de digitar
  });

  updateNext();

let citySearchTimer;

$('#citySearch').on('input', function () {
  const query = $(this).val().trim();
  clearTimeout(citySearchTimer);

  if (query.length < 3) {
    $('#cityOptions').empty();
    $('#city').val('');
    updateNext();
    return;
  }

  citySearchTimer = setTimeout(() => {
    $.get(`https://servicodados.ibge.gov.br/api/v1/localidades/municipios`)
      .done(data => {
        const filtered = data
          .map(c => c.nome)
          .filter(name => name.toLowerCase().includes(query.toLowerCase()))
          .slice(0, 10);

        $('#cityOptions').empty();

        if (filtered.length > 0) {
          filtered.forEach((city, i) => {
            const id = `city_${i}`;
            $('#cityOptions').append(`
              <div class="form-check">
                <input class="form-check-input" type="radio" name="cityRadio" id="${id}" value="${city}">
                <label class="form-check-label" for="${id}">${city}</label>
              </div>
            `);
          });
        }
      });
  }, 300);
});

$(document).on('change', 'input[name="cityRadio"]', function () {
  $('#city').val($(this).val());
  updateNext();
});


});
