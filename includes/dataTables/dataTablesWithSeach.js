$(document).ready(function() {
    $('#userTable').DataTable({
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $(api.column(4).footer()).html(

                'R$'+(Math.round((pageTotal + Number.EPSILON) * 100) / 100) +' ( R$'+ (Math.round((total + Number.EPSILON) * 100) / 100) +' total)'
            );
        },
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "TUDO"]],
        dom: 'Blfrtip',
        buttons:
        [
                'pdfHtml5',
                'excel',
                'print'
            ],
    } );
});