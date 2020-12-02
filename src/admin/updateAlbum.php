<?php include '../includes/head.html'; ?>
    <title>Update Album | Admin</title>
</head>
<body>
<?php
    $albumid = $_GET['id'];
    require '../includes/database.php';
    require '../includes/dataclass.php';
    echo "<div class='path-links'>
              <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='updateAlbum.php?id=$albumid' target='_self'>Update Album</a></pre>
    </div>";
    $query = "SELECT albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid) WHERE albumid='$albumid'";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($imgbin, $albumname, $artistname, $releaseddate);
    $stmt->fetch();

    $albumimg = "data:image;base64,".base64_encode($imgbin);
    $stmt->close();

    echo "<div class='container row'>";

    echo "<div id='albumForm' style='width: 40vw'>";
    echo '<form action="saveAlbumChanges.php" method="post" enctype="multipart/form-data">';
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>';
    echo "        <input type='hidden' name='albumid' value='$albumid'>
                   <input class='form-control' id='name' name='name' type='text' value='$albumname'/>
             </div>";
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="artists">Select artist <span class="asteriskField">*</span></label>
                  <select class="select form-control" id="artists" name="artists">';

    require "require/getArtists.php";
    foreach ($artists as $art) {
        $artid = $art->get_artistid();
        $name = $art->get_artistName();
        if ($name == $artistname) {
            echo "<option id='$artid' selected>$name</option>";
        } else {
            echo "<option id='$artid'>$name</option>";
        }
    }
    echo '</select></div>';

    echo '<div class="form-group ">
                <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>';
    echo "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$releaseddate'/>
               </div>";
    echo '<div class="form-group ">'.'<label class="control-label" for="currentimg">Current Image</label><br>'.
            "<img id='currentimg' class='file' src='$albumimg' alt='$albumname image'><br>
             <input type='hidden' name='albumimg' value='$albumimg'>".
             '<label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
         </div>';
    echo '<div class="form-group ">'.
            "<input class='btn btn-primary' type='submit' name='save' value='Save Changes'>
             <input class='btn btn-danger' type='submit' name='delete' value='Delete Album'>
          </div>
          </form>
             <a href='viewTracks.php?id=$albumid'><input class='btn btn-secondary' type='button' value='View Tracks'></a>";
    echo "</div></div>";

echo "<div><a href='albums.php'><button class='btn btn-link'><b><</b> Back</button></a></div>";


echo '<script type="text/javascript" src="databaseCon.js"></script>';
include '../includes/footer.php';
echo "<link rel='stylesheet' href='style.css'>";

?>

</body>
</html>
