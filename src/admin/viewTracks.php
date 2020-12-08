<?php include '../includes/head.html'; ?>
    <title>View Tracks | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
    </head>
    <body>
    <?php
    // admin.tracks
    $albumid = $_GET['id'];
    include '../includes/database.php';
    include '../includes/dataclass.php';
    include '../includes/trackclass.php';

    echo "<div class='path-links'>
        <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='updateAlbum.php?id=$albumid' target='_self'>Update Album</a> / <a class='focus' href='javascript:history.go(0)'>Tracks</a></pre>
    </div>";

    $query = "SELECT albumimg, albumname FROM albums JOIN artists USING(artistid) WHERE albumid='$albumid'";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($imgbin, $albumname);
    $stmt->fetch();
    $albumimg = "data:image;base64,".base64_encode($imgbin);

//    function displayTrack($trackid, $albumid, $trackFile, $trackname) {
//        echo prepareTrack($trackid, $albumid, $trackFile, $trackname);
//    }
//
//    function prepareTrack($trackid, $albumid, $trackFile, $trackname) {
//        return "<tr id='{$trackid}row'>
//                        <td colspan='3'>
//                        <form id='{$trackid}form' class='row'  action='' method='post' enctype='multipart/form-data'>
//                            <input type='hidden' name='albumid' value='$albumid'>
//                            <div class='form-group col'>
//                                <input name='trackid' type='hidden' value='$trackid'/>
//                                <input id='{$trackid}name'class='form-control' name='trackname' type='text' value='$trackname'/>
//                            </div>
//                            <div class='col'>
//                                <audio controls>
//                                    <source id='{$trackid}audio' src='$trackFile' type='audio/mpeg'>
//                                        Your browser does not support the audio tag.
//                                </audio>
//                            </div>
//                            <div class='form-group col'>
//                                <input class='form-control' name='file' accept='.mp3' type='file'/>
//                            </div>
//                             <div class='form-group col'>
//                                <button type='button' class='btn btn-secondary' onclick='updateTrack($trackid)' name='update'>Update</button>
//                                <button type='button' class='btn btn-danger'   onclick='deleteTrack($trackid)' name='delete'>Delete</button>
//                            </div>
//                       </form>
//                       </td>
//                </tr>";
//    }

    function displayTrack($trackid, $albumid, $trackFile, $trackname) {
        echo "<tr id='{$trackid}row'>
                        <td colspan='3'>
                        <form id='{$trackid}form' class='row'  action='' method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='albumid' value='$albumid'>
                            <div class='form-group col'>
                                <input name='trackid' type='hidden' value='$trackid'/>
                                <input id='{$trackid}name'class='form-control' name='trackname' type='text' value='$trackname'/>
                            </div>
                            <div class='col'>
                                <audio controls>
                                    <source id='{$trackid}audio' src='$trackFile' type='audio/mpeg'>
                                        Your browser does not support the audio tag.
                                </audio>
                            </div>
                            <div class='form-group col'>
                                <input class='form-control' name='file' accept='.mp3' type='file'/>
                            </div>
                             <div class='form-group col'>
                                <button type='button' class='btn btn-secondary' onclick='updateTrack($trackid)' name='update'>Update</button>
                                <button type='button' class='btn btn-danger'   onclick='deleteTrack($trackid)' name='delete'>Delete</button>
                            </div>
                       </form>
                       </td>
                </tr>";
    }

//    /**
//     * @param mysqli $database
//     * @param $query
//     * @return int
//     */
//    function addTrackToDB($query) {
//        include '../includes/database.php';
//        $addStmt = $database->stmt_init();
//        $addStmt->prepare($query);
//        $addStmt->execute();
//        $newid = $addStmt->insert_id; // saves the newly created id
//        $addStmt->close();
//        return $newid;
//    }
//    function addTrack($trackname, $albumid, $dir, $filepath) {
//        include '../includes/database.php';
//        if (strlen($trackname) != 0) {
//            if ($_FILES['file']['size'] === 0) {
//                $query = "INSERT INTO tracks (tracks.name, albumid) VALUE('$trackname', '$albumid')";
//                $newid = addTrackToDB($query);
//                $track = new Track ($newid, $albumid, $trackname);
//            } else {
//                // creates directory if album folder does not exist
//                if (!is_dir($dir)) {
//                    mkdir($dir, 0755, true);
//                }
//                if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
//                    $query = "INSERT INTO tracks (tracks.name, albumid, musicfile) VALUE('$trackname', '$albumid', '$filepath')";
//                    $newid = addTrackToDB($query);
//                    $track = new Track ($newid, $albumid, $trackname);
//                    $track->setFilepath($filepath);
//
//                }
//            }
//        }
//    }


    ?>

    <div class='row' style='margin: auto 0;'>
    <?php echo "<div class='album-con'>
                <div style='border: #1f1f1f 1px solid'><img class='albumimg' src='$albumimg' alt='$albumname image'>
                    <h5>$albumname</h5>
                    <p>ID: $albumid</p>
                </div>
                <div class='addtrack_form'>
                    <h5>Add new track here:</h5>
                    <form id='trackdetail' action=' ' method='post' enctype='multipart/form-data'>
                        <input type='hidden' name='albumid' value='$albumid'>
                        <label for='trkname'>Trackname <span class='asteriskField'>*</span> </label>
                        <input id='trkname' class='form-control' name='newtrack' type='text' placeholder='Enter name'/><br>
                        <p id='addTrackFormMsg' style='color: red;'></p>
                        <label id='test' for='mfile'>Upload music file: </label><br>
                        <input id='mfile' class='form-control' name='file' accept='.mp3' type='file'/><br>
                        <button id='test' type='submit' name='addTrack' class='btn btn-secondary'>Add track</button>
        
          </form>";

//            if (isset($_POST['addTrack'])) {
//                $dom = new DOMDocument('1.0', 'utf-8');
//                $newtrack =  $_POST['newtrack'];
//                if (strlen(trim($newtrack)) == 0) {
//                    echo "<script>
//                         let addTrackForm = document.querySelector('.addtrack_form');
//                         let errormsg = document.getElementById('addTrackFormMsg');
//                         errormsg.innerHTML = 'Please provide a track name.';
//                         document.getElementById('trkname').focus();
//                        </script>";
//                } else if (strlen(trim($newtrack)) > 0){
//                    echo "<script>let errmsg = document.getElementById('addTrackFormMsg');
//                            errmsg.innerHTML = ''; </script>";
//                    $albumid = $_POST['albumid'];
//                    $trackname = $_POST['newtrack'];
//                    $dir = "tracks/$albumid/";
//                    $filename = $_FILES['file']['name'];
//                    $filepath = $dir .basename($filename);
//                    $file = $_FILES['file'];
//
//
//                    echo `<script>
//                            alert("test");
//                           await testAddTrack($albumid, $trackname, $filepath);
//                        </script>`;
//
//
//                }
//            }

            echo "
                </div>
          </div>";
    $query = "SELECT trackid, tracks.name, musicfile FROM tracks WHERE albumid='$albumid'";
    $stmt = $database->stmt_init();
    $stmt -> prepare($query);
    $stmt -> bind_result($trackid, $name, $musicFile);
    $stmt -> execute();

    $tracks = [];
    while($stmt -> fetch()) {
        $track = new Track($trackid, $albumid, $name);
        $track->setFilepath($musicFile);
        $tracks[] = $track;
    }
    ?>
    <table id='trackstable' class='table col'>
        <thead class='thead-dark'>
            <tr>
                <th scope='col' style='width: 300px'>Track name</th>
                <th scope='col' style='width: 300px'>Music File</th>
                <th scope='col' style='width: auto;'>Upload File</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tracks as $track) {
                $trackid = $track->getTrackid();
                $albumid = $track->getAlbumid();
                $trackFile = $track->getFilepath();
                $trackname = $track->getTrackname();
                displayTrack($trackid, $albumid, $trackFile, $trackname);
            }
            ?>

        </tbody>
      </table>
  </div>


    <div class="row justify-content-between"><a href='<?php echo "updateAlbum.php?id=$albumid" ?>'><button class='btn btn-link'><b><</b> Back</button></a>
         <a href='albums.php'><button class='btn btn-link'>Go to Albums</button></a>
    </div>
    <script type="text/javascript" src="update.js"></script>

<?php include '../includes/footer.php'; ?>
