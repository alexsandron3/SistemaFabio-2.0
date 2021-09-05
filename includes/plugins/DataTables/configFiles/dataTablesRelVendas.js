$(document).ready(function () {
  $.fn.dataTable.moment('DD/MM/YYYY');    //Formatação sem Hora
  $('#relatorioVendasTable').DataTable({
      "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
      dom: 'Blfrtip',
      buttons:
          [
              {
                  extend: 'pdfHtml5',
                  className: 'btn btn-info btn-sm',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',

                  }

              },
              {
                  extend: 'excel',
                  className: 'btn btn-info btn-sm',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',
                  }

              },
              {
                  extend: 'print',
                  className: 'btn btn-info btn-sm ml-1',
                  footer: 'true',
                  exportOptions: {
                      columns: ':visible',
                  }
              },

          ]

  });
});