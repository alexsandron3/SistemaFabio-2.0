const formatInput = () => {
  $('input').keyup(function() {
    $(this).val($(this).val().toUpperCase());
    $(document).ready(function() {
      $('.cpf').mask('000.000.000-00');
      $('.telefone').mask('00000000000');
    });
    //Jquery Restrict KevinSheedy
    $('.campos-de-texto').alpha({
        maxLength: 70,
    });
    $('.campo-de-pesquisa').alphanum({
        maxLength: 70,
        allow: '.-'
    });
    $('.campo-de-email').alphanum({
        allow: '@._',
        maxLength: 70,
    });
    $('.rg').alphanum({
        allow: '.-',
        maxLength: 70,
    });
    $('.text-area').alphanum({
        allow: '!@#$%^&*()+=[];,/{}|":<>?~`.- _'
    });
    $('.campo-monetario').numeric({
        allowMinus: true,
        maxDecimalPlaces: 2,
        disallow: '!@#$%^&*()+=[]\\\';,/{}|":<>?~` _'
    });
  })
}

