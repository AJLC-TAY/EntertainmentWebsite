<?php
function saveChanges($query) {
    include '../includes/database.php';
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->close();
}
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

if(isset($_POST['update'])) {
    include '../includes/database.php';
    $albumid = $_POST['albumid'];
    $trackname = $_POST['trackname'];
    $trackid = $_POST['trackid'];
    $dir = "tracks/$albumid/";
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);

    $query = "";
    if ($_FILES['file']['size'] > 0){
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
//    echo json_encode(["filepath" => $filepath]);
//    header("Location: viewTracks.php?id=$albumid");
} elseif (isset($_POST['delete'])) {
    include '../includes/database.php';
    $albumid = $_POST['albumid'];
    $trackid = $_POST['trackid'];
    deleteTrackInFolder($trackid);
    // delete track in database
    $query = "DELETE FROM tracks WHERE trackid='$trackid'";
    saveChanges($query);
//    header("Location: viewTracks.php?id=$albumid");
}
