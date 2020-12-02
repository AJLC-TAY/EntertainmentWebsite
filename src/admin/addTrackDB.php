<?php
include '../includes/database.php';

$albumid = $_POST['albumid'];
$trackname = $_POST['newtrack'];
$dir = "tracks/$albumid/";
$filename = $_FILES['file']['name'];
$filepath = $dir .basename($filename);

if (strlen($trackname) != 0) {
    // creates directory if album folder does not exist
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
        $query = "INSERT INTO tracks (tracks.name, albumid, musicfile) VALUE('$trackname', '$albumid', '$filepath')";
        $stmt = $database->stmt_init();
        $stmt->prepare($query);
        $stmt->execute();
        $stmt->close();
        header("Location: viewTracks.php?id=$albumid");
        echo "<script>alert('success');</script>";
    }
} else {
    echo "<script>alert('Please provide a track name');</script>";
//    header("Location: updateTracks.php?id=$albumid");

}





