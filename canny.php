<?php
$serverName        = "77.68.16.90";
$connectionOptions = array(
    "Database" => "Studentloan",
    "Uid"      => "Bisola_new",
    "PWD"      => "eiu947qwbjgf@#455"
 
    //"Encrypt"=>'Yes',
);


//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(FormatErrors(sqlsrv_errors()));
}

?>
