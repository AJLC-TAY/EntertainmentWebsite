<? include '../includes/head.html'; ?>
    <title>Add Album | Admin</title>
</head>
<body>
<?php
    include '../includes/database.php';
    // album form using bootstrap plugin
    echo "<div class='path-links'>
              <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='addAlbum.php?' target='_self'>Add Album</a></pre>
    </div>";
    echo "<div id='albumForm' style='float: left; width: 40vw'>";
    echo '<form action="addAlbumDB.php" method="post" enctype="multipart/form-data">';
    echo '<div class="form-group">
              <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>
              <input class="form-control" id="name" name="name" type="text"/>
         </div>';
    echo '<div class="form-group ">
              <label class="control-label requiredField" for="artists">Select an artist <span class="asteriskField">*</span></label>
              <select class="select form-control" id="artists" name="artists">';

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
        echo "<option id='$art[0]'>$art[1]</option>";
    }
    $date = date("Y/m/d");
    echo '</select></div>';

    echo '<div class="form-group">
            <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>';
    echo "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$date'/>
           </div>";
    echo '<div class="form-group ">
              <label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
          </div>';
    echo '<button class="btn btn-secondary " name="addalbum" type="submit">Add Album</button></form>';

    // back link
    echo "<div><a href='albums.php'><button class='btn btn-link'><b><</b> Back</button></a></div>";
    echo '<script type="text/javascript" src="databaseCon.js"></script>';

    include '../includes/footer.php';
?>