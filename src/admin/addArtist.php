<?
include ("../includes/sessionHandling.php");
include ('../includes/head.html');?>

    <title>Add Artist | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>
<body>

<?php include '../includes/navbanner.php'?>
<?php include '../includes/database.php'?>
<div class="container">
    <div class='path-links'>
        <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'>Artists</a> / <a href='addArtist.php?' target='_self'><b>Add Artist</b></a></pre>
    </div>
    <div class="form-con">
        <h4>Please enter the following artist information:</h4>
        <form id='artistform' method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label requiredField" for="name">Artist name <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="name" type="text"/>
            </div>
            <div class="form-group ">
                <label class="control-label requiredField" for="name">Nickname <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="name" type="text"/></div>

            <div class="form-group">
                <label class="control-label requiredField" for="date">Debut Year <span class="asteriskField">*</span></label>
                <input class='form-control' id='year' name='year' placeholder='YYYY' type='year' required/>
            </div>
            <div class="form-group ">
                <label class="control-label requiredField" for="name">Number of Members <span class="asteriskField">*</span></label>
                <input class="form-control" id="name" name="name" type="text"/></div>
            <div class="form-group ">
                <label class="control-label" for="image">Upload Image</label>
                <input class="form-control" id="img" name="file" accept="image/*" type="file"/>
            </div>
        </form>
        <div class="footer-but-con row justify-content-between">
            <a href='artist.php'><button class='btn btn-link'><b><</b> Back</button></a>
            <?php
            echo " <button class='btn btn-secondary' name='addartist' type='button' onclick='addArtist()' >Add Artist</button>"; ?>
        </div>
    </div>

</div>
    <script type="text/javascript" src="update.js"></script>
<?php include '../includes/footer.php'; ?>
