<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
    <title>Albums | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <?php include '../includes/navbanner.php' ?>

    <div class="album-list-con container">
        <div class='path-links'>
            <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='albums.php' target='_self'><b>Albums</b></a></pre>
        </div>
        <div class="album-list-header row justify-content-between"><h4>Album List</h4><a href='addAlbum.php' target='_self'><button class='btn btn-dark'>Add New Album</button></a>
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
                                 <a href='deleteAlbum.php?id=$albumid' onclick='javascript:return confirm(`Are you sure you want to delete this album?`)' class='btn btn-danger small-del' type='submit'>
                                    <img src='../images/delete.png' title='Delete album'>
                                 </a>
                                <a href='updateAlbum.php?id=$albumid'>
                                    <button id='$albumid' class='btn btn-secondary' name='edit'>
                                        <img src='../images/edit.png' title='Edit album'>
                                    </button>
                                </a> <br>
                                <a href='viewTracks.php?id=$albumid'>
                                    <button id='$albumid' class='btn btn-white' name='view'>
                                        <img src='../images/viewicon.png' title='View tracks'>
                                    </button>
                                </a>                               
                                </div>
                            </td>
                          </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="row footer-but-con justify-content-between"><a href='index.php'><button class='btn btn-link'><b><</b> Home</button></a>
        </div>
    </div>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="update.js"></script>
<?php
    include '../includes/footer.php';
?>
