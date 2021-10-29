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
   $('#nome').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#nacionalidade').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#profissao').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#estadoCivil').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#identidade').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#telefone').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#cpf').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#enderecoCliente').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#nomePasseio').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#vagasSolicitadas').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#valorTotal').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#valorEntrada').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#previsaoPagamento').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#metodoPagamento').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#restantePagamento').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#dataDeHoje').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#assinaturaContratante').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#testemunha1').editable({
        emptytext: 'NÃO INFORMADO ',
      });
      $('#testemunha2').editable({
        emptytext: 'NÃO INFORMADO ',
      });

    
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