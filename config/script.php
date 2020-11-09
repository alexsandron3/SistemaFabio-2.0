//FORMATAÇÃO DOS CAMPOS INPUT PARA UM PADRÃO
$('input[name="cpfCliente"]').mask('000.000.000-00');
$('input[name="telefoneCliente"]').mask('(00) 0 0000-0000');
$('input[name="telefoneContato"]').mask('(00) 0 0000-0000'); 
$('input[name="data"]').mask('00/00/0000');



//CALCULANDO DATA DE NASCIMenTO DO CAMPO dataNascimento
function ageCount() {
    var now = new Date();                            //getting current date
    var currentY= now.getFullYear();                //extracting year from the date
    var currentM= now.getMonth();                   //extracting month from the date
    var currentD= now.getDate();                    //extractubg day from the date
      
    var dobget =document.getElementById("dataNascimento").value; //getting user input
    var dob= new Date(dobget);                             //formatting input as date
    var prevY= dob.getFullYear();                          //extracting year from input date
    var prevM= dob.getMonth();                             //extracting month from input date
    var prevD= dob.getDate();                               //extracting day from input date
      
    var ageY =currentY - prevY;
    var ageM =Math.abs(currentM- prevM);          //converting any negative value to positive
    var ageD = Math.abs(currentD-prevD -1);

      
    document.getElementById('idadeCliente').value = ageY;
    }

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
    var valorTotal                  = parseInt(valorIngresso, 10) + parseInt(valorOnibus, 10) + parseInt(valorMicro, 10) + parseInt(valorVan, 10) + parseInt(valorEscuna, 10) + parseInt(valorSeguroViagem, 10) + parseInt(valorAlmocoCliente, 10) 
                                    + parseInt(valorAlmocoMotorista, 10) + parseInt(valorEstacionamento, 10) + parseInt(valorGuia, 10) + parseInt(valorAutorizacaoTransporte, 10) + parseInt(valorTaxi, 10) + parseInt(valorMarketing, 10) 
                                    + parseInt(valorImpulsionamento, 10) + parseInt(outros, 10);
   console.log(valorTotal);
   if(valorTotal) {
       document.getElementById('totalDespesas').value = valorTotal;
   }else{
        document.getElementById('totalDespesas').value = 0; 
}

    

}
function idPasseioSelecionado(){
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;  
    console.log(idPasseioSelecionado);

    document.getElementById('passeioSelecionado').value = idPasseioSelecionado;
    
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


