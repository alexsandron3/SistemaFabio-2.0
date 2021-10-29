<?php
include_once("./includes/header.php");
$idCliente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$queryBuscarInformacoesCliente = "SELECT * FROM cliente WHERE idCliente=$idCliente";
$executaQueryBuscarInformacoesCliente = mysqli_query($conn, $queryBuscarInformacoesCliente);
$rowBuscarInformacoesCliente = mysqli_fetch_assoc($executaQueryBuscarInformacoesCliente);
$queryBuscarTodosPasseios = "SELECT nomePasseio, idPasseio, prazoVigencia, dataPasseio FROM passeio WHERE statusPasseio NOT IN (0) ORDER BY dataPasseio ";
$executaQueryBuscarTodosPasseios = mysqli_query($conn, $queryBuscarTodosPasseios);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>CONTRATO PRESTAÇÃO SERVIÇOS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- bootstrap -->
  <style>
    .body {
      background-color: white;
    }

    img {
      max-width: 111px;
      max-height: 106px;
    }
  </style>
  <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
  <link href="config/style.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
  <!-- <link href="https://demos.creative-tim.com/material-kit/assets/css/material-kit.min.css?v=2.0.7" rel="stylesheet" /> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
  <!-- PRINT -->


  <!-- x-editable (bootstrap version) -->
  <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
    rel="stylesheet" />

  <script src="config/bootstrap-editable.min.js"></script>

  <!-- main.js -->
  <script src="config/bundle.js"></script>
  <script type="text/javascript">
    function print_page() {
      var ButtonControl = document.getElementById("btnprint");
      /* window.open('imprimirContrato.php'); */

      ButtonControl.style.visibility = "hidden";
      window.print();
      ButtonControl.style.visibility = "visible";
    }
  </script>

  <style>
    @media print {
      * {
        text-decoration: none !important;
        color: black;
        border-bottom: dashed 0px !important;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;

      }

      .body {
        background-color: white !important;
      }

      .Assinatura-Linha {
        margin-top: -1px;
        position: relative;
      }
    }

    select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      border: none;
      /* needed for Firefox: */
      overflow: hidden;
      width: 500px;
      height: 50px;
    }

    .float-center {
      margin: auto;
    }

    .body {
      background-color: white !important;
      padding: 1%;
    }

    .Assinatura-Linha {
      margin-top: -1px;
      position: relative;

    }

    .logo {
      opacity: 0.5;
    }

    .header,
    .header-space,
    .footer,
    .footer-space {
      height: 100px;
    }

    .header {
      position: fixed;
      left: 90%;
      top: 0%;
    }
  </style>
</head>

<body class="body">
  <table>
    <thead>
      <tr>
        <td>
          <div class="header">
            <img src="img/fabioPasseiosLogo.jpeg" class="logo">
          </div>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="container">

            <input type="button" id="btnprint" value="IMPRIMIR ESTA PÁGINA" onclick="print_page()" />
            <!-- <img src="img/fabioPasseiosLogo.jpeg" class="float-right logo"> -->
            <h2 class="text-center">CONTRATO DE PRESTAÇÃO DE SERVIÇOS</h2>
            <p class="h4"> <b> <span class="h3"> CONTRATADA:</span> FABIO PASSEIOS</b>, com sede em <b> Rua Antônio
                Marins de
                Oliveira, 1.126, São Mateus, São João de Meriti, RJ, CEP 25.530-000</b>, inscrita no C.N.P.J. sob o nº
              <b>39.769.016/0001-07</b>, razão social <b>TAIS ANDREA XAVIER DE NEGREIROS</b> representada na forma deste
              contrato.
            </p>

            <h3>CONTRATANTE: </h3>
            <div class="row">
              <p class="border border-dark col"><b>Nome:</b> <a href="#" id="nome" data-type="text"
                  data-placement="right" data-title="NOME DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['nomeCliente']; ?>
                </a> </p>

            </div>

            <div class="row">

              <p class="col-4 border border-dark"> <b> Nacionalidade: </b> <a href="#" id="nacionalidade"
                  data-type="text" data-placement="right" data-title="NACIONALIDADE DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['nacionalidade']; ?>
                </a> </p>
              <p class="col-4 border border-dark"> <b> Profissão: </b> <a href="#" id="profissao" data-type="text"
                  data-placement="right" data-title="PROFISSÃO DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['profissao']; ?>
                </a> </p>
              <p class="col-4 border border-dark"> <b> Estado Civil: </b> <a href="#" id="estadoCivil" data-type="text"
                  data-placement="right" data-title="ESTADO CIVIL DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['estadoCivil']; ?>
                </a> </p>
            </div>
            <div class="row">
              <p class="col-6 border border-dark"> <b>Data de nascimento: </b>
                <a href="#" id="dataNascimento" data-type="date" data-pk="1" data-title="SELECIONE A DATA">
                  <?php
      $dataNascimento = new DateTime($rowBuscarInformacoesCliente['dataNascimento']);
      echo date_format($dataNascimento, 'd/m/Y');
      ?>
                </a>
              </p>
              <p class="col-6 border border-dark"> <b>Tel/Cel:</b> <a href="#" id="telefone" data-type="text"
                  data-placement="right" data-title="TELEFONE DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['telefoneCliente']; ?>
                </a> </p>
            </div>
            <div class="row">
              <p class="col-6 border border-dark"> <b>Carteira de Identidade:</b> <a href="#" id="identidade"
                  data-type="text" data-placement="right" data-title="IDENTIDADE DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['rgCliente']; ?>
                </a></p>
              <p class="col-6 border border-dark"> <b>CPF:</b> <a href="#" id="cpf" data-type="text"
                  data-placement="right" data-title="CPF DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['cpfCliente']; ?>
                </a></p>
            </div>
            <div class="row">
              <p class="border border-dark col"><b>Endereço:</b> <a href="#" id="enderecoCliente" data-type="text"
                  data-placement="right" data-title="ENDEREÇO DO CLIENTE">
                  <?php echo $rowBuscarInformacoesCliente['enderecoCliente']; ?>
                </a></p>

            </div>

            <h3> <b> 1 - OBJETO DO CONTRATO: </b> </h3>
            <p class="h4"> Cláusula 1ª. O presente contrato tem como OBJETO, a prestação, pela CONTRATADA, à
              <b>CONTRATANTE</b>,
              dos serviços na área de turismo referente ao passeio
              <select name="" id="">
                <option value="">Selecionar</option>
                <?php 
    while($rowBuscarTodosPasseios = mysqli_fetch_assoc($executaQueryBuscarTodosPasseios)) {
      
    ?>
                <option value="<?php echo $rowBuscarTodosPasseios['idPasseio'] ?>">
                  <?php 
                  $dataPasseio = new DateTime($rowBuscarTodosPasseios['dataPasseio']);
                  echo $rowBuscarTodosPasseios['nomePasseio'] . ' EM ' . date_format($dataPasseio, 'd/m/Y') ?>
                </option>

                <?php }?>
              </select> , para <a href="#" id="vagasSolicitadas" data-type="text" data-placement="right"
                data-title="QUANTIDADE DE VAGAS REQUISITADAS 1">0 </a> VAGA(S).
            </p>

            <p class="h4 mb-4"> <a href="#" id="itensDoPacote" data-type="wysihtml5" data-placement="right"
                data-title="ITENS DO PACOTE"> ITENS DO PACOTE: </a></p>
            <p class="h4"> <a href="#" id="opcionaisDoPacote" data-type="wysihtml5" data-placement="right"
                data-title="OPCIONAIS DO PACOTE"> OPCIONAIS DO PACOTE: </a></p>

            <h3> <b> 2- DESISTÊNCIA E CANCELAMENTO: </b> </h3>
            <p class="h4"> <span class="h3"> <b>2.1 - DESISTÊNCIA: </b></span> A desistência por parte do <b>
                CONTRATANTE</b>
              deve seguir as seguintes condições:</p>
            <p class="h4"> Em caso de viagem em que não haja transporte aéreo, <b> A VIAGEM É TRANSFERÍVEL </b>, ou em
              caso de
              reembolso o valor a ser restituído será de acordo com a deliberação normativa nº 161 de 9 de agosto de
              1985, da
              Embratur:</p>
            <ul class="h4">
              <li>90% até 31 dias do início da viagem</li>
              <li>80% de 21 a 30 dias do início da viagem </li>
              <li>0% a menos de 20 dias do início da viagem </li>
            </ul>
            <p class="h4"> Em caso de viagem em que haja transporte aéreo, o valor referente ao mesmo é
              <b>INTRANSFERÍVEL</b> e
              não reembolsável.
            </p>
            <p class="h4"> <span class="h3"> <b>2.2 - CANCELAMENTO:</b> </span> Considera-se cancelamento, todo e
              qualquer ato
              por parte do <b> CONTRATANTE</b> que impossibilite a sua viagem, como não estar portando documentos, não
              estar
              presente no local e horário pré-programado para saída do grupo.</p>
            <p class="h4"> <span class="h3"> <b>2.3 -</b> </span> O passeio pode ser adiado pela <b>CONTRATADA</b>
              quando não
              atingir a lotação mínima.</p>
            <p class="h4"> <span class="h3"> <b>2.4 – COVID: </b> </span> Os passeios que forem impedidos de serem
              realizados em
              virtude da pandemia por <b>COVID</b> serão suspensos até que haja liberação para realização dos mesmos. O
              valor
              pago pelo
              <b>CONTRATANTE</b> será utilizado para o mesmo passeio em data a ser definida após a liberação pelas
              autoridades
              ou
              ficará de crédito para utilização em outro passeio. No caso de pedido de devolução do valor pago pelo a
              <b>CONTRATADA</b>
              terá até 12 meses para fazer a devolução.
            </p>
            <p class="h4"> <span class="h3"> <b>2.5 – </b> </span> O <b>CONTRATANTE</b> que se declarar com
              <b>COVID</b>, não
              poderá
              comparecer ao passeio para cumprir a quarentena, ou que esteja acometido de qualquer doença que o impeça
              de ir no
              passeio, ficará com o crédito do valor pago para utilização passeio futuro. No caso de pedido de devolução
              do
              valor pago a <b>CONTRATADA</b> terá até 12 meses para fazer a devolução.
            </p>
            <h3> <b>3 - DOCUMENTAÇÃO DE RESPONSABILIDADE DO CONTRATANTE</b> </h3>
            <p class="h4">A documentação pessoal é de total responsabilidade do passageiro. Assim, a impossibilidade de
              embarque
              (aéreo ou rodoviário) ou entrada em locais agendados, mesmo que já pagos, gerada por falta de documentação
              caracterizará cancelamento por parte do passageiro, e não haverá devolução de valores. </p>
            <h3> <b>4 - CONDIÇÕES PARA COMPRA DE INGRESSOS PARA PARQUES TEMÁTICOS OU SHOWS:</b> </h3>
            <p class="h4"> <span class="h3"> <b>4.1 - </b> </span> Os ingressos quando adquiridos antecipadamente não
              são
              reembolsáveis. Uma vez adquiridos e pagos não poderão ser reembolsados, mesmo que haja desistência.
            </p>
            <h3> <b>5 - CONDIÇÕES ESPECÍFICAS DO TRANSPORTE AÉREO</b> </h3>
            <p class="h4"> <span class="h3"> <b>5.1 - </b> </span> O bilhete de passagem aérea é a expressão do contrato
              de
              transporte aéreo, firmado entre passageiro e empresa de transporte, sendo, portanto, intransferível e não
              reembolsável em caso de desistência.
            </p>
            <p class="h4"> <span class="h3"> <b>5.2 - </b> </span> Bagagem: o transporte será feito de acordo com os
              critérios
              da cia. aérea que, em geral, permite transportar um volume de até 10kg por pessoa, sem pagamento de
              sobretaxas.
            </p>
            <p class="h4"> <span class="h3"> <b>5.3 - </b> </span> No caso de atraso de vôo, acidentes, perda ou
              extravio de
              bagagem, fica previamente estabelecido que a responsabilidade será exclusiva da cia. aérea em questão e de
              acordo
              com normas internacionais (Convenção de Varsóvia) e o Código Brasileiro de Aeronáutica.
            </p>
            <p class="h4"> <span class="h3"> <b>5.4 - </b> </span> A realização de escalas técnicas ficará a critério do
              Comandante da aeronave.
            </p>
            <p class="h4"> <span class="h3"> <b>5.5 - </b> </span> Os passageiros deverão, sob sua responsabilidade:
            </p>
            <p class="h4"> <span class="h3"> <b>a) </b> </span> apresentar-se no aeroporto até 02 (duas) horas antes do
              horário
              previsto para embarque.
            </p>
            <p class="h4"> <span class="h3"> <b>5.6 - </b> </span> O transportador não poderá retardar um voo para
              aguardar
              passageiros porventura retidos por autoridades fiscais ou policiais para fiscalização. O não embarque
              caracterizará cancelamento da viagem.
            </p>
            <p class="h4"> <span class="h3"> <b>5.7 - </b> </span>Os embarques só serão feitos mediante documentação
              ORIGINAL
              (RG original com foto). Menores desacompanhados, precisam de autorização com firmas reconhecidas do Pai e
              da Mãe,
              além do RG Original.
            </p>
            <h3> <b> 6 - CLIMA E TEMPO:</b></h3>
            <p class="h4"> Não haverá cancelamento da viagem / passeio por conta de “mau tempo”, a menos que haja
              impedimento
              para o transporte, aéreo / marítimo / terrestre, ou algum fenômeno da natureza que coloque em risco a
              segurança
              dos passageiros. Lembrando que trabalhamos com segurança, e monitoramos tudo que diz respeito a segurança
              dos
              passageiros. Se o passeio tiver que ser adiado será, mas falta de sol não será considerado motivo. Nesse
              caso não
              haverá reembolso uma vez que o passeio será remanejado para outra data.</p>
            <h3> <b> 7- TOLERÂNCIA: </b></h3>
            <p class="h4"> É obrigação do passageiro estar no local combinado para saída do grupo com no mínimo 15
              minutos de
              antecedência, sendo que o prazo de tolerância será de 15 minutos após o horário sem exceção.</p>
            <h3> <b> 8 - BAGAGENS E OBJETOS PESSOAIS: </b></h3>
            <p class="h4">Bagagem: A bagagem e demais itens pessoais do passageiro não são objetos desse contrato, sendo
              que
              estes viajam por conta e risco dos passageiros. Não nos responsabilizamos pela perda, roubo, extravio ou
              danos que
              as bagagens possam sofrer durante a viagem, por qualquer causa. Recomendamos não levar consigo na viagem,
              quaisquer jóias, objetos de valor ou de estima pessoal, a fim de evitar problemas de ilícitos; e, caso
              seja a
              opção do(a) <b>CONTRATANTE</b> fazê-lo, deverá(ão) o(a)(s) mesmo(a)(s), mantê-lo(s) a sua posse, o tempo
              integral,
              por
              isso, assume(m) total responsabilidade pelo(s) mesmo(s).</p>
            <h3> <b> 9 - OPCIONAIS: </b></h3>
            <p class="h4">Indicamos passeios, visitas e restaurantes opcionais. Estes não estão inclusos em nosso
              produto,
              constituindo-se mera sugestão, não sendo de nossa responsabilidade a operacionalização e qualidade dos
              mesmos.</p>

            <br>
            <h3> <b> 10 – SEGURO VIAGEM: </b></h3>
            <p class="h4">O seguro viagem é garantido ao contratante/passageiro que fizer sua reserva até 2 dias antes
              da
              realização do passeio/viagem.</p>
            <h3> <b> 11 - DO PAGAMENTO: </b></h3>
            <p class="h4">De acordo com a prestação dos serviços relacionados neste contrato, o <b>CONTRATANTE</b>
              pagará a
              <b>CONTRATADA</b>,
              o valor de R$ <a href="#" id="valorTotal" data-type="text" data-placement="right"
                data-title="VALOR TOTAL">0.00
              </a> da seguinte forma:
            </p>
            <p class="h4">
            <div id="itemA" data-type="wysihtml5" data-pk="1" style="font-size: 1.5rem;">a) Para garantir sua reserva o <b>CONTRATANTE</b> se compromete a dar uma entrada no valor de R$ 0.00 até PREVISÃO DE PAGAMENTO através de __.</div>
            </p>
            <p class="h4">
            <div id="itemB" data-type="wysihtml5" data-pk="1" style="font-size: 1.5rem;"> b) O pagamento do saldo restante será realizado conforme discriminado: <br> __</div>
            </p>
            <p class="h4">

            <div id="itemC" data-type="wysihtml5" data-pk="1" style="font-size: 1.5rem;">c) A falta do pagamento acordado nos itens “a” e/ou “b” dentro do prazo estabelecido ensejará o cancelamento do presente contrato. Ficando sua vaga à disposição da <b>CONTRATADA</b> para venda;
            </div>
            </p>
            <p class="h4">d) Nos casos em que a forma de pagamento acordada for em boleto bancário o contrato será
              cancelado
              quando
              do não pagamento de 3 boletos, sem direito à devolução dos pagamentos realizados.</p>
            <h3> <b> 12 - PRAZO DE VIGÊNCIA: </b></h3>
            <p class="h4">O presente contrato terá início em
              <a href="#" id="inicioVigenciaContrato" data-type="date" data-pk="1"
                data-title="SELECIONE A DATA"><?php echo date('d/m/Y') ?></a>
              e término em <a href="#" id="terminoVigenciaContrato" data-type="date" data-pk="1"
                data-title="SELECIONE A DATA"><?php echo $rowBuscarTodosPasseios['prazoVigencia'] ?></a>.
            </p>
            <h3> <b> 13 - FORO </b></h3>
            <p class="h4">Fica estabelecido pelas partes que o foro escolhido é o da comarca de São João de Meriti/RJ,
              podendo
              ser renunciada qualquer outro, para resolver as controvérsias que eventualmente surjam deste contrato.
            </p>
            <p class="h4">Por estarem assim justos e acordados, firmam o presente instrumento, em duas vias de igual
              teor. </p>
            <p class="h4">São João de Meriti, <a href="#" id="dob" data-type="date" data-pk="1"
                data-title="SELECIONE A DATA"><?php echo date('d/m/Y') ?></a>. </p>
            <div class="row">
              <div class="col">
                <img src="img/assinaturaTais.png" alt="">
                <hr class="bg-dark Assinatura-Linha" style="width: 42.5%;">
                <p class="h4"></p> <b> <span class="Assinatura-Tais-Empresa-Nome">FABIO PASSEIOS</span></b></p>
              </div>
              <div class="col mt-3">

                <hr class="bg-dark Assinatura-Linha">
                <p class="h4"> <b> <span class="Assinatura-Tais-Empresa-Nome"><a href="#" id="assinaturaContratante"
                        data-type="text" data-placement="right" data-title="ASSINATURA DO CONTRATANTE">
                        <?php echo $rowBuscarInformacoesCliente['nomeCliente']; ?>
                      </a></span></b></p>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <p class="h3">Testemunhas: </p>
              </div>
              <div class="col-6">
                </BR>
                </BR>
                <hr class="bg-dark Assinatura-Linha" style="width: 50.5%;">

              </div>
              <div class="col-6">
                </BR>
                </BR>
                <hr class="bg-dark Assinatura-Linha" style="width: 50.5%;">

              </div>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td>
          <div class="footer">
            <br>
            <p class="text-center text-muted"> Rua Antônio Marins de Oliveira, 1126, São Mateus, São João de Meriti –
              21-97034-8381 </p>
            <hr style="width: 80%;" class="float-center">
          </div>
        </td>
      </tr>
    </tfoot>
  </table>
</body>

</html>