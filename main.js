$(document).ready(function () {
    $('#dob').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#inicioVigenciaContrato').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#terminoVigenciaContrato').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });
    $('#dataNascimento').editable({
        format: 'dd-mm-yyyy',
        viewformat: 'dd/mm/yyyy',
        datepicker: {
            weekStart: 1
        }
    });

    $('#itemA').editable({
        title: 'ITEM A'
    });

    $('#itemB').editable({
        title: 'ITEM B'
    });

    $('#itemC').editable({
        title: 'ITEM C'
    });


    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'popup';

    //make username editable
    $('#nome').editable();
    $('#nacionalidade').editable();
    $('#profissao').editable();
    $('#estadoCivil').editable();
    $('#identidade').editable();
    $('#telefone').editable();
    $('#cpf').editable();
    $('#enderecoCliente').editable();
    $('#nomePasseio').editable();
    $('#vagasSolicitadas').editable();
    $('#valorTotal').editable();
    $('#valorEntrada').editable();
    $('#previsaoPagamento').editable();
    $('#metodoPagamento').editable();
    $('#restantePagamento').editable();
    $('#dataDeHoje').editable();
    $('#assinaturaContratante').editable();
    $('#testemunha1').editable();
    $('#testemunha2').editable();

    //make status editable
    $('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            { value: 1, text: 'status 1' },
            { value: 2, text: 'status 2' },
            { value: 3, text: 'status 3' }
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });


});

