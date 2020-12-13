<?php
include 'implementQuery.php';
include 'deleteTrackInFolder.php';

if(isset($_POST['save-track'])) {
    include '../includes/database.php';
    $albumid = $_POST['albumid'];
    $trackid = $_POST['trackid'];
    $trackname = $_POST["trackname"];
    $dir = "tracks/$albumid/";
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);
    if (strlen(trim($trackname)) == 0) {
        echo "<script>alert('Track name was empty');
                window.location.href = 'viewTracks.php?id=$albumid';
            </script>";
    } else {
        $query = "";
        if ($_FILES['file']['size'] > 0) {
            deleteTrackInFolder($trackid);
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
        saveChanges($query);
        header("Location: viewTracks.php?id=$albumid");
    }
}
