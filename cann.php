<?php
$serverName        = "77.68.16.90";
$connectionOptions = array(
    "Database" => "student",
    "Uid"      => "Bisola_new",
    "PWD"      => "eiu947qwbjgf@#455"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(FormatErrors(sqlsrv_errors()));
  
}
function FormatErrors($errors)
{
    /* Display errors. */
    echo "Error information: ";

    foreach ($errors as $error) {
        echo "SQLSTATE: " . $error['SQLSTATE'] . "";
        echo '<br>';
        echo "Code: " . $error['code'] . "";
        echo '<br>';

        echo "Message: " . $error['message'] . "";

    }
    

}
$tstamp= date('Y-m-d');

?>
