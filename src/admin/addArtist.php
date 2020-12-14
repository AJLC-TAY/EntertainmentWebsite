<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html');?>

    <title>Add Artist | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>

<?php include '../includes/navbanner.php'?>
<div class="container">
    <div class='path-links'>
        <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'>Artists</a> / <a href='addArtist.php?' target='_self'><b>Add Artist</b></a></pre>
    </div>
    <div class="form-con">
        <h4>Please enter the following artist information:</h4>
        <form id='artistform' method="post" enctype="multipart/form-data" action="">
            <div class="form-group">
                <label class="control-label requiredField" for="artistname">Artist name <span class="asteriskField">*</span></label>
                <input class="form-control" id="artistname" name="name" type="text" required/>
            </div>
            <div class="form-group ">
                <label class="control-label requiredField" for="nickname">Nickname</label>
                <input class="form-control" id="nickname" name="nname" type="text"/></div>

            <div class="form-group">
                <label class="control-label requiredField" for="debutyear">Debut Year <span class="asteriskField">*</span></label>
                <input class='form-control' id='debutyear' name='year' placeholder='YYYY' type='text' required/>
            </div>
            <div class="form-group ">
                <label class="control-label requiredField" for="membernum">Number of Members <span class="asteriskField">*</span></label>
                <input class="form-control" id="membernum" name="mnumber" type="number" required/></div>

            <div class="form-group ">
                <label class="control-label" for="img">Upload Image</label>
                <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
            </div>
        </form>
        <div class="footer-but-con row justify-content-between">
            <a href='artist.php'><button class='btn btn-link'><b><</b> Back</button></a>
            <?php
            echo " <button type='submit' class='btn btn-secondary' name='addartist' form='artistform'>Add Artist</button>";
            if (isset($_POST['addartist'])) {
                include "../includes/database.php";
                $filesize = $_FILES['file']['size'];
                $artistname = $_POST['name'];
                $nickname = $_POST['nname'];
                $debutyear = $_POST['year'];
                $membernum = $_POST['mnumber'];
                $filename = $_FILES['file']['name'];
                $dir = "artists/";
                $filepath = $dir.basename($filename);
                $file = addslashes(@file_get_contents($_FILES['file']['tmp_name']));
                if ($filesize <= 5000000) {

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {
                        if ($filesize > 0) {
                            $query = "INSERT INTO artists (artistname, nickname, debutyear, membernum, artistimage)  VALUE ('$artistname', '$nickname', '$debutyear', '$membernum', '$filepath');";
                        } else {
                            $query = "INSERT INTO artists (artistname, nickname, debutyear, membernum) VALUE ('$artistname', '$nickname', '$debutyear', '$membernum');";
                        }
                        if ($database->query($query) === TRUE) {
                            echo "<script>window.location.href = 'artist.php'</script>";
                        }
                    }
                } else {
                    echo "<script>alert('Image size is larger than 5MB')</script>";
                }
            }
            ?>


        </div>
    </div>

</div>
<!--    <script type="text/javascript" src="update.js"></script> -->
<?php include '../includes/footer.php'; ?>
