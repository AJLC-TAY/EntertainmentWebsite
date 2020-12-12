<?php
include ("../includes/sessionHandling.php");
include ('../includes/database.php');
if (isset($_POST['addartist'])) {
    $artistname = $_POST['name'];
    $nickname = $_POST['nickname'];
    $debutyear = $_POST['year'];
    $membernum = $_POST['number'];
    $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
    $filesize = $_FILES['file']['size'];

    $getartistid = "SELECT artistid FROM artists WHERE artistname='$artistname'";
//    $dbase= $database->stmt_init();
//    $dbase ->prepare($getartistid);
//    $dbase ->execute();
//    $dbase ->bind_result($artistid);
//    $dbase ->fetch();
//    $dbase ->close();

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
            $query = "INSERT INTO artists (artistname, nickname, debutyear, membernum, artistimage)  VALUE ('$artistname', '$artistnickname', '$debutyear', '$membernum', '$file');";
        } else {
            $query = "INSERT INTO artists (artistname, nickname, debutyear, membernum) VALUE ('$artistname', '$artistnickname', '$debutyear', '$membernum');";
        }
        if ($database->query($query) === TRUE) {
            $artistid = $database->insert_id;
            $database->close();
            $json = ['artistid' => $artistid];
            echo json_encode($json);
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
}
?>
