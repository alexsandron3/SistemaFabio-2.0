const BigNumber = require('bignumber.js');

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
        title: 'ITEM A',
        rows: 10
    });
    $('#itemB').editable({
        title: 'ITEM B',
        rows: 10
    });
    $('#itemC').editable({
        title: 'ITEM C',
        rows: 10
    });
    $('#itensDoPacote').editable({
        title: 'ITENS DO PACOTE',
        rows: 10
    });
    $('#opcionaisDoPacote').editable({
        title: 'OPCIONAIS DO PACOTE',
        rows: 10
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

    
    $('select').on('blur',function () {
        const idCliente = $(location).attr('href').split('=').pop();
        $.get('api/infoPasseio.php', {
            id: this.value,
            idCliente: idCliente
        }).done(function(data) {
            data = JSON.parse(data);
            if(data.status === 0) return 0;
            const itensPacote = `ITENS DO PACOTE:<br/>${data.itensPacote}`
            const opcionaisPacote = `OPCIONAIS DO PACOTE:<br/>${data.opcionais}`
            const valorContrato = new BigNumber(data.valorContrato);
            // const valorString = String(valorContrato).replace('.', ',');
            // const valorString = String(valorContrato);
            // const valorEmExtenso = extenso(valorString).replace('inteiros', 'reais').replace('centésimos', 'centavos');
            // const valorEmExtenso = '';

            $('#itensDoPacote').html(itensPacote)
            $('#opcionaisDoPacote').html(opcionaisPacote)
            $('#vagasSolicitadas').html(data.numeroVagas)
            $('#valorTotal').html(`${valorContrato.toFixed(2)} ( )`)
            // console.log(valorEmExtenso, valorString);
        })
    })
});