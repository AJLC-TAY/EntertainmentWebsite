<?php
/**
 * Php file that deletes the track with the given track ID in the database.
 *
 * @author Alvin John Cutay
 */
session_start();
include 'implementQuery.php';
include 'deleteTrackInFolder.php';

$albumid = $_GET['albumid'];
$trackid = $_GET['trackid'];
deleteTrackInFolder($trackid);
// delete track in database
$query = "DELETE FROM tracks WHERE trackid='$trackid'";
saveChanges($query);
header("Location: viewTracks.php?id=$albumid");