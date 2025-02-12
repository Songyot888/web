<?php
    $server = "localhost";
    $username = "db_student";
    $password = "db_student";
    $dbname = "db_student";

    $conn = new mysqli($server, $username, $password, $dbname);
    $conn->set_charset("utf8");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
