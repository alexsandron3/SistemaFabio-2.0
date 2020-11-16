//FORMATAÇÃO DOS CAMPOS INPUT PARA UM PADRÃO
$('input[name="cpfCliente"]').mask('000.000.000-00');
$('input[name="telefoneCliente"]').mask('(00) 0 0000-0000');
$('input[name="telefoneContato"]').mask('(00) 0 0000-0000'); 





//CALCULANDO DATA DE NASCIMENTO
function ageCount() {
    var now = new Date();                           
    var currentY= now.getFullYear();                
    var currentM= now.getMonth();                   
    var currentD= now.getDate();                    
      
    var dobget =document.getElementById("dataNascimento").value; 
    var dob= new Date(dobget);                          
    var prevY= dob.getFullYear();                          
    var prevM= dob.getMonth();                             
    var prevD= dob.getDate();                               
      
    var ageY =currentY - prevY;
    var ageM =Math.abs(currentM- prevM);          
    var ageD = Math.abs(currentD-prevD -1);

      
    document.getElementById('idadeCliente').value = ageY;
    }

//CALCULO DESPESAS PASSEIO
function calculoTotalDespesas(){
    var valorIngresso               = document.getElementById('valorIngresso').value;
    var valorOnibus                 = document.getElementById('valorOnibus').value;
    var valorMicro                  = document.getElementById('valorMicro').value;
    var valorVan                    = document.getElementById('valorVan').value;
    var valorEscuna                 = document.getElementById('valorEscuna').value;
    var valorSeguroViagem           = document.getElementById('valorSeguroViagem').value;
    var valorAlmocoCliente          = document.getElementById('valorAlmocoCliente').value;
    var valorAlmocoMotorista        = document.getElementById('valorAlmocoMotorista').value;
    var valorEstacionamento         = document.getElementById('valorEstacionamento').value;
    var valorGuia                   = document.getElementById('valorGuia').value;
    var valorAutorizacaoTransporte  = document.getElementById('valorAutorizacaoTransporte').value;
    var valorTaxi                   = document.getElementById('valorTaxi').value;
    var valorMarketing              = document.getElementById('valorMarketing').value;
    var valorImpulsionamento        = document.getElementById('valorImpulsionamento').value;
    var outros                      = document.getElementById('outros').value; 
    var valorTotal                  = Number(valorIngresso) + Number(valorOnibus) + Number(valorMicro) + Number(valorVan) + Number(valorEscuna) + Number(valorSeguroViagem) + Number(valorAlmocoCliente) 
                                    + Number(valorAlmocoMotorista) + Number(valorEstacionamento) + Number(valorGuia) + Number(valorAutorizacaoTransporte) + Number(valorTaxi) + Number(valorMarketing) 
                                    + Number(valorImpulsionamento) + Number(outros);
   console.log(valorTotal);
   if(valorTotal) {
       document.getElementById('totalDespesas').value = valorTotal;
   }else{   
        document.getElementById('totalDespesas').value = 0; 
    }
}

//CALCULO PAGAMENTO CLIENTE     document.getElementById('valorPago').value         = sinalCliente; 
function calculoPagamentoCliente(){
    var valorVendido                                   = document.getElementById('valorVendido').value;
    var sinalCliente                                   = document.getElementById('sinalCliente').value;
    var valorPago                                      = document.getElementById('valorPago').value;
    var valorPendente                                  = (Number(valorPago) + Number(sinalCliente ) - Number(valorVendido));
    
    if(valorPendente < 0){
        document.getElementById('valorPendente').value = valorPendente;
        document.getElementById('statusPagamento').value = 0;  //NÃO PAGO
    }else if(valorPendente == 0){
        document.getElementById('statusPagamento').value = 1; //PAGO
        document.getElementById('valorPendente').value = valorPendente;
    }else{
        document.getElementById('valorPendente').value = "VALOR INCORRETO";
    }
    console.log(Number(valorPendente));

}

    
//DEFININDO PASSEIO DO SELECT
function idPasseioSelecionadoFun(){
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;  
    console.log(idPasseioSelecionado);

    document.getElementById('idPasseioSelecionado').value = idPasseioSelecionado;
    
}


//DEFININDO DATA ATUAL DEFAULT NO CAMPO dataConsulta
function setInputDate(_id){
    var _dat = document.querySelector(_id);
    var hoy = new Date(),
        d = hoy.getDate(),
        m = hoy.getMonth()+1, 
        y = hoy.getFullYear(),
        data;

    if(d < 10){
        d = "0"+d;
    };
    if(m < 10){
        m = "0"+m;
    };

    data = y+"-"+m+"-"+d;
    console.log(data);
    _dat.value = data;
};

//CONDIÇÕES DO RADIO
function changeInputDate(){
    var radio = document.getElementsByName('cpfConsultado');

    for (var i = 0, length = radio.length; i < length; i++){
        if (radio[0].checked){
            setInputDate("#dataCpfConsultado");
            break;
        }
        else{
            document.getElementById('dataCpfConsultado').value = "mm/dd/yyyy";
            break;
        }
    } 
}


//TRASNFORMANDO TEXT EM UPPERCASE

function upperCaseF(a){
    setTimeout(function(){
        a.value = a.value.toUpperCase();
    }, 1);
}


