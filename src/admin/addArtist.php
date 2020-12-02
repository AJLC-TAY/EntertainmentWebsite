<? include '../includes/head.html'?>
    <title>Add Artist | Admin</title>
</head>
<body>
<?php
    include '../includes/database.php';
    include '../includes/bootstrapDatepicker.php';

    // back link
    echo "<div><a href='artist.php'><button class='btn btn-link'>< Back</button></a></div>";

    echo '<form action="" enctype="multipart/form-data" method="post">
                <label for="name">Album Name</label>
                <input type="text" name="albumname" required><br>
                <div class="form-group">
                     <label for="artistname">Artist Name</label>
                      <select class="form-control" id="artistname" required>
                      <option id="0"></option>';

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
        echo '</select>
                </div>
                <label for="date">Date Released</label>
                    <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                 <label for="image">Image</label>
                <input type="file" id="img" name="file" accept="image/*" required>
                <center><button class="btn btn-secondary">Add</button></center>
              </form>';
