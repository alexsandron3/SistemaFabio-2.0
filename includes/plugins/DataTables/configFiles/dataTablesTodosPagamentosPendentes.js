

$(document).ready(function () {
    $('#tabelaTodosPagamentosPendentes').DataTable({
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\R$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(5).footer()).html(

                ' R$' + (Math.round((pageTotal + Number.EPSILON) * 100) / 100) + ' TOTAL '
            );
        },
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
$(document).ready(function () {
    var table = $('#tabelaTodosPagamentosPendentes').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#tabelaTodosPagamentosPendentes tr th').hide(100);
            $('#tabelaTodosPagamentosPendentes tr td').hide(100);
        } else {
            $('#tabelaTodosPagamentosPendentes tr th').show(100);
            $('#tabelaTodosPagamentosPendentes tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#tabelaTodosPagamentosPendentes tr').each(function () {
            if (hide) {
                $('td:eq(' + ti + ')', this).hide(100);
                $('th:eq(' + ti + ')', this).hide(100);
            } else {
                $('td:eq(' + ti + ')', this).show(100);
                $('th:eq(' + ti + ')', this).show(100);
            }
        });

    });


    $('#myInput').keyup(function () {
        table.draw();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

});