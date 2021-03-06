<?php
/**
 * Php file update an track's information in the database.
 *
 * @author Alvin John Cutay
 */
include 'implementQuery.php';
include 'deleteTrackInFolder.php';

if(isset($_POST['save-track'])) {
    include '../includes/database.php';
    $albumid = $_POST['albumid'];
    $trackid = $_POST['trackid'];
    $trackname = $_POST["trackname"];
    $dir = "tracks/$albumid/";
    $dirInProject = "../public/".$dir;
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);
    $filepathInProject = "../public/".$filepath;
    $mv = trim($_POST['mvid']);
    if (strlen(trim($trackname)) == 0) {
        echo "<script>alert('Track name was empty');
                window.location.href = 'viewTracks.php?id=$albumid';
            </script>";
    } else {
        $query = "";
        if ($_FILES['file']['size'] > 0) {
            deleteTrackInFolder($trackid);
            // creates directory if album folder does not exist
            if (!is_dir($dirInProject)) {
                mkdir($dirInProject, 0755, true);
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $filepathInProject)) {
                if (strlen($mv) == 0) {
                    $query = "UPDATE tracks SET musicfile='$filepath', tracks.name='$trackname' WHERE trackid='$trackid'";
                } else {
                    $query = "UPDATE tracks SET musicfile='$filepath', tracks.name='$trackname', musicvideo='$mv' WHERE trackid='$trackid'";
                }
            }
        } else {
            if (strlen($mv) == 0) {
                $query = "UPDATE tracks SET tracks.name='$trackname' WHERE trackid='$trackid'";
            } else {
                $query = "UPDATE tracks SET tracks.name='$trackname', musicvideo='$mv' WHERE trackid='$trackid'";
            }

        }
        saveChanges($query);
        header("Location: viewTracks.php?id=$albumid");
    }
}
