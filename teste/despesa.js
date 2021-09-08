const pageActions = (page, isEditing) => {
  switch (page) {
    case 'form':
      const submit = document.getElementById('submit');
      submit.addEventListener('click', (event) => {
        event.preventDefault();
        const formValues = $('form').serialize();
        // Verify if nome is empty
        if($.trim($('#nomeCliente').val()) !== ''){
          registerInformation(formValues, isEditing);
          
        }else {
          const notificationInfo = {
            msg: 'Campo nome Não preenchido',
            type: 'warning',
          }
          sendNotification(notificationInfo);
        }
      }) 
      break;
  
    default:
      break;
  }
}

// Filling forms
const fillForm = (data) => {
  $('#nomeCliente').val();
  const obj = data;
  console.log(obj.data[0]);
  $('form').deserialize(obj.data);
}

// Rendering pages
const render = (location, id) => {
  let fullLink;
  let idFormated;
  let isEditing = false;
  if (id) {
    idFormated = id.split('=').pop();
    fullLink = `${location}.php${id}`;
    isEditing = true;
  }
  $.post(`${location}.php`,{
    editMode: isEditing,
  }).done(function(dataPost){
    $('#page-change').html(dataPost);
    const pageType = $('#page-type').text();
    $.post('findPasseio.php', {
      hideInactives: true
    }).done(function(data) {
      const serverResponse = JSON.parse(data);
      const $option = $('select');
      $('.inputs').hide();
      if(isEditing){
        fillForm(data);
      } else {
        $.each(serverResponse.data, function() {
          $option.append(`<option value='${this.idPasseio}'> ${this.nomePasseio} | ${moment(this.dataPasseio).format("DD/MM/YYYY")}</option>`);
        });
        $('select').change(function () {
          const selectId = parseInt($(this).val());
          const option = serverResponse.data.find((passeio) => {
            return passeio.idPasseio === selectId;
          })
          if (selectId) {
            $.post('findPasseio.php', {
              hideInactives: true,
              id: selectId
            }).done(function(data) {
              const serverResponse = JSON.parse(data); 
              fillForm(serverResponse);
            })
            $('.inputs').show();
          }else{
            $('.inputs').hide();
          }
        })
      }
    });
    formatInput();
    pageActions(pageType, isEditing);
  });
};
//changing Page
const switchRoute = (fullLink) => {
  const editMode = fullLink.includes('?')
  let route = fullLink.split('#').pop();
  route = route.split('?').shift();
  let id;
  if (editMode) {
    id = fullLink.split('?').pop();
    id = `?${id}`; 
  }
  switch (route) {
    case '#':
      break;
    case 'home':
      render('default');
      break;
    default:
      render(route, id);
      break;
  }
};

// Getting page link
$(document).ready(function() {
  let fullLink = $(location).attr('href');
  switchRoute(fullLink);
  $(window).on('hashchange', function(event){
    const origEvent = event.originalEvent;
    let fullLink = origEvent.newURL;
    switchRoute(fullLink);
  });
});