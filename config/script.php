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
    var quantidadeCliente                         = document.getElementById('quantidadeCliente').value;
    var quantidadeOnibus                          = document.getElementById('quantidadeOnibus').value;
    var quantidadeMicro                           = document.getElementById('quantidadeMicro').value;
    var quantidadeVan                             = document.getElementById('quantidadeVan').value;
    var quantidadeEscuna                          = document.getElementById('quantidadeEscuna').value;
    var quantidadeAlmocoCliente                   = document.getElementById('quantidadeAlmocoCliente').value;
    var quantidadeAlmocoMotorista                 = document.getElementById('quantidadeAlmocoMotorista').value;
    var quantidadeEstacionamento                  = document.getElementById('quantidadeEstacionamento').value;
    var quantidadeGuia                            = document.getElementById('quantidadeGuia').value;
    var quantidadeAutorizacaoTransporte           = document.getElementById('quantidadeAutorizacaoTransporte').value;
    var quantidadeTaxi                            = document.getElementById('quantidadeTaxi').value;
    var quantidadeMarketing                       = document.getElementById('quantidadeMarketing').value;
    var quantidadeKitLanche                       = document.getElementById('quantidadeKitLanche').value;
    var quantidadeImpulsionamento                 = document.getElementById('quantidadeImpulsionamento').value;    
    var valorIngresso               = document.getElementById('valorIngresso').value;
    var valorOnibus                 = document.getElementById('valorOnibus').value;
    var valorMicro                  = document.getElementById('valorMicro').value;
    var valorVan                    = document.getElementById('valorVan').value;
    var valorEscuna                 = document.getElementById('valorEscuna').value;
    <!-- var valorSeguroViagem           = document.getElementById('valorSeguroViagem').value; -->
    var valorAlmocoCliente          = document.getElementById('valorAlmocoCliente').value;
    var valorAlmocoMotorista        = document.getElementById('valorAlmocoMotorista').value;
    var valorEstacionamento         = document.getElementById('valorEstacionamento').value;
    var valorGuia                   = document.getElementById('valorGuia').value;
    var valorAutorizacaoTransporte  = document.getElementById('valorAutorizacaoTransporte').value;
    var valorTaxi                   = document.getElementById('valorTaxi').value;
    var valorKitLanche              = document.getElementById('valorKitLanche').value;
    var valorMarketing              = document.getElementById('valorMarketing').value;
    var valorImpulsionamento        = document.getElementById('valorImpulsionamento').value;
    var outros                      = document.getElementById('outros').value; 
    var valorTotal                  = Number(valorIngresso) * Number(quantidadeCliente)  + Number(valorOnibus) * Number(quantidadeOnibus) + Number(valorMicro) * Number(quantidadeMicro) + Number(valorVan) * Number(quantidadeVan) + Number(valorEscuna) * Number(quantidadeEscuna) <!-- + Number(valorSeguroViagem) --> 
                                    + Number(valorAlmocoCliente) * Number(quantidadeAlmocoCliente) + Number(valorAlmocoMotorista) * Number(quantidadeAlmocoMotorista) + Number(valorEstacionamento) * Number(quantidadeEstacionamento) + Number(valorGuia) * Number(quantidadeGuia) 
                                    + Number(valorAutorizacaoTransporte) * Number(quantidadeAutorizacaoTransporte) + Number(valorTaxi) * Number(quantidadeTaxi) + Number(valorMarketing) * Number(quantidadeMarketing)  + Number(valorImpulsionamento) * Number(quantidadeImpulsionamento) 
                                    + Number(outros)  + Number(valorKitLanche) * Number(quantidadeKitLanche);
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
    var valorPendenteCliente                                  = Number(valorPago) + Number(sinalCliente ) - Number(valorVendido);
    
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
    var idadeConfirm = confirm("IDADE INVÁLIDA");
  }
  console.log(anoPasseio);
}
//CALCULO SEGURO VIAGEM

function seguroViagem(){
  var idadeCliente = document.getElementById('idadeCliente').value;
  var seguroViagem = document.querySelector('input[name="seguroViagemCliente"]:checked').value;
  var valorSeguroViagem = document.getElementById('valorSeguroViagem').value;
  var antigoValorSeguroViagem = Number(valorSeguroViagem);
  if(seguroViagem == 1){
    if(idadeCliente >= 0 && idadeCliente <=40){
      novoValorSeguroViagem = Number(valorSeguroViagem) + 2.23; 
      document.getElementById('novoValorSeguroViagem').value = novoValorSeguroViagem ;
    }else if (idadeCliente >=41 && idadeCliente <=60){
      novoValorSeguroViagem = Number(valorSeguroViagem) + 2.73; 
      document.getElementById('novoValorSeguroViagem').value = novoValorSeguroViagem ;
    }else if(idadeCliente > 60){
      novoValorSeguroViagem = Number(valorSeguroViagem) + 5.93; 
      document.getElementById('novoValorSeguroViagem').value = novoValorSeguroViagem ;
        
    }else{
      document.getElementById('novoValorSeguroViagem').value = novoValorSeguroViagem ;
      novoValorSeguroViagem = Number(valorSeguroViagem); 
    }
  }else{
    document.getElementById('novoValorSeguroViagem').value = antigoValorSeguroViagem;
    }


}

