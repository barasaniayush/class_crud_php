<?php
    define("servername","localhost");
    define("username","root");
    define("password","");
    define("dbname","college");

    $conn = new mysqli(servername,username,password,dbname);
    if(!$conn) {
        die("Error in database connection".mysqli_connect_error());
    } 
?>