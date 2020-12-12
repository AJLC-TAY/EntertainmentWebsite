<?php
include ("../includes/sessionHandling.php");
include ('../includes/database.php');
if(isset($_POST['save'])) {
    $albumid = $_POST['albumid'];
    $albumname = $_POST['name'];
    $artist = $_POST['artists'];
    $releaseddate = $_POST['date'];
    $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
    $filesize = $_FILES['file']['size'];

    $getartistid = "SELECT artistid FROM artists WHERE artistname='$artist'";
    $dbase= $database->stmt_init();
    $dbase ->prepare($getartistid);
    $dbase ->execute();
    $dbase ->bind_result($artistid);
    $dbase ->fetch();
    $dbase ->close();

    $query = "";
    if ($filesize <= 70000) {
        if ($filesize > 0) {
            $query = "UPDATE albums SET albumname='$albumname', albums.artistid='$artistid', releaseddate='$releaseddate', albumimg='$file' WHERE albumid='$albumid'";
        } else {
            $query = "UPDATE albums SET albumname='$albumname', albums.artistid='$artistid', releaseddate='$releaseddate' WHERE albumid='$albumid'";
        }
        $database->query($query);
//        echo "<script>window.location.assign('albums.php');</script>";

//        if ($database->query($query)) {
//            header('Location: albums.php');
//        }
    } else {
        echo "<div class='err'>ERROR: Image size is larger than 70KB</div>";
    }
} else if(isset($_POST['updateTracks'])) {
    include "viewTracks.php";
}
?>