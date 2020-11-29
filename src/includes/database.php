<?php
    $database = new mysqli("p:localhost", "root", "", "bighitent", 3308);

    if ($database->connect_error) {
        die("Connection failed: ".$database->connect_error);
    }
    echo "Connected successfully";
?>