<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
<title>Update Artist | Admin</title>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>
</head>
<body>
<?php
include '../includes/navbanner.php';
require '../includes/database.php';
require '../includes/dataclass.php';
$artistid = $_GET['id'];

echo "<div class='container'>

    <div class='path-links'>
              <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'>Artists</a> / <a href='updateArtist.php.php?id=$artistid' target='_self'><b>Update Artist</b></a></pre>
        </div>";
$query = "SELECT albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid) WHERE albumid='$artistid'";
$stmt = $database->stmt_init();
$stmt->prepare($query);
$stmt->execute();
$stmt->bind_result($imgbin, $albumname, $artistname, $releaseddate);
$stmt->fetch();

$albumimg = "data:image;base64,".base64_encode($imgbin);
$stmt->close(); ?>


<div class="form-con">
    <h4>Please provide changes for the album:</h4>
    <form id="albumform" method="post" enctype="multipart/form-data">
        <?php
        echo '<div class="form-group ">
                  <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>'
            ."        <input type='hidden' name='albumid' value='$artistid'>
                   <input class='form-control' id='name' name='name' type='text' value='$albumname'/>
             </div>";

        echo '<div class="form-group ">
                <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>'.
            "  <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='$releaseddate'/>
               </div>";
        echo '<div class="form-group ">'.'<label class="control-label" for="currentimg">Current Image</label><br>'.
            "<img id='currentimg' class='file' src='$albumimg' alt='$albumname image'><br>
             <input type='hidden' name='albumimg' value='$albumimg'>".
            '<label class="control-label" for="image">Upload Image</label>
              <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
         </div>'."

        <div class='form-group'>
            <button class='btn btn-danger' type='button' onclick='deleteArtist()' name='delete'>Delete</button>
            <button class='btn btn-primary' type='button' onclick='updateArtist()' name='save'>Save</button>
        </div>
    </form>";
        ?>
        <div class="row justify-content-between">
            <a href='artist.php'><button class='btn btn-link'><b><</b> Back</button></a>
        </div>
</div>
</div>


<script type="text/javascript" src="update.js"></script>
<link rel='stylesheet' href='style.css'>
</body>

<?php include '../includes/footer.php'; ?>

