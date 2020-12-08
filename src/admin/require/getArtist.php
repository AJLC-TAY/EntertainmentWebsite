<?php
include "../includes/database.php";
include '../includes/dataclass.php';
$query = 'SELECT artistid, artistimage, artistname, nickname, debutyear, membernum FROM artists';
$stmt = $database->stmt_init();
$stmt -> prepare($query);
$stmt -> bind_result($artistid, $artistimage, $artistname, $nickname, $debutyear, $membernum);
$stmt -> execute();

$artists = [];
while($stmt -> fetch()) {
    $artist = new ArtistDetail($artistid, $artistimage, $artistname, $nickname, $debutyear, $membernum);
    $artist -> set_artistid($artistid);
    $artists[] = $artist;
}
