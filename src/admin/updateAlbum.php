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

    // album form using bootstrap plugin
    echo "<div id='albumForm' style='width: 40vw'>";
    echo '<form action="saveAlbumChanges.php" method="post" enctype="multipart/form-data">';
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>';
    echo "        <input type='hidden' name='albumid' value='$albumid'>
                   <input class='form-control' id='name' name='name' type='text' value='$albumname'/>
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
            "<img id='currentimg' class='file' src='$albumimg' alt='$albumname image'><br>
             <input type='hidden' name='albumimg' value='$albumimg'>".
             '<label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
         </div>';
    echo '<div class="form-group ">'.
            "<input class='btn btn-primary' type='submit' name='save' value='Save Changes'>
             <input class='btn btn-secondary' type='submit' name='updateTracks' value='Update Tracks'>
             <input class='btn btn-danger' type='submit' name='delete' value='Delete Album'>
          </div></form>";
    echo "</div></div>";
include "../includes/bootstrapDatepicker.php";
echo '<script type="text/javascript" src="databaseCon.js"></script>';
include '../includes/footer.html';

?>

</body>
</html>
