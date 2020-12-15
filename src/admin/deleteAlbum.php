<?php
/**
 * Php file that deletes the album with the given album ID in the database.
 *
 * @author Alvin John Cutay
 */
$albumid = $_GET['id'];
include "../includes/database.php";
$query = "DELETE FROM albums WHERE albumid='$albumid'";
$dbase = $database->stmt_init();
$dbase ->prepare($query);
$dbase ->execute();
$dbase ->close();
$dirname = "tracks/$albumid";
array_map('unlink', glob("$dirname/*.*"));
rmdir($dirname);
header("Location: albums.php");