//FORMATAÇÃO DOS CAMPOS INPUT PARA UM PADRÃO
$('input[name="cpfCliente"]').mask('000.000.000-00');
$('input[name="telefoneCliente"]').mask('(00) 0 0000-0000');
$('input[name="telefoneContato"]').mask('(00) 0 0000-0000'); 
$('input[name="rgCliente"]').mask('000000000000000'); 

//RESTRINGINDO OS VALORES DOS INPUTS
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));


// INPUT FILTERS PADRÕES BASE
$("#intTextBox").inputFilter(function(value) {
  return /^-?\d*$/.test(value); });
$("#uintTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value); });
$("#intLimitTextBox").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
$("#floatTextBox").inputFilter(function(value) {
  return /^-?\d*[.]?\d*$/.test(value); });
$("#currencyTextBox").inputFilter(function(value) {
  return /^-?\d*[.]?\d{0,2}$/.test(value); });
$("#latinTextBox").inputFilter(function(value) {
  return /^[a-z à-ù á-ú]*$/i.test(value); });
$("#hexTextBox").inputFilter(function(value) {
  return /^[0-9a-f]*$/i.test(value); });

    //TEXT
    $("#nomeCliente").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú ]*$/i.test(value); });
    $("#nomeContato").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú]*$/i.test(value); });
    $("#nomePasseio").inputFilter(function(value) {
      return /^[A-Z À-Ù Á-Ú]*$/i.test(value); });
    $("#LocalPasseiolatinTextBox").inputFilter(function(value) {
      return /^[a-z à-ù á-ú]*$/i.test(value); });
    //CURRENCY
    $("#valorIngresso").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorOnibus").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorIngresso").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorMicro").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorVan").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorEscuna").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorSeguroViagem").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAlmocoCliente").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAlmocoMotorista").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorEstacionamento").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorGuia").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorAutorizacaoTransporte").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorTaxi").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorMarketing").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorKitLanche").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorImpulsionamento").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#outros").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorVendido").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
    $("#valorPendenteCliente").inputFilter(function(value) {
    return /^-?\d*[.]?\d{0,2}$/.test(value); });
  //INT
  $("#quantidadeIngresso").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeOnibus").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeMicro").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeVan").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeEscuna").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAlmocoCliente").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAlmocoMotorista").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeEstacionamento").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeGuia").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeAutorizacaoTransporte").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeTaxi").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeMarketing").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeKitLanche").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });
  $("#quantidadeImpulsionamento").inputFilter(function(value) {
  return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 200); });


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

    
    if(ageY < 0 || ageY > 150){
      document.getElementById('dataNascimento').value = "00/00/3333" ;
      var idadeConfirm = confirm("IDADE INVÁLIDA");
    }else{  
      document.getElementById('idadeCliente').value = ageY;
    }
}

//CALCULO DESPESAS PASSEIO
function calculoTotalDespesas(){
    var valorIngresso                                        = document.getElementById('valorIngresso').value;
    valorIngresso                                            = parseFloat(valorIngresso);
    document.getElementById('valorIngresso').value           = valorIngresso.toFixed(2);
    var quantidadeIngresso                                   = document.getElementById('quantidadeIngresso').value;
    valorTotalIngresso                                       = quantidadeIngresso * valorIngresso;
    document.getElementById('valorTotalIngresso').value      = valorTotalIngresso.toFixed(2);


    var valorOnibus                                          = document.getElementById('valorOnibus').value;
    valorOnibus                                              = parseFloat(valorOnibus);
    document.getElementById('valorOnibus').value             = valorOnibus.toFixed(2);
    var quantidadeOnibus                                     = document.getElementById('quantidadeOnibus').value;
    valorTotalOnibus                                         = quantidadeOnibus * valorOnibus;
    document.getElementById('valorTotalOnibus').value        = valorTotalOnibus.toFixed(2);


    var valorMicro                                           = document.getElementById('valorMicro').value;
    valorMicro                                               = parseFloat(valorMicro);
    document.getElementById('valorMicro').value              = valorMicro.toFixed(2);
    var quantidadeMicro                                      = document.getElementById('quantidadeMicro').value;
    valorTotalMicro                                          = quantidadeMicro * valorMicro;
    document.getElementById('valorTotalMicro').value         = valorTotalMicro.toFixed(2);
    


    var valorVan                                             = document.getElementById('valorVan').value;
    valorVan                                                 = parseFloat(valorVan);
    document.getElementById('valorVan').value                = valorVan.toFixed(2);
    var quantidadeVan                                        = document.getElementById('quantidadeVan').value;
    valorTotalVan                                            = quantidadeVan * valorVan;
    document.getElementById('valorTotalVan').value           = valorTotalVan.toFixed(2);
    

    var valorEscuna                                          = document.getElementById('valorEscuna').value;
    valorEscuna                                              = parseFloat(valorEscuna);
    document.getElementById('valorEscuna').value             = valorEscuna.toFixed(2);
    var quantidadeEscuna                                     = document.getElementById('quantidadeEscuna').value;
    valorTotalEscuna                                         = quantidadeEscuna * valorEscuna;
    document.getElementById('valorTotalEscuna').value        = valorTotalEscuna.toFixed(2);
    

    var valorAlmocoCliente                                   = document.getElementById('valorAlmocoCliente').value;
    valorAlmocoCliente                                       = parseFloat(valorAlmocoCliente);
    document.getElementById('valorAlmocoCliente').value      = valorAlmocoCliente.toFixed(2);
    var quantidadeAlmocoCliente                              = document.getElementById('quantidadeAlmocoCliente').value;
    valorTotalAlmocoCliente                                  = quantidadeAlmocoCliente * valorAlmocoCliente;
    document.getElementById('valorTotalAlmocoCliente').value = valorTotalAlmocoCliente.toFixed(2);
    

    var valorAlmocoMotorista                                 = document.getElementById('valorAlmocoMotorista').value;
    valorAlmocoMotorista                                     = parseFloat(valorAlmocoMotorista);
    document.getElementById('valorAlmocoMotorista').value    = valorAlmocoMotorista.toFixed(2);
    var quantidadeAlmocoMotorista                            = document.getElementById('quantidadeAlmocoMotorista').value;
    valorTotalAlmocoMotorista                                = quantidadeAlmocoMotorista * valorAlmocoMotorista;
    document.getElementById('valorTotalAlmocoMotorista').value = valorTotalAlmocoMotorista.toFixed(2);

    
    var valorEstacionamento                                  = document.getElementById('valorEstacionamento').value;
    valorEstacionamento                                      = parseFloat(valorEstacionamento);
    document.getElementById('valorEstacionamento').value     = valorEstacionamento.toFixed(2);
    var quantidadeEstacionamento                             = document.getElementById('quantidadeEstacionamento').value;
    valorTotalEstacionamento                                 = quantidadeEstacionamento * valorEstacionamento;
    document.getElementById('valorTotalEstacionamento').value= valorTotalEstacionamento.toFixed(2);


    var valorGuia                                            = document.getElementById('valorGuia').value;
    valorGuia                                                = parseFloat(valorGuia);
    document.getElementById('valorGuia').value               = valorGuia.toFixed(2);
    var quantidadeGuia                                       = document.getElementById('quantidadeGuia').value;
    valorTotalGuia                                           = quantidadeGuia * valorGuia;
    document.getElementById('valorTotalGuia').value          = valorTotalGuia.toFixed(2);
    

    var valorAutorizacaoTransporte                           = document.getElementById('valorAutorizacaoTransporte').value;
    valorAutorizacaoTransporte                               = parseFloat(valorAutorizacaoTransporte);
    document.getElementById('valorAutorizacaoTransporte').value             = valorAutorizacaoTransporte.toFixed(2);
    var quantidadeAutorizacaoTransporte                      = document.getElementById('quantidadeAutorizacaoTransporte').value;
    valorTotalTransporte                                     = quantidadeAutorizacaoTransporte * valorAutorizacaoTransporte;
    document.getElementById('valorTotalTransporte').value    = valorTotalTransporte.toFixed(2);
    

    var valorTaxi                                            = document.getElementById('valorTaxi').value;
    valorTaxi                                                = parseFloat(valorTaxi);
    document.getElementById('valorTaxi').value               = valorTaxi.toFixed(2);
    var quantidadeTaxi                                       = document.getElementById('quantidadeTaxi').value;
    valorTotalTaxi                                           = quantidadeTaxi * valorTaxi;
    document.getElementById('valorTotalTaxi').value          = valorTotalTaxi.toFixed(2);
    

    var valorMarketing                                       = document.getElementById('valorMarketing').value;
    valorMarketing                                           = parseFloat(valorMarketing);
    document.getElementById('valorMarketing').value          = valorMarketing.toFixed(2);
    var quantidadeMarketing                                  = document.getElementById('quantidadeMarketing').value;
    valorTotalMarketing                                      = quantidadeMarketing * valorMarketing;
    document.getElementById('valorTotalMarketing').value     = valorTotalMarketing.toFixed(2);
    

    var valorKitLanche                                       = document.getElementById('valorKitLanche').value;
    valorKitLanche                                           = parseFloat(valorKitLanche);
    document.getElementById('valorKitLanche').value          = valorKitLanche.toFixed(2);
    var quantidadeKitLanche                                  = document.getElementById('quantidadeKitLanche').value;
    valorTotalKitLanche                                      = quantidadeKitLanche * valorKitLanche;
    document.getElementById('valorTotalKitLanche').value     = valorTotalKitLanche.toFixed(2);

    
    var valorImpulsionamento                                 = document.getElementById('valorImpulsionamento').value;
    valorImpulsionamento                                     = parseFloat(valorImpulsionamento);
    document.getElementById('valorImpulsionamento').value    = valorImpulsionamento.toFixed(2);
    var quantidadeImpulsionamento                            = document.getElementById('quantidadeImpulsionamento').value;    
    valorTotalImpulsionamento                                = quantidadeImpulsionamento * valorImpulsionamento;
    document.getElementById('valorTotalImpulsionamento').value = valorTotalImpulsionamento.toFixed(2);


    var outros                                               = document.getElementById('outros').value;
    outros                                     = parseFloat(outros);
    document.getElementById('outros').value    = outros.toFixed(2); 

    var valorSeguroViagem                                    = document.getElementById('valorSeguroViagem').value;

    
    var valorTotal                  = Number(valorIngresso) * Number(quantidadeIngresso)  + Number(valorOnibus) * Number(quantidadeOnibus) + Number(valorMicro) * Number(quantidadeMicro) + Number(valorVan) * Number(quantidadeVan) + Number(valorEscuna) * Number(quantidadeEscuna) + Number(valorSeguroViagem)
                                    + Number(valorAlmocoCliente) * Number(quantidadeAlmocoCliente) + Number(valorAlmocoMotorista) * Number(quantidadeAlmocoMotorista) + Number(valorEstacionamento) * Number(quantidadeEstacionamento) + Number(valorGuia) * Number(quantidadeGuia) 
                                    + Number(valorAutorizacaoTransporte) * Number(quantidadeAutorizacaoTransporte) + Number(valorTaxi) * Number(quantidadeTaxi) + Number(valorMarketing) * Number(quantidadeMarketing)  + Number(valorImpulsionamento) * Number(quantidadeImpulsionamento) 
                                    + Number(outros)  + Number(valorKitLanche) * Number(quantidadeKitLanche);
   console.log(valorTotal);
   if(valorTotal) {
       document.getElementById('totalDespesas').value = valorTotal.toFixed(2);
   }else{   
        document.getElementById('totalDespesas').value = 0; 
    }
}

//CALCULO PAGAMENTO CLIENTE
function calculoPagamentoCliente(){
    var valorVendido                                   = document.getElementById('valorVendido').value;
    var valorPago                                      = document.getElementById('valorPago').value;
    var valorPendenteCliente                           = Number(valorPago) - Number(valorVendido);
    
    if(valorPendenteCliente < 0){
        document.getElementById('valorPendenteCliente').value = valorPendenteCliente;
        document.getElementById('statusPagamento').value = 0;  //NÃO PAGO
    }else if(valorPendenteCliente == 0){
        document.getElementById('statusPagamento').value = 1; //PAGO
        document.getElementById('valorPendenteCliente').value = valorPendenteCliente;
    }else{
        document.getElementById('valorPendenteCliente').value = "VALOR INCORRETO";
    }
    console.log(Number(valorPendenteCliente));

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

//VERIFICAÇÃO DE DATA DO PASSEIO
function verificaDataPasseio(){
  anoPasseio = document.getElementById('dataPasseio').value;
  if(anoPasseio < "2017-01-01"){
    document.getElementById('dataPasseio').value = "yyyy-MM-dd" ;
    var idadeConfirm = confirm("DATA INVÁLIDA");
  }
  console.log(anoPasseio);
}


function confirmationDelete(anchor)
{
   var conf = confirm('VOCÊ TEM CERTEZA QUE DESEJA APAGAR ESTE REGISTRO??');
   if(conf)
      window.location=anchor.attr("href");
}
