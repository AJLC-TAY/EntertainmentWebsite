<?php
include ('../includes/database.php');
//if (isset($_POST['addalbum'])) {
    $albumname = $_POST['name'];
    $artistname = $_POST['artists'];
    $releaseddate = $_POST['date'];
    $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
    $filesize = $_FILES['file']['size'];

    $getartistid = "SELECT artistid FROM artists WHERE artistname='$artistname'";
    $dbase= $database->stmt_init();
    $dbase ->prepare($getartistid);
    $dbase ->execute();
    $dbase ->bind_result($artistid);
    $dbase ->fetch();
    $dbase ->close();

    $query = "";
    if ($filesize <= 700000) {
        if ($filesize > 0) {
            $query = "INSERT INTO albums (albumname, albums.artistid, releaseddate, albumimg)  VALUE ('$albumname', '$artistid', '$releaseddate', '$file');";
        } else {
            $query = "INSERT INTO albums (albumname, albums.artistid, releaseddate) VALUE ('$albumname', '$artistid', '$releaseddate');";
        }
        if ($database->query($query) === TRUE) {
//            $albumid = $database->insert_id;
//            $database->close();
//            $json = ['albumid' => $albumid];
//            echo json_encode($json);
//            header("Location: viewTracks.php?id=$albumid");
        }
//        $stmt = $database->stmt_init();
//        $stmt->prepare($query);
//        $stmt->execute();
//        $stmt->bind_result($albumid);
//        $stmt->fetch();



    } else {
        echo "<div class='err'>ERROR: Image size is larger than 70KB</div>";
    }
//}
?>