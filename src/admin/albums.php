<?php include '../includes/head.html'; ?>
    <title>Albums | Admin</title>
</head>

<body>
    <div class='path-links'>
        <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'>Albums</a></pre>
    </div>
    <?php
        echo "<div>" . date("m/d/Y")."</div>" ;
        require "../includes/searchAlbumBar.html";
    ?>
    <div>

    </div>

        <div id="albumlist" class="overflow-auto">
            <table id="albumtable" class='table'>
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
                    <tbody>
                <?php
                require 'require/getAlbums.php';
                foreach ($albums as $alb) {
                    $albumid = $alb->get_albumid();
                    $albumimg = $alb->get_albumimg();
                    $albumname = $alb->get_albumname();
                    $artistname = $alb->get_artistname();
                    $releaseddate = $alb->get_releaseddate();

                    echo "<tr id='{$albumid}row'>
                            <th scope='row'>$albumid</th>
                            <td>
                                <img class='albumimage' src='$albumimg' alt='$albumname image'>
                            </td>
                            <td>$albumname</td>
                            <td>$artistname</td>
                            <td>$releaseddate</td>
                            <td><div class='row editdelete-con'>
                                <form id='albumform' method='post' >
                                    <input name='albumid' value='$albumid' hidden>
                                     <button class='btn btn-danger' onclick='deleteAlbumFromTable($albumid)' type='button' name='delete'>Delete</button>
                                </form>
                 
                                <a href='updateAlbum.php?id=$albumid'><button id='$albumid' class='btn btn-secondary' name='edit'>Edit</button>
                                </a> <br>
                                
                                </div>
                            </td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row justify-content-between"><a href='index.php'><button class='btn btn-link'><b><</b> Back</button></a>
            <div>
                <a href='addAlbum.php' target='_self'><button class='btn btn-secondary'>Add New Album</button></a>
            </div></div>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="update.js"></script>
<?php
    include '../includes/footer.php';
?>
