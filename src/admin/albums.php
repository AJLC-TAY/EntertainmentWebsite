<?php include '../includes/head.html'; ?>
    <title>Albums | Admin</title>
    <style>
        :root {
            --red: #750000;
            --darkred: #410505;
            --darkwhite: #b5b5b5;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
        }
        #albumlist {
            width: 60vw;
            height: 80vh;
            overflow: scroll;
        }
        .albumimage {
            width: 70px; height: auto;
        }
        .editdelete-con button{
            height: 32px;
            padding-top: 3px;
            width: 70px;
            margin:6px 6px;
            border-radius: 5px;
        }
        button[name="delete"] {
            background-color: var(--red);
            border-color: var(--red);
            color: white;
        }
        button[name="delete"]:hover {
            background-color: var(--darkred);
            border-color: var(--darkred);
        }

        button[name="edit"] {
            border-color: transparent;
        }
        button[name="edit"]:hover {
            box-shadow: 0 1px 2px gray;
        }

        table {
            font-size: 14px;
        }
    </style>
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
    <script type="text/javascript" src="databaseCon.js"></script>
</body>
<?php
    include '../includes/footer.php';
?>
</html>