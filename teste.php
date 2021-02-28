<pre>

<?php
   session_start();

   include_once("PHP/functions.php");

   echo calculaIntervaloTempo($conn, "log", "dataLog", "idLog=50", null);

?> 