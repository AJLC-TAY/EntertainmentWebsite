<?php
    include ('../includes/database.php');
//    $artistname = $_POST['name'];
//    $nickname = $_POST['nname'];
//    $debutyear = $_POST['year'];
//    $membernum = $_POST['mnumber'];
//    $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
//    $filesize = $_FILES['file']['size'];
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


