<?php

include '../includes/database.php';
if(isset($_POST['update'])) {
    $albumid = $_POST['albumid'];
    $trackname = $_POST['trackname'];
    $trackid = $_POST['trackid'];
    $dir = "tracks/$albumid/";
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);

    $query = "";
    if ($_FILES['file']['size'] > 0){
        // creates directory if album folder does not exist
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
            $query = "UPDATE tracks SET musicfile='$filepath', tracks.name='$trackname' WHERE trackid='$trackid'";
        }
    } else {
        $query = "UPDATE tracks SET tracks.name='$trackname' WHERE trackid='$trackid'";
    }
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->close();
    header('Location: updateTracks.php');
}
