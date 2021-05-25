//INDEX.PHP
        
    //ABRIR NOVA JANELA
        function novaJanela(linkListaPassageiros) {
            var abrirNovaJanela = window.open(linkListaPassageiros, "nova aba");
        }
    //Mais informações Tooltip
    $(".more_info").click(function() {
        var $title = $(this).find(".title");
        if (!$title.length) {
          $(this).append('<span class="title"> </br>' + $(this).attr("title") + '</span>');
        } else {
          $title.remove();
        }
      });
//FORMATAÇÃO DOS FORMULÁRIOS
      //Jquery Mask
        $(document).ready(function(){
            $('.cpf').mask('000.000.000-00');
            $('.telefone').mask('00000000000');
            $('.campo-monetario').mask("###0.00", {reverse: true});
        });
    //Jquery Restrict KevinSheedy
        $('.campos-de-texto').alpha({
            forceUpper: true,
            maxLength: 70,
        });
        $('.campo-de-email').alphanum({
            allow: '@.',
            maxLength: 70,
        });
        $('.rg').alphanum({
            allow: '.-',
            maxLength: 70,
        });
        $('.text-area').alphanum({
            allow: '!@#$%^&*()+=[];,/{}|":<>?~`.- _'
        });
    //Cálculo de idade
        function ageCount(dataNasc) {
            split = dataNasc.split('-'); 
            var ano_aniversario = split[0];
            var mes_aniversario = split[1];
            var dia_aniversario = split[2];
            var dataAtual = new Date ;
            ano_atual = dataAtual.getFullYear();
            mes_atual = dataAtual.getMonth() + 1;
            dia_atual = dataAtual.getDate();

            quantos_anos = ano_atual - ano_aniversario;
            

            if (mes_atual < mes_aniversario || mes_atual == mes_aniversario && dia_atual < dia_aniversario) {
                quantos_anos--;
            }
            if (quantos_anos >= 0) {
                document.getElementById('idadeCliente').value = quantos_anos;    
            }
            
        }
    //Alterar data com base no RADIO CPF CONSULTADO
        //Recebendo data
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
        //Enviando a data
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
        //VERIFICAÇÃO DE DATA
        function verificaDataPasseio(){
            anoPasseio = document.getElementById('dataPasseio').value;
            if(anoPasseio < "2017-01-01"){
              document.getElementById('dataPasseio').value = "yyyy-MM-dd" ;
              var confirmarData = confirm("DATA INVÁLIDA");
            }
            
            
          }
          //CÁLCULO DOS CAMPOS MONETÁRIOS 
                function calculoDespesas(){
                    //Seção do valores unitários

                        var valorAereo                  = Number(document.getElementById('valorAereo').value);
                        var valorAlmocoCliente          = Number(document.getElementById('valorAlmocoCliente').value);
                        var valorAlmocoMotorista        = Number(document.getElementById('valorAlmocoMotorista').value);
                        var valorAutorizacaoTransporte  = Number(document.getElementById('valorAutorizacaoTransporte').value);
                        var valorEscuna                 = Number(document.getElementById('valorEscuna').value);
                        var valorEstacionamento         = Number(document.getElementById('valorEstacionamento').value);
                        var valorGuia                   = Number(document.getElementById('valorGuia').value);
                        var valorHospedagem             = Number(document.getElementById('valorHospedagem').value);
                        var valorImpulsionamento        = Number(document.getElementById('valorImpulsionamento').value);
                        var valorIngresso               = Number(document.getElementById('valorIngresso').value);
                        var valorKitLanche              = Number(document.getElementById('valorKitLanche').value);
                        var valorMarketing              = Number(document.getElementById('valorMarketing').value);
                        var valorMicro                  = Number(document.getElementById('valorMicro').value);
                        var valorOnibus                 = Number(document.getElementById('valorOnibus').value);
                        var valorPulseira               = Number(document.getElementById('valorPulseira').value);
                        var valorSeguroViagem           = Number(document.getElementById('valorSeguroViagem').value);
                        var valorServicos               = Number(document.getElementById('valorServicos').value);
                        var valorTaxi                   = Number(document.getElementById('valorTaxi').value);
                        var valorVan                    = Number(document.getElementById('valorVan').value);
                        var outros                      = Number(document.getElementById('outros').value);

                    //Seção de quantidade
                        var quantidadeAereo                  = Number(document.getElementById('quantidadeAereo').value);
                        var quantidadeAlmocoCliente          = Number(document.getElementById('quantidadeAlmocoCliente').value);
                        var quantidadeAlmocoMotorista        = Number(document.getElementById('quantidadeAlmocoMotorista').value);
                        var quantidadeAutorizacaoTransporte  = Number(document.getElementById('quantidadeAutorizacaoTransporte').value);
                        var quantidadeEscuna                 = Number(document.getElementById('quantidadeEscuna').value);
                        var quantidadeEstacionamento         = Number(document.getElementById('quantidadeEstacionamento').value);
                        var quantidadeGuia                   = Number(document.getElementById('quantidadeGuia').value);
                        var quantidadeHospedagem             = Number(document.getElementById('quantidadeHospedagem').value);
                        var quantidadeImpulsionamento        = Number(document.getElementById('quantidadeImpulsionamento').value);
                        var quantidadeIngresso               = Number(document.getElementById('quantidadeIngresso').value);
                        var quantidadeKitLanche              = Number(document.getElementById('quantidadeKitLanche').value);
                        var quantidadeMarketing              = Number(document.getElementById('quantidadeMarketing').value);
                        var quantidadeMicro                  = Number(document.getElementById('quantidadeMicro').value);
                        var quantidadeOnibus                 = Number(document.getElementById('quantidadeOnibus').value);
                        var quantidadePulseira               = Number(document.getElementById('quantidadePulseira').value);
                        var quantidadeSeguroViagem           = Number(document.getElementById('quantidadeSeguroViagem').value);
                        var quantidadeServicos               = Number(document.getElementById('quantidadeServicos').value);
                        var quantidadeTaxi                   = Number(document.getElementById('quantidadeTaxi').value);
                        var quantidadeVan                    = Number(document.getElementById('quantidadeVan').value);
                    //Seção de total de cada despesa
                        document.getElementById('valorTotalAereo').value                    = valorAereo * quantidadeAereo;
                        document.getElementById('valorTotalAlmocoCliente').value            = valorAlmocoCliente * quantidadeAlmocoCliente;
                        document.getElementById('valorTotalAlmocoMotorista').value          = valorAlmocoMotorista * quantidadeAlmocoMotorista;
                        document.getElementById('valorTotalTransporte').value               = valorAutorizacaoTransporte * quantidadeAutorizacaoTransporte;
                        document.getElementById('valorTotalEscuna').value                   = valorEscuna * quantidadeEscuna ;
                        document.getElementById('valorTotalEstacionamento').value           = valorEstacionamento * quantidadeEstacionamento;
                        document.getElementById('valorTotalGuia').value                     = valorGuia * quantidadeGuia;
                        document.getElementById('valorTotalHospedagem').value               = valorHospedagem * quantidadeHospedagem;
                        document.getElementById('valorTotalImpulsionamento').value          = valorImpulsionamento * quantidadeImpulsionamento;
                        document.getElementById('valorTotalIngresso').value                 = valorIngresso * quantidadeIngresso;
                        document.getElementById('valorTotalKitLanche').value                = valorKitLanche * quantidadeKitLanche;
                        document.getElementById('valorTotalMarketing').value                = valorMarketing * quantidadeMarketing ;
                        document.getElementById('valorTotalMicro').value                    = valorMicro * quantidadeMicro ;
                        document.getElementById('valorTotalOnibus').value                   = valorOnibus * quantidadeOnibus;
                        document.getElementById('valorTotalPulseira').value                 = valorPulseira * quantidadePulseira ;
                        document.getElementById('valorTotalSeguroViagem').value             = valorSeguroViagem * quantidadeSeguroViagem;
                        document.getElementById('valorTotalServicos').value                 = valorServicos * quantidadeServicos;
                        document.getElementById('valorTotalTaxi').value                     = valorTaxi * quantidadeTaxi;
                        document.getElementById('valorTotalVan').value                      = valorVan * quantidadeVan ;
                }
