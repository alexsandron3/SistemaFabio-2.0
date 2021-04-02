<?php
    $host = "localhost"; /* Host name */
    $user = "root"; /* User */
    $password = ""; /* Password */
    $dbname = "fabiosistema2"; /* Database name */

    $mysqli = mysqli_connect($host, $user, $password,$dbname);
    // Check connection
    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }