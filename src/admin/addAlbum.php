<? include '../includes/head.html'?>
    <title>Add Album | Admin</title>
</head>
<body>
<?php
    include '../includes/database.php';
    include '../includes/bootstrapDatepicker.php';

    // back link
    echo "<div><a href='albums.php'><button class='btn btn-link'>< Back</button></a></div>";

    // album form using bootstrap plugin
    echo "<div id='albumForm' style='float: left; width: 40vw'>";
    echo '<form method="post" enctype="multipart/form-data">';
    echo '<div class="form-group ">
              <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>
              <input class="form-control" id="name" name="name" type="text"/>
         </div>';
    echo '<div class="form-group ">
              <label class="control-label requiredField" for="artists">Select a Choice <span class="asteriskField">*</span></label>
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

    echo '<div class="form-group ">
            <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>';
    echo "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$date'/>
           </div>";
    echo '<div class="form-group ">
              <label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
          </div>';
    echo '<button class="btn btn-secondary " name="addalbum" type="submit">Add Album</button></form>';
    echo '<script type="text/javascript" src="databaseCon.js"></script>';

//    echo '<form action="" enctype="multipart/form-data" method="post">
//            <label for="name">Album Name</label>
//            <input type="text" name="albumname" required><br>
//            <div class="form-group">
//                  <label for="artistname">Artist Name</label>
//                  <select class="form-control" id="artistname" required>
//                  <option id="0"></option>';
//
//    $query = "SELECT artistid, artistname FROM artists";
//    $stmt = $database->stmt_init();
//    $stmt->prepare($query);
//    $stmt->execute();
//    $stmt->bind_result($artistid, $artistname);
//    $artists = [];
//    while($stmt->fetch()) {
//        $artists[] = [$artistid, $artistname];
//    }
//
//    foreach ($artists as $art) {
//        echo "<option id='$art[0]'>$art[1]</option>";
//    }
//    echo '</select>
//            </div>
//            <label for="date">Date Released</label>
//                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
//             <label for="image">Image</label>
//            <input type="file" id="img" name="file" accept="image/*" required>
//            <center><button class="btn btn-secondary">Add</button></center>
//          </form>';
?>
<!--</body>-->
<?php
//    include 'footer.html';
//?>
<!--</html>-->