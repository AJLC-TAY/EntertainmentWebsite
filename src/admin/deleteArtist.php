<?php
    include ("../includes/sessionHandling.php");
    include "../includes/database.php";
    $artistid = $_GET['id'];

    $query = "SELECT artistimage FROM artists WHERE artistid='$artistid'";
    $dbase = $database->stmt_init();
    $dbase ->prepare($query);
    $dbase ->bind_result($imagepath);
    $dbase ->execute();
    $dbase ->fetch();
    $dbase ->close();

    $query = "DELETE FROM artists WHERE artistid='$artistid'";
    $dbase = $database->stmt_init();
    $dbase ->prepare($query);
    $dbase ->execute();
    $dbase ->close();
    unlink("$imagepath");
    header("Location: artist.php");