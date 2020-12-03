<?php include '../includes/head.html'; ?>
    <title>Add Album | Admin</title>
</head>
<body>
<div class='path-links'>
    <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a> / <a href='addAlbum.php?' target='_self'>Add Album</a></pre>
</div>
<div style='width: 70vw'>
    <form id='albumform' method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label requiredField" for="name">Album name <span class="asteriskField">*</span></label>
            <input class="form-control" id="name" name="name" type="text"/>
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
</div>
    <div class="row justify-content-around">
        <a href='albums.php'><button class='btn btn-link'><b><</b> Back</button></a>
      <?php
        $phpPath = "addAlbumDB";
        echo " <button class='btn btn-secondary' name='addalbum' type='button' onclick='addAlbum()' >Add Album</button>"; ?>
    </div>
    <script type="text/javascript" src="update.js"></script>
<link type="text/css" href="style.css">
<?php include '../includes/footer.php'; ?>