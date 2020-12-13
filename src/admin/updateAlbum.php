<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
    <title>Update Album | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
<?php
    $albumid = $_GET['id'];
    include '../includes/navbanner.php';
    require '../includes/database.php';
    require '../includes/dataclass.php';

    echo "<div class='container'>

        <div class='path-links'>
              <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='updateAlbum.php?id=$albumid' target='_self'><b>Update Album</b></a></pre>
        </div>";
    $query = "SELECT albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid) WHERE albumid='$albumid'";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($imgbin, $albumname, $artistname, $releaseddate);
    $stmt->fetch();

    $albumimg = "data:image;base64,".base64_encode($imgbin);
    $stmt->close(); ?>

    <div class="form-con">
        <h4>Please provide changes for the album:</h4>
    <form id="albumform" action=' ' method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-7">
                   <div class="form-group ">
                        <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>
                  <?php
                    echo "    
                        <input type='hidden' name='albumid' value='$albumid'>
                        <input class='form-control' id='name' name='name' type='text' value='$albumname' required/>
                   </div>".
                    '<div class="form-group ">
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
                            echo '</select>
                    </div>
              </div>
              <div class="form-group col-5 current-img-con"> 
                  <label class="control-label" for="currentimg">Current Image</label><br>'.
                "<img id='currentimg' class='file' src='$albumimg' alt='$albumname image'><br>
                 <input type='hidden' name='albumimg' value='$albumimg'>
              </div>
          </div>";

    echo '<div class="form-group ">
                <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>'.
         "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$releaseddate' required/>
               </div>";
    echo '<div class="form-group ">
             <label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
         </div>'."

        <div class='form-group d-flex flex-row-reverse'>
           <!-- <button class='btn btn-success' type='button' onclick='updateAlbum()' name='save'>Save</button> -->
            <button class='btn btn-success' type='submit' name='save' form='albumform'>Save</button>
            <!-- <button class='btn btn-danger' type='button' onclick='deleteAlbum()' style='margin-right: 10px;' name='delete'>Delete</button> -->
            <a href='deleteAlbum.php?id=".$albumid."' onClick=\"javascript:return confirm('Are you sure you want to delete this?');\" class='btn btn-danger' style='margin-right: 10px;'>Delete</a>
        </div>
    </form>";

    if (isset($_POST['save'])) {
        include '../includes/database.php';
        $albumid = $_POST['albumid'];
        $albumname = trim($_POST['name']);
        $artist = $_POST['artists'];
        $releaseddate = trim($_POST['date']);
        $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
        $filesize = $_FILES['file']['size'];

        $getartistid = "SELECT artistid FROM artists WHERE artistname='$artist'";
        $dbase= $database->stmt_init();
        $dbase ->prepare($getartistid);
        $dbase ->execute();
        $dbase ->bind_result($artistid);
        $dbase ->fetch();
        $dbase ->close();

        if (strlen($albumname) == 0) {
            echo "<script>
                        alert('Please provide the name of the album.');
                        document.getElementById('name').focus();
                   </script>";
        } else {
            if (strlen($releaseddate) == 0) {
                echo "<script>
                        alert('Please provide the release date of the album.');
                        document.getElementById('date').focus();
                   </script>";
            }
            else {
                if ($filesize <= 70000) {
                    if ($filesize > 0) {
                        $query = "UPDATE albums SET albumname='$albumname', albums.artistid='$artistid', releaseddate='$releaseddate', albumimg='$file' WHERE albumid='$albumid'";
                    } else {
                        $query = "UPDATE albums SET albumname='$albumname', albums.artistid='$artistid', releaseddate='$releaseddate' WHERE albumid='$albumid'";
                    }
                    $database->query($query);
                    echo "<script> window.location.href = 'albums.php'; </script>";
                } else {
                    echo "<script>alert('Image size is larger than 70KB')</script>";
                }
            }
        }
    }
    ?>
        <div class="row justify-content-between">
            <a href='albums.php'><button class='btn btn-link'><b><</b> Albums</button></a>
            <a href='<?php echo "viewTracks.php?id=$albumid" ?>'><button class='btn btn-link' type='button'>View Tracks <b>></b></button></a>
        </div>
    </div>
</div>
    <script type="text/javascript" src="update.js"></script>
    <link rel='stylesheet' href='style.css'>
</body>

<?php include '../includes/footer.php'; ?>