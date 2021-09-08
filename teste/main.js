// Loading js files
// Global scripts
$.getScript("global.js");

let fullLink = $(location).attr('href');
let route = fullLink.split('#').pop();
route = route.split('?').shift();
switch (route) {
  case 'cliente':
    $.getScript("cliente.js", function () {
    })
    break;
  case 'despesa':
    $.getScript("despesa.js", function () {
    })
    break
  default:
    break;
}
