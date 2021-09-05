$(document).ready(function() {
  $.fn.dataTable.moment('DD/MM/YYYY'); //Formatação sem Hora
  $('#relatorioVendasTable').DataTable({
    "processing": true,
    // "serverSide": true,
    "ajax": {
      "type": "GET",
      "url": "./teste-backend-search.php",
      dataSrc: '',
    },
    "columns": [
      {"data": "nomePasseio"},
      {"data": "dataPasseio"},
      {"data": "NVendas"},
      {"data": "ValorVenda"},
      {"data": "ValorPago"},
  ]
  });
});