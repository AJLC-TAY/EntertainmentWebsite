
<?php
/**
 * A page that allows the admin to update an artist's information.
 *
 * @author Gwyneth Calica
 */
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

// Contains the navigation links
echo "<div class='container'>

    <div class='path-links'>
              <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'>Artists</a> / <a href='updateArtist.php.php?id=$artistid' target='_self'><b>Update Artist</b></a></pre>
        </div>";

    // Fetches the artist's information from the database
    $query = "SELECT artistimage, artistname, nickname, debutyear, membernum FROM artists WHERE artistid='$artistid'";
    $stmt = $database->stmt_init();
    $stmt->prepare($query);
    $stmt->execute();
    $stmt->bind_result($img, $artistname, $nickname, $debutyear, $membernum);
    $stmt->fetch();
    $stmt->close();
    $imgPathInProject = "../public/".$img;
    ?>

    <!--Form that lets the admin provide changes from the artist's information-->
    <div class="form-con">
        <h4>Please provide changes for the artist:</h4>
        <form id='artistform' method="post" enctype="multipart/form-data" action="">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="control-label requiredField" for="artistname">Artist name <span class="asteriskField">*</span></label>


                        <input type='hidden' name='artistid' value=<?php echo $artistid?> />
                        <input class="form-control" id="artistname" name="name" type="text" required value="<?php echo $artistname?>"/>
                    </div>
                    <div class="form-group ">
                        <label class="control-label requiredField" for="nickname">Nickname</label>
                        <input class="form-control" id="nickname" name="nname" type="text" value="<?php echo $nickname?>"/>
                    </div>
                </div>

                <div class="form-group col">
                    <label class="control-label" for="currentimg">Current Image</label><br>
                    <img id='currentimgartist' class='file' src='<?php echo $imgPathInProject?>' alt='<?php echo $artistname?> image'><br>
                    <input type='hidden' name='artistimage' value='$artistimage'>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label requiredField" for="debutyear">Debut Year <span class="asteriskField">*</span></label>
                <input class='form-control' id='debutyear' name='year' placeholder='YYYY' type='text' required value="<?php echo $debutyear?>"/>
            </div>
            <div class="form-group">
                <label class="control-label requiredField" for="membernum">Number of Members <span class="asteriskField">*</span></label>
                <input class="form-control" id="membernum" name="mnumber" type="number" required value="<?php echo $membernum?>"/></div>

            <div class='form-group'>
                <label class="control-label" for="image">Upload Image</label>
                <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
            </div>

            <div class='form-group d-flex flex-row-reverse'>
                <button class='btn btn-success' type='submit' name='save' form='artistform'>Save</button>
        <?php  echo "<a href='deleteArtist.php?id=".$artistid."' onClick=\"javascript:return confirm(`Are you sure you want to delete this artist?`);\" class='btn btn-danger' style='margin-right: 10px;'>Delete</a>";?>
            </div>
            </div>
        </form>

<?php
// Saves changes in updating artist's information
    if (isset($_POST['save'])) {
        include '../includes/database.php';
        $artistid = $_POST['artistid'];
        $artistname = trim($_POST['name']);
        $nickname = trim($_POST['nname']);
        $debutyear = trim($_POST['year']);
        $membernum = trim($_POST['mnumber']);
        $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
        $filesize = $_FILES['file']['size'];

        $getartist = "SELECT artistid, artistimage FROM artists WHERE artistname='$artistname'";
        $dbase = $database->stmt_init();
        $dbase->prepare($getartist);
        $dbase->execute();
        $dbase->bind_result($artistid, $imagepath);
        $dbase->fetch();
        $dbase->close();
        $imagepath = "../public/".$imagepath;

        if (strlen($artistname) == 0) {
            echo "<script>
                        alert('Please provide the name of the artist.');
                        document.getElementById('name').focus();
                   </script>";
        } elseif (strlen($debutyear) == 0) {
            echo "<script>
                    alert('Please provide the debut year of the artist.');
                    document.getElementById('year').focus();
              </script>";
        } elseif (strlen($membernum) == 0) {
            echo "<script>
                  alert('Please provide the number of member artist.');
                  document.getElementById('number').focus();
            </script>";
        } else {
            $filename = $_FILES['file']['name'];
            $dir = "artists/";
            $dirInProject = "../public/".$dir;
            $filepath = $dir.basename($filename);
            $filepathInProject = "../public/".$filepath;
            $filepath = $dir.basename($filename);
            //The image file size to be uploaded is less than or 5 mb
            if ($filesize <= 5000000) {
                if ($filesize > 0) {
                    if (file_exists($imagepath)) {
                        unlink("$imagepath");
                    }
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepathInProject)) {
                        $query = "UPDATE artists SET artistname='$artistname', nickname='$nickname', debutyear='$debutyear', membernum='$membernum', artistimage='$filepath' WHERE artistid='$artistid'";
                    }
                } else {
                    $query = "UPDATE artists SET artistname='$artistname', nickname='$nickname', debutyear='$debutyear', membernum='$membernum' WHERE artistid='$artistid'";
                }
                if ($database->query($query) === TRUE) {
                    echo "<script> window.location.href = 'artist.php'; </script>";
                }
            } else {
                echo "<script>alert('Image size is larger than 5MB')</script>";
            }
        }
    }
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
