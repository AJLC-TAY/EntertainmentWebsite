<?php
    $albumid = $_POST['albumid'];
    $trackname = $_POST['newtrack'];
    $dir = "tracks/$albumid/";
    $filename = $_FILES['file']['name'];
    $filepath = $dir .basename($filename);

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
        $query = "INSERT INTO tracks (tracks.name, albumid) VALUE('$trackname', '$albumid')";
        addTrack($query);
    } else {
        // creates directory if album folder does not exist
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
            $query = "INSERT INTO tracks (tracks.name, albumid, musicfile) VALUE('$trackname', '$albumid', '$filepath')";
            addTrack($query);
        }
    }
