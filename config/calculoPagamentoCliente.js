//CALCULO PAGAMENTO CLIENTE
    function calculoPagamento(){
        //recebendo valores
            var valorVendido     = parseFloat(document.getElementById('valorVendido').value);
            var valorAntigoPago  = parseFloat(document.getElementById('valorAntigo').value);
            var novoValorPago    = parseFloat(document.getElementById('novoValorPago').value);
            var taxaDePagamento  = parseFloat(document.getElementById('taxaPagamento').value);
            
            var statusFormulario = document.getElementById('statusFormulario').value;

        //calculos
            var valorPendente   = (valorAntigoPago + taxaDePagamento + novoValorPago) - valorVendido;
        //verificações
            if (valorPendente > 0 || valorPendente < (valorVendido * -1) ||Number.isNaN(valorPendente) ) {
                document.getElementById('valorPendenteCliente').value = "VALOR INCORRETO OU CAMPOS NÃO PREENCHIDOS";
                document.getElementById('statusFormulario').value = 0;
                document.getElementById('novoValorPago').value = 0;
                statusFormulario = 0;
            }else {
                document.getElementById('valorPendenteCliente').value = valorPendente;
                document.getElementById('valorPago').value = valorAntigoPago + novoValorPago + taxaDePagamento;
                document.getElementById('statusFormulario').value = 1;
                statusFormulario = 1;

            }
        //mudando botão
            if (statusFormulario == false) {
                document.getElementById('buttonFinalizarPagamento').value = "VALORES INCORRETOS";
                document.getElementById('buttonFinalizarPagamento').classList.remove('btn-info')
                document.getElementById('buttonFinalizarPagamento').classList.add('btn-danger')
                document.getElementById('buttonFinalizarPagamento').disabled = true;
            } else {
                document.getElementById('buttonFinalizarPagamento').value = "FINALIZAR PAGAMENTO";
                document.getElementById('buttonFinalizarPagamento').classList.remove('btn-danger')
                document.getElementById('buttonFinalizarPagamento').classList.add('btn-info')
                document.getElementById('buttonFinalizarPagamento').disabled = false;
            }
            //console.log();
            return statusFormulario;
    }
    function gerarHistorico(){
        var statusFormulario          = calculoPagamento();
        var historicoPagamentoAntigo  = document.getElementById('historicoPagamentoAntigo').value;
        var novoValorPago             = parseFloat(document.getElementById('novoValorPago').value);
        var data             = new Date();
        var anoAtual         = data.getFullYear();
        var mesAtual         = data.getMonth();
        var diaAtual         = data.getDate();
        if (statusFormulario == true) {
            document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo + "\n " + diaAtual + "-" + (mesAtual+1) + "-" + anoAtual+ " R$: " + novoValorPago;
        } else {
            document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo;
        }
    }











/* 
function calculoPagamentoCliente() {
  
    var valorVendido                                   = document.getElementById('valorVendido').value;
    valorVendido                                       = parseFloat(valorVendido); 
    document.getElementById('valorVendido').value      = valorVendido.toFixed(2);

    

    var valorPago                                      = document.getElementById('valorPago').value;
    valorPago                                          = parseFloat(valorPago); 
    document.getElementById('valorPago').value         = valorPago.toFixed(2);

 
    

    this.novoValorPago = function (){
      var valorAntigo = document.getElementById('valorAntigo').value;
      valorAntigo = parseFloat(valorAntigo);
      var novoValor = document.getElementById('novoValorPago').value;
      novoValor = parseFloat(novoValor);
      document.getElementById('novoValorPago').value = novoValor.toFixed(2);
      var novoValorPago = parseFloat(valorPago.toFixed(2)) + parseFloat(novoValor.toFixed(2));

      var historicoPagamentoAntigo = document.getElementById('historicoPagamentoAntigo').value;
     
      if(novoValor == 0){
        document.getElementById('valorPago').value = valorAntigo;
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo;

      }else{
        var now = new Date();                           
        var currentY= now.getFullYear();                
        var currentM= now.getMonth();                   
        var currentD= now.getDate();
        //console.log(now);
        document.getElementById('valorPago').value = novoValorPago;
        document.getElementById('historicoPagamento').innerHTML = historicoPagamentoAntigo + "\n " + currentD + "-" + (currentM+1) + "-" + currentY+ " R$: " + novoValor.toFixed(2);
      }
      //console.log(novoValorPago);
    }
    var taxaPagamento                                  = document.getElementById('taxaPagamento').value;
    taxaPagamento                                      = parseFloat(taxaPagamento);
    document.getElementById('taxaPagamento').value     = taxaPagamento.toFixed(2);
    
    var valorPendenteCliente                           = parseFloat(valorPago.toFixed(2)) + parseFloat(taxaPagamento.toFixed(2)) - parseFloat(valorVendido.toFixed(2));
    valorPendenteClienteArredondado                   = parseFloat(valorPendenteCliente.toFixed(2)); 
    document.getElementById('valorPendenteCliente').value= valorPendenteClienteArredondado;
    
    var clienteParceiro = document.querySelector('input[name="clienteParceiro"]:checked').value;
;
    console.log(clienteParceiro);
    if(clienteParceiro == 1){
      document.getElementById('statusPagamento').value = 3;
      console.log(3);
    }else{
      if(valorPendenteCliente < 0 && valorPago == 0){
          document.getElementById('valorPendenteCliente').value =  valorPendenteCliente.toFixed(2);
          console.log("NÃO PAGO");
          document.getElementById('statusPagamento').value = 0;  //NÃO PAGO
      }else if(valorPendenteCliente == 0){
          document.getElementById('statusPagamento').value = 1; //PAGO
          document.getElementById('valorPendenteCliente').value =  valorPendenteCliente.toFixed(2);
      }else if(valorPendenteCliente < 0 && valorPago > 0){
        document.getElementById('statusPagamento').value = 2; //INTERESSADO
        console.log("interessado");
          //document.getElementById('valorPendenteCliente').value = "INTERESSADO";
      }else{
        document.getElementById('valorPendenteCliente').value = "VALOR INCORRETO";
      }
      //console.log(parseFloat( valorPendenteCliente.toFixed(2)));
    }

} */