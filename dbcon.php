<?php
$host="localhost";
$username="u439213217_mehndi_profile";
$password="MU.bRg~5Vc6KD)c";
$dbname="u439213217_mehndi_profile";

$conn=mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
    die("connection failed: ". mysqli_connect_error());
}
// else{
//     echo "connection successfull";
// }
?>