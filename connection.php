<?php
    $servername = "localhost";
    $database = "fisio";
    $username = "root";
    $password = "";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
    //mysqli_close($conn);
?>