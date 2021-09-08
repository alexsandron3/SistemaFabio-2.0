// Registering to DB
const registerClientInformation = (data, isEditing) => {
  const apiPoint = isEditing ? 'updateClient' : 'registerClient'
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
    $.post('findClient.php', {
      id: idFormated,
    }).done(function(data) {
      if(isEditing){
        fillForm(data);
      }
    });
    formatInput();
    pageActions(pageType, isEditing);
  });
};

// Filling forms
const fillForm = (data) => {
  $('#nomeCliente').val();
  const obj = JSON.parse(data);
  $('form').deserialize(obj.data);
  $('#dataNascimento').change(function() {
    const birth = moment(this.value);
    const age = moment().diff(birth, 'years');
    $('#idadeCliente').val(age);
  })
}

const pageActions = (page, isEditing) => {
  switch (page) {
    case 'form':
      const submit = document.getElementById('submit');
      submit.addEventListener('click', (event) => {
        
        event.preventDefault();
        const formValues = $('form').serialize();
        // Verify if nome is empty
        if($.trim($('#nomeCliente').val()) !== ''){
          registerClientInformation(formValues, isEditing);
          
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