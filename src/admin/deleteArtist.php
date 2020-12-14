<?php
include ("../includes/sessionHandling.php");
$artistid = $_GET['id'];
include "../includes/database.php";
$query = "DELETE FROM artists WHERE artistid='$artistid'";
$dbase = $database->stmt_init();
$dbase ->prepare($query);
$dbase ->execute();
$dbase ->close();
