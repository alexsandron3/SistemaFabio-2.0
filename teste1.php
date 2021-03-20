<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!------ Include the above in your HEAD tag ---------->

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
  <link rel="stylesheet" href="./config/style.css">

</head>

<body>
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-8 col-md-10 ml-auto mr-auto">
        <h4><small>Simple With Actions</small></h4>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center">#</th>
                <th>Passeio</th>
                <th>Data</th>
                <th>Vagas Disponíveis</th>
                <th class="text-right">Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center">1</td>
                <td>ILHA GRANDE</td>
                <td>2020</td>
                <td>5</td>
                <td class="td-actions text-right">

                  <a href="#" id="modalActivate" class="btn btn-info btn-just-icon btn-sm" data-toggle="modal" data-target="#listaDeClientes">
                    <i class="material-icons">groups</i>
                  </a>
                  <a href="#" class="btn btn-danger btn-just-icon btn-sm">
                    <i class="material-icons">money_off</i>
                  </a>
                  <a href="#" class="btn btn-dark btn-just-icon btn-sm">
                    <i class="material-icons">summarize</i>
                  </a>
                  <a href="#" class="btn btn-success btn-just-icon btn-sm">
                    <i class="material-icons">price_check </i>

                  </a>

                </td>
              </tr>
            </tbody>
          </table>


          <!-- Modal -->
          <div class="modal fade right" id="listaDeClientes" tabindex="-1" role="dialog" aria-labelledby="listaDeClientesLabel" aria-hidden="true">
            <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
              <div class="modal-content-full-width modal-content ">
                <div class=" modal-header-full-width   modal-header text-center">
                  <h5 class="modal-title w-100" id="listaDeClientesLabel">Lista de Clientes</h5>
                  <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span style="font-size: 1.3em;" aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="http://fabiopasseios.hopto.org/develop/SistemaFabio-2.0/listaPasseio.php?id=5" title="W3Schools Free Online Web Tutorials"></iframe>
                  </div>
                </div>
                <div class="modal-footer-full-width  modal-footer">
                  <button type="button" class="btn btn-danger btn-md btn-rounded" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary btn-md btn-rounded">Save changes</button>
                </div>
              </div>
            </div>
          </div>

        </div>


      </div>
    </div>
  </div>
  </div>

  <footer class="footer text-center ">
    <p>Made with <a href="https://demos.creative-tim.com/material-kit/index.html" target="_blank">Material Kit</a> by
      Creative Tim</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

</body>