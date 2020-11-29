<?php
//    include("database.php");

    $database = new mysqli("p:localhost", "root", "", "bighitent", 3308);

    function loadArtistToDB() {
        $database = new mysqli("p:localhost", "root", "", "bighitent", 3308);
        $data = file_get_contents('../jsonfiles/artist.json');
        $json = json_decode($data,true)['artists'];
        foreach ($json as $value) {
            $artistname = $value['name'];
            $nickname = $value['nickname'];
            $debutYear = $value['debutYear'];
            $memberNum = $value['memberNo'];

            $stmt = $database->stmt_init();
            $stmt->prepare("INSERT INTO artists (artistname, nickname, debutyear, membernum) VALUE (?, ?, ?, ?)");
            $stmt->bind_param('ssdd', $artistname, $nickname, $debutYear, $memberNum);
            $stmt->execute();

            printf("%d Row inserted.\n", $stmt->affected_rows);
            $stmt->close();
        }
    }

    function loadTopTracks() {
        $database = new mysqli("p:localhost", "root", "", "bighitent", 3308);
        $data = file_get_contents('../jsonfiles/toptracks.json');
        $json = json_decode($data,true)['toptracks'];
        foreach ($json as $value) {
            $albumname = $value['albumName'];
            $releasedate = $value['releasdate'];
            $albumimg = $value['img'];
            $name = $value['name'];
            $albumid = $value['albumid'];

            $stmt2 = $database->stmt_init();
            $stmt2->prepare("SELECT EXISTS(SELECT * from albums WHERE albumname=?)");
            $stmt2->bind_param('s', $albumname);
            $stmt2->execute();
            $stmt2->bind_result($exists);
            $stmt2->fetch();
            $stmt2->close();
            if (!$exists) {
                $stmt2 = $database->stmt_init();
                $stmt2->prepare("INSERT INTO albums (albumname, artistname, releaseddate, imgurl, spotifyalbumid) VALUE (?, ?, ?, ?, ?)");
                $stmt2->bind_param('sssss', $albumname, $name, $releasedate, $albumimg, $albumid);
                $stmt2->execute();

                printf("%d Row inserted.\n", $stmt2->affected_rows);
                $stmt2->close();
            }
        }
    }


    function downloadAlbumimages () {
        $database = new mysqli("p:localhost", "root", "", "bighitent", 3308);
        $query = 'SELECT albumid, imgurl FROM albums';
        $stmt = $database->stmt_init();
        $stmt->prepare($query);
        $stmt->execute();
        $stmt->bind_result($albumid, $imgurl);

        $url = [];

        while ($stmt->fetch()) {
            $url[] = [$albumid, $imgurl];
        }

        $stmt->close();

        foreach ($url as $link) {
            $id = $link[0];
            $httplink = $link[1];

            $img = "../images/album/".$id.".jpg";
            file_put_contents($img, file_get_contents($httplink));
        }

    }

//    downloadAlbumimages();
//    loadArtistToDB();
//    loadTopTracks($database);
?>