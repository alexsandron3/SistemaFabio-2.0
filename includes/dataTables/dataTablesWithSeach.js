$(document).ready(function () {
    $.fn.dataTable.moment('DD/MM/YYYY');

    $('#userTable').DataTable({
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
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(4, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(

                'R$' + (Math.round((pageTotal + Number.EPSILON) * 100) / 100) + ' ( R$' + (Math.round((total + Number.EPSILON) * 100) / 100) + ' total)'
            );
        },
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
        dom: 'Blfrtip',
        buttons:
            [
                {
                    extend: 'pdfHtml5',
                    className: 'btn btn-info',
                    exportOptions: {
                        columns: ':visible'
                    }

                },
                {
                    extend: 'excel',
                    className: 'btn btn-info mr-1 ml-1',
                    exportOptions: {
                        columns: ':visible'
                    }

                },
                {
                    extend: 'print',
                    className: 'btn btn-info mr-1',
                    exportOptions: {
                        columns: ':visible'
                    }
                },

            ]

    });
});
$(document).ready(function () {
    $('#simpleTable').DataTable({
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "TUDO"]],
        dom: 'Blfrtip',
        buttons:
            [
                'pdfHtml5',
                'excel',
                'print'
            ],
    });
});

$(document).ready(function () {
    var table = $('#userTable').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#userTable tr th').hide(100);
            $('#userTable tr td').hide(100);
        } else {
            $('#userTable tr th').show(100);
            $('#userTable tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#userTable tr').each(function () {
            if (hide) {
                $('td:eq(' + ti + ')', this).hide(100);
                $('th:eq(' + ti + ')', this).hide(100);
            } else {
                $('td:eq(' + ti + ')', this).show(100);
                $('th:eq(' + ti + ')', this).show(100);
            }
        });

    });
    $('#userTable tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    $('#myInput').keyup(function () {
        table.draw();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

});
$(document).ready(function () {
    var table = $('#userTable').DataTable();

    $("#hide_show_all").on("change", function () {
        var hide = $(this).is(":checked");
        $(".hide_show").prop("checked", hide);

        if (hide) {
            $('#userTable tr th').hide(100);
            $('#userTable tr td').hide(100);
        } else {
            $('#userTable tr th').show(100);
            $('#userTable tr td').show(100);
        }
    });

    $(".hide_show").on("change", function () {
        var hide = $(this).is(":checked");

        var all_ch = $(".hide_show:checked").length == $(".hide_show").length;

        $("#hide_show_all").prop("checked", all_ch);

        var ti = $(this).index(".hide_show");

        $('#userTable tr').each(function () {
            if (hide) {
                $('td:eq(' + ti + ')', this).hide(100);
                $('th:eq(' + ti + ')', this).hide(100);
            } else {
                $('td:eq(' + ti + ')', this).show(100);
                $('th:eq(' + ti + ')', this).show(100);
            }
        });

    });
    $('#userTable tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    $('#myInput').keyup(function () {
        table.draw();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

});