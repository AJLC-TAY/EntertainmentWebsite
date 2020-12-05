<?php
	include ("database.php");


	$query = "SELECT * FROM albums JOIN artists";

	$stmt = $database -> stmt_init();
	$stmt -> prepare($query);
	$stmt -> execute();
	$stmt -> bind_result($albumid, $albumname, $artistid, $artistname, $releasedate, $albumimg, $imgurl, $spotifyalbumid, $artistid, $artistname, $nickname, $artistimage, $debutyear, $membernum);

	include ("dataclass.php");

	$artists = [];

	while ($stmt->fetch()){
		$artist = new Artist($artistid, $artistname);
		$artists[] = $artist;
	}

	$stmt ->close();
	echo json_encode($artists);

?>
