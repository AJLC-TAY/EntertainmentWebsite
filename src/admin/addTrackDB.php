<?php
/**
 * Php file that adds the new track in the database.
 * @author Alvin John Cutay
 */
    $albumid = $_POST['albumid'];
    $trackname = $_POST['newtrack'];
    $dir = "tracks/$albumid/";
    $dirInProject = "../public/".$dir;
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);
    $filepathInProject = "../public/".$filepath;
    $mv = trim($_POST['mvid']);

    /**
     * @param $query
     * @return int
     */
    function addTrack($query) {
        include ('../includes/database.php');
        $stmt = $database->stmt_init();
        $stmt->prepare($query);
        $stmt->execute();
        $stmt->close();
    }

    if ($_FILES['file']['size'] === 0) {
        if (strlen($mv) == 0 ){
            $query = "INSERT INTO tracks (tracks.name, albumid) VALUE('$trackname', '$albumid')";
        } else {
            $query = "INSERT INTO tracks (tracks.name, albumid, musicvideo) VALUE('$trackname', '$albumid', '$mv')";
        }
        addTrack($query);
    } else {
        // creates directory if album folder does not exist
        if (!is_dir($dirInProject)) {
            mkdir($dirInProject, 0755, true);
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepathInProject)) {
            $query = "INSERT INTO tracks (tracks.name, albumid, musicfile, musicvideo) VALUE('$trackname', '$albumid', '$filepath', '$mv')";
            addTrack($query);
        }
    }
