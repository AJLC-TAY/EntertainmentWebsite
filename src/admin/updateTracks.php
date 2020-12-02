<?php include '../includes/head.html'; ?>
    <title>Update Tracks | Admin</title>
    <style>
        [name='file'] {
            width: 300px;
        }
        [name='trackname'] {
            width: 250px;
        }

        .albumimg {
            width: 180px;
            height: auto;
        }

        .album-con {
            text-align: center;
        }
    </style>
    </head>
    <body>
<?php
// admin.tracks
include '../includes/database.php';
$albumid = $_POST['albumid'];
$albumname = $_POST['name'];
$albumimg = $_POST['albumimg'];

echo "<div class='row' style='margin: auto 0;'>";
echo "<div class='center col-2 album-con'>
            <img class='albumimg' src='$albumimg' alt='$albumname image'>
            <h5>$albumname</h5>
            <p>ID: $albumid</p>
      </div>";

echo "<div id='tracklist' class='col-10'>";
$query = "SELECT trackid, tracks.name, musicfile FROM tracks WHERE albumid=$albumid";
$stmt = $database->stmt_init();
$stmt -> prepare($query);
$stmt -> bind_result($trackid, $name, $musicFile);
$stmt -> execute();

$tracks = [];
while($stmt -> fetch()) {
    $tracks[] = [$trackid, $name, $musicFile];
}

echo "<table class='table col'>
            <thead class='thead-dark'>
                <tr>
                    <th scope='col' style='width: 300px'>Track name</th>
                    <th scope='col' style='width: 300px'>Music File</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan='3'>";

                    foreach ($tracks as $track) {
                        echo "<form class='row' action='updateTrack.php' method='post' enctype='multipart/form-data'>
                              <input type='hidden' name='albumid' value='$albumid'>";
                        echo "<div class='form-group col'>
                                <input name='trackid' type='hidden' value='$track[0]'/>
                                <input class='form-control' id='$track[0]' name='trackname' type='text' value='$track[1]'/>
                              </div>";
                        echo "<div class='col'>
                                    <audio controls>
                                        <source src='$track[2]' type='audio/mpeg'>
                                            Your browser does not support the audio tag.
                                    </audio>
                              </div>";
                        echo "<div class='form-group col'>
                                <input class='form-control' id='$track[0]' name='file' accept='audio/mpeg4-generic' type='file'/>
                              </div>";
                        echo "<div class='form-group col'>
                                <button type='submit' class='btn btn-secondary' name='update'>Update</button>
                                <a href='deleteTrack.php' target='_self'><button class='btn btn-danger'>Delete</button></a>
                              </div>";

                        echo "</form>";
                    }

echo            "</td></tr>
            </tbody>
      </table></div>";
echo "</div>";
include '../includes/footer.html';
?>
    </body>
</html>