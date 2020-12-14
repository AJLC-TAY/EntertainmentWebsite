<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>


    <title>View Tracks | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
    </head>
    <body>
    <?php
    include '../includes/navbanner.php';
    include '../includes/database.php';
    include '../includes/dataclass.php';
    include '../includes/trackclass.php';
    // admin.tracks
    $albumid = $_GET['id'];

    $query = "SELECT albumimg, albumname FROM albums JOIN artists USING(artistid) WHERE albumid='$albumid'";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($imgbin, $albumname);
    $stmt->fetch();
    $albumimg = "data:image;base64,".base64_encode($imgbin);

    function displayTrack($trackid, $albumid, $trackFile, $trackname) {
        echo "<tr id='{$trackid}row'>
                        <td colspan='3'>
                        <form id='{$trackid}form' class='row' action='updateTrack.php' method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='albumid' value='$albumid'>
                            <div class='form-group col'>
                                <input name='trackid' type='hidden' value='$trackid'/>
                                <input id='{$trackid}name' class='form-control' name='trackname' type='text' value='$trackname' required/>
                            </div>
                            <div class='col'>
                                <audio controls>
                                    <source id='{$trackid}audio' src='$trackFile' type='audio/mpeg'>
                                        Your browser does not support the audio tag.
                                </audio>
                            </div>
                            <div class='form-group col row'>
                                <input class='form-control' name='file' accept='.mp3' type='file'/>
                            </div>
                            <div class='track-buttons'>
                                <a href='deleteTrack.php?albumid=$albumid&trackid=$trackid' onclick='javascript:return confirm(`Are you sure you want to delete this track?`)' type='submit' class='btn btn-danger small-del'><img src='../images/delete.png' title='Delete track'></a>
                                <button type='submit' class='btn btn-dark' name='save-track'><img src='../images/saveicon.png' title='Save changes'></button>
                            </div>
                       </form>
                       </td>
                </tr>";
    }
    ?>

    <div id="view-tracks-con" class="">
        <?php echo "<div class='path-links'>
            <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='updateAlbum.php?id=$albumid' target='_self'>Update Album</a> / <a class='focus' href='javascript:history.go(0)'><b>Tracks</b></a></pre>
        </div>
        <div class='tracks-view-con row'>
            <div class='album-con'>
                <div class='album-view-con'><img class='albumimg' src='$albumimg' alt='$albumname image'>
                    <h5>$albumname</h5>
                    <p>ID: $albumid</p>
                     <div class='row album-form-btns flex-row-reverse'>
                        <a href='updateAlbum.php?id=$albumid'>
                            <button class='btn btn-link'>Update Album?</button>
                        </a>
                        <!-- <button id='add-track-btn' class='btn btn-secondary' onclick='showAddTrackForm()'>Add a Track</button> -->
                    </div>
                </div>
                <div class='addtrack_form'>
                    <h5>Add new track here:</h5>
                    <form id='trackdetail' action=' ' method='post' enctype='multipart/form-data'>
                        <input type='hidden' name='albumid' value='$albumid'>
                        <label for='trkname'>Trackname <span class='asteriskField'>*</span> </label>
                        <input id='trkname' class='form-control' name='newtrack' type='text' placeholder='Enter name' required/><br>
                        <label id='test' for='mfile'>Upload music file: </label><br>
                        <input id='mfile' class='form-control' name='file' accept='.mp3' type='file'/><br>
                        
                        <div class='row flex-row-reverse'><button id='add-track-btn' type='submit' name='addTrack' class='btn btn-secondary'>Add track</button></div>
                    </form>";
                    if (isset($_POST['addTrack'])) {
                        $newtrack =  $_POST['newtrack'];
                        if (strlen(trim($newtrack)) == 0) {
                            echo "<script>
                                    alert('Please provide a track name.');
                                    document.getElementById('trkname').focus();
                                 </script>";
                        } else if (strlen(trim($newtrack)) > 0){
                            include 'addTrackDB.php';
                        }
                    }
            echo "
                </div>
          </div>";
            $query = "SELECT trackid, tracks.name, musicfile FROM tracks WHERE albumid='$albumid'";
            $stmt = $database->stmt_init();
            $stmt->prepare($query);
            $stmt->bind_result($trackid, $name, $musicFile);
            $stmt->execute();

            $tracks = [];
            while ($stmt->fetch()) {
                $track = new Track($trackid, $albumid, $name);
                $track->setFilepath($musicFile);
                $tracks[] = $track;
            }
            ?>
            <div class="table-con overflow-auto">
            <table id='trackstable' class='table col'>
                <thead class='thead-dark'>
                <tr>
                    <th scope='col' style='width: 265px'>Track name</th>
                    <th scope='col' style='width: 250px'>Music File</th>
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
        </div>

<!--        <div class="row justify-content-between">-->
<!--            <a href='--><?php //echo "updateAlbum.php?id=$albumid" ?><!--'>-->
<!--                <button class='btn btn-primary'>Update Album</button>-->
<!--            </a>-->
<!--            <a href='albums.php'>-->
<!--                <button class='btn btn-link'>Go to Albums</button>-->
<!--            </a>-->
<!--        </div>-->
    </div>

    </body>
    
    <script type="text/javascript" src="update.js"></script>

<?php include '../includes/footer.php'; ?>

