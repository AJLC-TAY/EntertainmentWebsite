<?php

include '../includes/database.php';
if(isset($_POST['update'])) {
    $trackname = $_POST['trackname'];
    $trackid = $_POST['trackid'];
    $dir = "tracks/";
    $filename = $_FILES['file']['name'];
    $filepath = $dir . "\"".basename($filename)."\"";

    print_r($_FILES);
    print_r($filepath);
//    phpinfo();
    echo "<p>$filename</p>";

    if ($_FILES['file']['size'] > 0){
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
            print_r($filepath);
            $query = "UPDATE tracks SET musicfile='$filepath', track.name='$trackname' WHERE trackid='$trackid'";
            $stmt = $database->stmt_init();
            $stmt->prepare($query);
            $stmt->execute();
            $stmt->close();
            echo "<p>Successful</p>";
        } else {
            echo "<p>Unsuccessful</p>";
        }
    }


//    header('Location: updateTracks.php');
}
