<?php
/**
 * A page that lets the admin add new album to the system.
 * @author Alvin John Cutay
 */
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
    <title>Add Album | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
<?php include '../includes/navbanner.php'?>
<div class="container">
    <div class='path-links'>
        <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='addAlbum.php?' target='_self'><b>Add Album</b></a></pre>
    </div>
    <div class="form-con">
        <h4>Please enter the following album information:</h4>
        <form id='albumform' method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="name" type="text" required/>
            </div>
            <div class="form-group ">
                <label class="control-label requiredField" for="artists">Select an artist</label>
                <select class="select form-control" id="artists" name="artists">
                    <?php
                    include '../includes/database.php';
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
                    ?>

                </select></div>

            <div class="form-group">
                <label class="control-label requiredField" for="date">Released Date <span class="asteriskField">*</span></label>
                <input class='form-control' id='date' name='date' placeholder='YYYY-MM-DD' type='text' value='<?php $date?>' required/>
            </div>
            <div class="form-group ">
                <label class="control-label" for="image">Upload Image</label>
                <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
            </div>
        </form>
        <div class="footer-but-con row justify-content-between">
            <a href='albums.php'><button class='btn btn-link'><b><</b> Back</button></a>
            <?php
            echo " <button type='submit' class='btn btn-secondary' name='addalbum' form='albumform' >Add Album</button>";
            if (isset($_POST['addalbum'])) {
                include '../includes/database.php';
                $albumname = $_POST['name'];
                $artistname = $_POST['artists'];
                $releaseddate = $_POST['date'];
                $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
                $filesize = $_FILES['file']['size'];

                $getartistid = "SELECT artistid FROM artists WHERE artistname='$artistname'";
                $dbase= $database->stmt_init();
                $dbase ->prepare($getartistid);
                $dbase ->execute();
                $dbase ->bind_result($artistid);
                $dbase ->fetch();
                $dbase ->close();

                if (strlen(trim($albumname)) == 0) {
                    echo "<script>
                                alert('Please provide the name of the album.');
                                document.getElementById('name').focus();
                           </script>";
                } else {
                    if (strlen(trim($releaseddate)) == 0) {
                        echo "<script>
                                alert('Please provide the release date of the album.');
                                document.getElementById('date').focus();
                           </script>";
                    }
                    else {
                        if ($filesize > 0) {
                            $query = "INSERT INTO albums (albumname, albums.artistid, releaseddate, albumimg)  VALUE ('$albumname', '$artistid', '$releaseddate', '$file');";
                        } else {
                            $query = "INSERT INTO albums (albumname, albums.artistid, releaseddate) VALUE ('$albumname', '$artistid', '$releaseddate');";
                        }
                        if ($database->query($query) === TRUE) {
                            echo "<script> window.location.href = 'albums.php'; </script>";
                        }
                    }
                }
            }?>
        </div>
    </div>

</div>
    <script type="text/javascript" src="update.js"></script>
<?php include '../includes/footer.php'; ?>