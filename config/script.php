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

function totalCount(){
    var valorIngresso   = document.getElementById('valorIngresso').value; //15010
    var valorOnibus     = document.getElementById('valorOnibus').value;   //10 
    var valorMicro      = document.getElementById('valorMicro').value;
    var valorTotal      = parseInt(valorIngresso, 10) + parseInt(valorOnibus, 10) + parseInt(valorMicro, 10);
   
   if(valorTotal) {
       document.getElementById('valorTotal').value = valorTotal;
   }else{
        document.getElementById('valorTotal').value = 0; 
   }

    

}
function idPasseioSelecionado(){
    var idPasseioSelecionado = document.getElementById('selectIdPasseio').value;  
    console.log(idPasseioSelecionado);

    document.getElementById('passeioSelecionado').value = idPasseioSelecionado ;


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


