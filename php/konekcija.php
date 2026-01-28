<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "baza";

$db=mysqli_connect($host, $username, $password, $database);

if ($db==TRUE) {
    // print "Uspesno povezano";
} 
else {
    print "Konekcija nije uspela";
}
?>
