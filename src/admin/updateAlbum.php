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
    $stmt->close(); ?>

    <div class='container row'>

    <div style='width: 40vw'>

    <form id="albumform" method="post" enctype="multipart/form-data">
            <?php
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>';
    echo "        <input type='hidden' name='albumid' value='$albumid'>
                   <input class='form-control' id='name' name='name' type='text' value='$albumname'/>
             </div>";
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="artists">Select artist</label>
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
         </div>'."

        <div class='form-group'>
            <button class='btn btn-danger' type='button' onclick='deleteAlbum()' name='delete'>Delete</button>
            <button class='btn btn-primary' type='button' onclick='updateAlbum()' name='save'>Save</button>
        </div>
    </form>";
    ?>

    </div></div>

    <div class="row justify-content-between">
        <a href='albums.php'><button class='btn btn-link'><b><</b> Back</button></a>
        <a href='<?php echo "viewTracks.php?id=$albumid" ?>'><button class='btn btn-link' type='button'>View Tracks <b>></b></button></a>
    </div>
    <script type="text/javascript" src="update.js"></script>
    <link rel='stylesheet' href='style.css'>
</body>

<?php include '../includes/footer.php'; ?>

