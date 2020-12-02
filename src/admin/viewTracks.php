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
        .addtrack_form {

        }
    </style>
    </head>
    <body>
<?php
// admin.tracks
$albumid = $_GET['id'];
include '../includes/database.php';
require '../includes/dataclass.php';

echo "<div class='path-links'>
         <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='updateAlbum.php?id=$albumid' target='_self'>Update Album</a> / <a href='javascript:history.go(0)'>Tracks</a></pre>
      </div>";

$query = "SELECT albumimg, albumname FROM albums JOIN artists USING(artistid) WHERE albumid='$albumid'";
$stmt = $database->stmt_init();
$stmt->prepare($query);
$stmt->execute();
$stmt->bind_result($imgbin, $albumname);
$stmt->fetch();
$albumimg = "data:image;base64,".base64_encode($imgbin);

echo "<div class='row' style='margin: auto 0;'>";
echo "<div class='album-con'>
            <div style='border: #1f1f1f 1px solid'><img class='albumimg' src='$albumimg' alt='$albumname image'>
                <h5>$albumname</h5>
                <p>ID: $albumid</p>
            </div>
            <div class='addtrack_form'>
                <form action='addTrackDB.php' ' method='post' enctype='multipart/form-data' onsubmit='return validateTrack()'>
                    <input type='hidden' name='albumid' value='$albumid'>
                    <label for='trkname'>Trackname: </label>
                    <input id='trkname' class='form-control' name='newtrack' type='text' placeholder='Enter name'/><br>
                    <label for='mfile'>Upload music file: </label><br>
                    <input id='mfile' class='form-control' name='file' accept='.mp3' type='file'/><br>
                    <input type='submit' class='form-control' name='addtrack' value='Add track'>
                </form>
            </div>
      </div>";
$query = "SELECT trackid, tracks.name, musicfile FROM tracks WHERE albumid='$albumid'";
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
                                <input type='hidden' name='albumid' value='$albumid'>
                                <div class='form-group col'>
                                    <input name='trackid' type='hidden' value='$track[0]'/>
                                    <input class='form-control' id='$track[0]' name='trackname' type='text' value='$track[1]'/>
                                </div>
                                <div class='col'>
                                    <audio controls>
                                        <source src='$track[2]' type='audio/mpeg'>
                                            Your browser does not support the audio tag.
                                    </audio>
                                </div>
                                <div class='form-group col'>
                                    <input class='form-control' id='$track[0]' name='file' accept='.mp3' type='file'/>
                                </div>
                                <div class='form-group col'>
                                    <button type='submit' class='btn btn-secondary' name='update'>Update</button>
                                    <button type='submit' class='btn btn-danger' name='delete'>Delete</button>
                                </div>
                               </form>";
                    }
echo            "</td></tr>
            </tbody>
      </table>
  </div>";
echo "</div>";

// back link
echo "<div><a href='updateAlbum.php?id=$albumid'><button class='btn btn-link'><b><</b> Back</button></a>
       <a href='albums.php'><button class='btn btn-link'>Go to Albums</button></a></div>";

include '../includes/footer.php';
echo "<link rel='stylesheet' href='style.css'>";
?>
    </body>
</html>