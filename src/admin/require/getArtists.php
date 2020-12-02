<?php
    $query = "SELECT artistid, artistname 
              FROM artists";
    $result = $database->query($query);
    $artists = [];
    while($row = $result->fetch_assoc()) {
        $artists[] = new Artist($row['artistid'], $row['artistname']);
    }
    $result->close();
