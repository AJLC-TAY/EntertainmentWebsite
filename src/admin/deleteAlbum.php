<?php
$albumid = $_GET['id'];
include "../includes/database.php";
$query = "DELETE FROM albums WHERE albumid='$albumid'";
if ($database->query($query) === TRUE) {
    header("Location: albums.php");
}
$database->close();
