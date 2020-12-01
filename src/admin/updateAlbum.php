<?php include '../includes/head.html'; ?>
    <title>Update Album | Admin</title>
</head>
<body>
<?php

    $albumid = $_POST['albumid'];
    $albumname = $_POST['albumname'];
    $artname = $_POST['artistname'];
    $albumimg = $_POST['albumimage'];
    $releaseddate = $_POST['releaseddate'];

    echo "<div class='container row'>";
//    echo "<div class='col album'> <img class='albumimage' src='$albumimg' alt='$albumname image'>
//            <p><span class='artistname'>$albumid</span><br>
//                <span class='albumname'>$albumname</span><br>
//                <span class='artistname'>$artistname</span><br>
//                <span class='date'>$releaseddate</span>
//            </p>";

    // album form using bootstrap plugin
    echo "<div id='albumForm' style='width: 40vw'>";
    echo '<form action="saveAlbumChanges.php" method="post" enctype="multipart/form-data">';
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>';
    echo "<input class='form-control' id='name' name='name' type='text' value='$albumname'/>
             </div>";
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="artists">Select an Artist <span class="asteriskField">*</span></label>
                  <select class="select form-control" id="artists" name="artists">';

    require '../includes/database.php';
    $query = "SELECT artistid, artistname FROM artists";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($artistid, $artistname);
    $artists = [];
    while($stmt->fetch()) {
        $artists[] = [$artistid, $artistname];
    }
    foreach ($artists as $art) {
        if ($art[1] == $artname) {
            echo "<option id='$art[0]' selected>$art[1]</option>";
        } else {
            echo "<option id='$art[0]'>$art[1]</option>";
        }
    }
    $stmt->close();

    echo '</select></div>';

    echo '<div class="form-group ">
                <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>';
    echo "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$releaseddate'/>
               </div>";
    echo '<div class="form-group ">'.'<label class="control-label" for="currentimg">Current Image</label><br>'.
                    "<img id='currentimg' class='albumimage' src='$albumimg' alt='$albumname image'><br>".
                  '<label class="control-label" for="image">Upload Image</label>
                  <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
              </div>';
    echo '<div class="form-group ">'."<button class='btn btn-primary' type='submit'>Save Changes</button> </div></form>";
    echo "
                <form method='post' action='updateTracks.php' target='_self'>
                    <input type='hidden' name='albumid' value='$albumid'>
                    <input type='hidden' name='albumimg' value='$albumimg'>
                    <input type='hidden' name='albumname' value='$albumname'>
                    <button class='btn btn-secondary' name='updateTracks' type='submit'>Update Tracks</button>
                </form>

               <!-- <a href='updateTracks.php?id={$albumid}'><button class='btn btn-secondary' name='updateTracks'>Update Tracks</button></a> -->
                <a href='deleteAlbum.php?id={$albumid}'><button class='btn btn-danger' name='deleteAlbum'>Delete Album</button></a></div>";
    echo "</div>";
include '../includes/footer.html';
?>
<script type="text/javascript" src="databaseCon.js"></script>
</body>
</html>
