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
$query = "SELECT artistimage, artistname, nickname, debutyear, membernum FROM artists WHERE artistid='$artistid'";
$stmt = $database->stmt_init();
$stmt->prepare($query);
$stmt->execute();
$stmt->bind_result($img, $artistname, $nickname, $debutyear, $membernum);
$stmt->fetch();

$artistimage = "data:image;base64,".base64_encode($img);
$stmt->close();
?>



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
                <img id='currentimg' class='file' src='<?php echo `$artistimage`?>' alt='<?php echo $artistname?> image'><br>
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
            <button class='btn btn-danger' type='button' onclick='deleteArtist()' style='margin-right: 10px;' name='delete'>Delete</button>
        </div>
    </form>

<?php
    if (isset($_POST['save'])) {
        include '../includes/database.php';
        $filesize = $_FILES['file']['size'];
        $artistid = $_POST['artistid'];
        $artistname = trim($_POST['name']);
        $nickname = trim($_POST['nname']);
        $debutyear = trim($_POST['year']);
        $membernum = trim($_POST['mnumber']);
        $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));


        $getartistid = "SELECT artistid FROM artists WHERE artistname='$artistname'";
        $dbase= $database->stmt_init();
        $dbase ->prepare($getartistid);
        $dbase ->execute();
        $dbase ->bind_result($artistid);
        $dbase ->fetch();
        $dbase ->close();

        if (strlen($artistname) == 0) {
            echo "<script>
                        alert('Please provide the name of the artist.');
                        document.getElementById('name').focus();
                   </script>";
        } elseif (strlen($nickname) == 0) {
            echo "<script>
                    alert('Please provide the nickname of the artist.');
                    document.getElementById('nname').focus();
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
        }


            else {
                if ($filesize <= 70000) {
                    if ($filesize > 0) {
                        $query = "UPDATE artists SET artistname='$artistname', nickname='$nickname', debutyear='$debutyear', artistimage='$file' WHERE artistid='$artistid'";
                    } else {
                        $query = "UPDATE artists SET artistname='$artistname', nickname='$nickname', debutyear='$debutyear' WHERE artistid='$artistid'";
                    }
                    $database->query($query);
                    echo "<script> window.location.href = 'artist.php'; </script>";
                } else {
                    echo "<script>alert('Image size is larger than 70KB')</script>";
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
