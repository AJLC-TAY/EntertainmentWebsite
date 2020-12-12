<?php
include ("../includes/database.php");
include ('../includes/dataclass.php');
$query = 'SELECT albumid, albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid)';
$stmt = $database->stmt_init();
$stmt -> prepare($query);
$stmt -> bind_result($albumid, $albumimg, $albumname, $artistname, $releaseddate);
$stmt -> execute();

$albums = [];
while($stmt -> fetch()) {
    $album = new Album($albumname, $artistname, $releaseddate, $albumimg);
    $album -> set_albumID($albumid);
    $albums[] = $album;
}
