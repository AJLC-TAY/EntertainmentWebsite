<?php
$getartistid = "SELECT artistid FROM artists WHERE artistname='$artistname'";
$dbase= $database->stmt_init();
$dbase ->prepare($getartistid);
$dbase ->execute();
$dbase ->bind_result($artistid);
$dbase ->fetch();
$dbase ->close();
