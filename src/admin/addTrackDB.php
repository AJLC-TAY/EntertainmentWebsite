<?php
include '../includes/database.php';
include '../includes/trackclass.php';

$albumid = $_POST['albumid'];
$trackname = $_POST['newtrack'];
$dir = "tracks/$albumid/";
$filename = $_FILES['file']['name'];
$filepath = $dir .basename($filename);

/**
 * @param mysqli $database
 * @param $query
 * @return int
 */
function addTrack(mysqli $database, $query)
{
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $newid = $stmt->insert_id; // saves the newly created id
    $stmt->close();
    return $newid;
}

if (strlen($trackname) != 0) {
    if ($_FILES['file']['size'] === 0) {
        $query = "INSERT INTO tracks (tracks.name, albumid) VALUE('$trackname', '$albumid')";
        $newid = addTrack($database, $query);
        $json = new Track ($newid, $albumid, $trackname);
    } else {
        // creates directory if album folder does not exist
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
            $query = "INSERT INTO tracks (tracks.name, albumid, musicfile) VALUE('$trackname', '$albumid', '$filepath')";
            $newid = addTrack($database, $query);
            $json = new Track ($newid, $albumid, $trackname);
            $json->setFilepath($filepath);
        }
    }
    echo json_encode($json);
} else {
//    echo "<script>alert('Please provide a track name');</script>";
//    header("Location: updateTracks.php?id=$albumid");

}





