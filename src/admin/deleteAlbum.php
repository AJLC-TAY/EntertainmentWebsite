<?php
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