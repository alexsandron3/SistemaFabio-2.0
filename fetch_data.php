<?php
if(isset($_POST['get_option']))
{
 $host = 'localhost';
 $user = 'root';
 $pass = '';
 mysql_connect($host, $user, $pass);
 mysql_select_db('sistema_teste');

 $idPasseio = $_POST['idPasseio'];
 $find=mysql_query("SELECT nomePasseio FROM passeio WHERE idPasseio='$idPasseio'");
 while($row=mysql_fetch_array($find))
 {
  echo "<option>".$row['city']."</option>";
 }
 exit;
}
?>