
<?php
/**
 * A page that allows the admin to delete an artist's information.
 *
 * @author Gwyneth Calica
 */
    include ("../includes/sessionHandling.php");
    include "../includes/database.php";
    $artistid = $_GET['id'];

    //Select the artist resord to be deleted
    $query = "SELECT artistimage FROM artists WHERE artistid='$artistid'";
    $dbase = $database->stmt_init();
    $dbase ->prepare($query);
    $dbase ->bind_result($imagepath);
    $dbase ->execute();
    $dbase ->fetch();
    $dbase ->close();

    //Deletes the artist record from the database
    $query = "DELETE FROM artists WHERE artistid='$artistid'";
    $dbase = $database->stmt_init();
    $dbase ->prepare($query);
    $dbase ->execute();
    $dbase ->close();
    unlink("../public/$imagepath");
    header("Location: artist.php");
