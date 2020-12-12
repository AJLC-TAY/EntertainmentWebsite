<?php
include ("../includes/sessionHandling.php");
include ('../includes/database.php');
if (isset($_POST['addartist'])) {
    $artistname = $_POST['name'];
    $nickname = $_POST['nname'];
    $debutyear = $_POST['year'];
    $membernum = $_POST['mnumber'];
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
            $query = "INSERT INTO artists (name, nname, year, mnumber, img)  VALUE ('$artistname', '$nickname', '$debutyear', '$membernum', '$file');";
        } else {
            $query = "INSERT INTO artists (name, nname, year, mnumber) VALUE ('$artistname', '$nickname', '$debutyear', '$membernum');";
        }
    if ($database->query($query) === TRUE) {
            $artistid = $database->insert_id;
            $database->close();
            $json = ['artistid' => $artistid];
            echo json_encode($json);

        }

    } else {
        echo "<div class='err'>ERROR: Image size is larger than 70KB</div>";
    }
}
?>
