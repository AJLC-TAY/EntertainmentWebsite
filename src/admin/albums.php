<?php include '../includes/head.html'; ?>
    <title>Albums | Admin</title>
</head>

<body>
    <?php
        echo "<div class='path-links'>
                <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a></pre>
        </div>";
        echo "<div>" . date("m/d/Y")."</div>" ;
        require "../includes/searchAlbumBar.html";
        require 'require/getAlbums.php';
        echo "<div>
                <a href='addAlbum.php' target='_self'><button class='btn btn-secondary'>Add New Album</button></a>
              </div>";
        echo '<div id="albumlist" class="overflow-auto">';
        echo "<table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>Album ID</th>
                        <th scope='col'>Album Image</th>
                        <th scope='col'>Album Name</th>
                        <th scope='col'>Artist Name</th>
                        <th scope='col'>Date Released</th>
                        <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($albums as $alb) {
            $albumid = $alb->get_albumid();
            $albumimg = $alb->get_albumimg();
            $albumname = $alb->get_albumname();
            $artistname = $alb->get_artistname();
            $releaseddate = $alb->get_releaseddate();

            echo "<tr>
                    <th scope='row'>$albumid</th>
                    <td>
                        <img class='albumimage' src='$albumimg' alt='$albumname image'>
                    </td>
                    <td>$albumname</td>
                    <td>$artistname</td>
                    <td>$releaseddate</td>
                    <td><div class='row editdelete-con'>
                        <a href='updateAlbum.php?id=$albumid'><button id='$albumid' class='btn btn-secondary' name='edit'>Edit</button>
                        </a> <br>
                        <a href='deleteAlbum.php?id=$albumid'><button value='$albumid' class='btn btn-danger' type='button' name='delete'>Delete
                        </button></a>
                        </div>
                    </td>
                  </tr>";
        }

        echo "</tbody></table></div>";
        // back link
        echo "<div><a href='index.php'><button class='btn btn-link'><b><</b> Back</button></a></div>";
    ?>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="databaseCon.js"></script>
</body>
<?php
    include '../includes/footer.php';
?>
</html>