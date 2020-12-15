<?php
/**
 * Php file that deletes the track file with the given track ID in the project.
 *
 * @author Alvin John Cutay
 */
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
        unlink("../public/".$musicFilePath);
    }
    $getfilepathqry->close();
}