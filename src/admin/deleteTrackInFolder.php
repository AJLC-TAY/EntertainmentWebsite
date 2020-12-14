<?php
//include ("../includes/sessionHandling.php");
// delete file from folder
function deleteTrackInFolder ($trackid) {
    include '../includes/database.php';
    // get the file path of track to be delete from the database
    $getfilepathqry = $database->stmt_init();
    $query = "SELECT musicfile FROM tracks WHERE trackid='$trackid'";
    $getfilepathqry->prepare($query);
    $getfilepathqry->execute();
    $getfilepathqry->bind_result($musicFilePath);
    $getfilepathqry->fetch();

    if (strlen($musicFilePath) != 0) {
        unlink($musicFilePath);
    }
    $getfilepathqry->close();
}