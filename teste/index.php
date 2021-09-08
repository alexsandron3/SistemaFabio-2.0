<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../includes/MDB/css/mdb.min.css">
  <!-- FONTES -->
  <link rel="stylesheet" href="../includes/plugins/Fontes/font-awesome.min.css">
  <link rel="stylesheet" href="../includes/plugins/Fontes/Material-Icons-Roboto.css">
  <!-- STYLE -->
  <link rel="stylesheet" href="../includes/plugins/MDBootstrap/css/material-kit.min.css">
  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.11.1/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/date-1.1.1/fc-3.3.3/fh-3.1.9/kt-2.6.4/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.5/sb-1.2.0/sp-1.4.0/sl-1.3.3/datatables.min.css" />
  <!-- PikaDay -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
  <!-- Personal css -->
  <link rel="stylesheet" href="../config/style.css">
  <!-- animation -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <title>Index</title>
</head>

<body>
  <!-- Navbar -->
  <?php include_once("../includes/htmlElements/navbar.php"); ?>
  <!-- Navbar -->
  <div class="container">
    <div class="row py-5">
      <div class="col-10 mx-auto">
        <div class="card rounded shadow border-0">
          <div class="card-body p-5 bg-white rounded" id="load-content">
            <div class="" id="msg">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <script type="text/javascript" src="../includes/MDB/js/mdb.min.js"></script>

  <!-- DATATABLES -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.11.1/af-2.3.7/b-2.0.0/b-colvis-2.0.0/b-html5-2.0.0/b-print-2.0.0/cr-1.5.4/date-1.1.1/fc-3.3.3/fh-3.1.9/kt-2.6.4/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.5/sb-1.2.0/sp-1.4.0/sl-1.3.3/datatables.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
  <script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>

  <script src="../includes/plugins/DataTables/configFiles/dataTablesRelVendas.js"> </script>
  <script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>

  <!-- JQUERY PLUGINS -->
  <script src="../includes/plugins/jqueryMask/src/jquery.mask.js"></script>
  <script src="../includes/plugins/JqueryRestrict/jquery.alphanum.js"> </script>
  <script src="../includes/plugins/jquery.validate.min.js"> </script>
  <script src="../config/novoScript.js"></script>
  <!-- Notify -->
  <script src="../includes/plugins/bootstrap-notify.min.js"></script>
  <script src="../includes/plugins/jquery.deserialize.js"></script>

  <!-- Main script -->
  <script src="main.js"></script>

</body>

</html>