// Formating inputs
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
// Getting page link
$(function () {
  $(window).on('hashchange', hashchanged);
  hashchanged();
});

function hashchanged () {
  const fullLink = location.hash;
  let page = fullLink.split('#').pop();
  page = page.split('?').shift();
  let id;
  if (fullLink.includes('?')) {
    id = fullLink.split('?').pop();
    id = `?${id}`; 
    $('#load-content').load(`${page}.php${id}`);
    $.post(`${page}.php${id}`);
  }
  $('#load-content').load(`${page}.php`);

}







const identifyForm = (link, isEditing) => {
  const submit = document.getElementById('submit');
  submit.addEventListener('click', (event) => {
    event.preventDefault();
    const formValues = $('form').serialize();
    // Verify if nome is empty
    if ($('#nomeCliente').length) {
      clientForm(link, formValues, isEditing)
    }
  }) 
}

const sendNotification = (notification) => {
  $.notify(notification.msg, {
    newest_on_top: true,
    animate: {
      enter: 'animated fadeInRight',
      exit: 'animated fadeOutRight'
    },
    type: notification.type,
    allow_dismiss: true,
    showProgressbar: true,
    timer: 50
  })
}


const registerInformation = (data, isEditing) => {
  const apiPoint = isEditing ? 'updateDespesa' : 'registerDespesa'
  $.post(`${apiPoint}.php`,{
    value: data
  }).done(function (data) {
    const serverResponse = JSON.parse(data);
    if(serverResponse.status === 1){
      const notificationInfo = {
        msg: serverResponse.msg,
        type: 'success',
      }
      sendNotification(notificationInfo);
      // Reset form after submit
      if (!isEditing) {
        $('form').trigger('reset');
      }

    }else{
      const notificationInfo = {
        msg: serverResponse.msg,
        type: 'danger',
      }
      sendNotification(notificationInfo);
    }

  }).fail(function () {
  });
};
