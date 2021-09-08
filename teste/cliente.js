// Registering to DB
const registerClientInformation = (link, dataToSend, isEditing) => {
  const apiPoint = isEditing ? 'updateClient' : 'registerClient';
  // console.log(dataToSend);
  $.post(`${apiPoint}.php`,{
    value: dataToSend
  }).done(function (dataReceived) {
    const dataReceivedJson = JSON.parse(dataReceived);
    if(dataReceivedJson.serverResponse.status === 1){
      const notificationInfo = {
        msg: dataReceivedJson.serverResponse.msg,
        type: 'success',
      }
      sendNotification(notificationInfo);
      // Reset form after submit
      if (!isEditing) {
        $('form').trigger('reset');
      }

    }else{
      const notificationInfo = {
        msg: dataReceivedJson.serverResponse.msg,
        type: 'danger',
      }
      sendNotification(notificationInfo);
    }

  }).fail(function () {
  });
};


// Rendering pages
const renderClientPage = (location, id) => {
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
    $.post('findClient.php', {
      id: idFormated,
    }).done(function(data) {
      // console.log(data)
      if(isEditing){
        fillForm(data);
      }
    });
    formatInput();
    identifyForm(fullLink, isEditing);
  });
};

// Filling forms
const fillForm = (data) => {

  $('#nomeCliente').val();
  const obj = JSON.parse(data);
  console.log(obj)
  $('form').deserialize(obj.cliente);
  $('#dataNascimento').change(function() {
    const birth = moment(this.value);
    const age = moment().diff(birth, 'years');
    $('#idadeCliente').val(age);
  })

}

const clientForm = (link, formValues,isEditing) => {
  if($.trim($('#nomeCliente').val()) !== '' ){
    registerClientInformation(link, formValues, isEditing);
  }else {
    const notificationInfo = {
      msg: 'Campo nome Não preenchido',
      type: 'warning',
    }
    sendNotification(notificationInfo);
  }
}

