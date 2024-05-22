<?php

$server = "localhost"; 
$user = "root"; 
$pass = ""; 
$database = "educonnect"; 

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn)
{
    die("<script>alert('Something went wrong, please try again!')</script>");
}

?>