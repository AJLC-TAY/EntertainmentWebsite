<?php
    include ('../includes/database.php');
    $query = "";
    if ($filesize > 0) {
        $query = "INSERT INTO artists (artistname, nickname, debutyear, membernum, artistimage)  VALUE ('$artistname', '$nickname', '$debutyear', '$membernum', '$file');";
    } else {
        $query = "INSERT INTO artists (nartistname, nickname, debutyear, membernum) VALUE ('$artistname', '$nickname', '$debutyear', '$membernum');";
    }
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->close();


