<?php
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
    <title>Artists | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
  </head>

  <body>
    <!--Contains the logo, the title of the page, the date today, and the log out button-->
    <?php include '../includes/navbanner.php' ?>
    <!--Contains the -->
    <?php include '../includes/database.php'?>

    <div class="artist-list-con container">
        <div class='path-links'>
            <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'><b>Artists</b></a></pre>
        </div>
        <div class="artist-list-header row justify-content-between"><h4>Artist List</h4><a href='addArtist.php' target='_self'><button class='btn btn-dark'>Add New Artist</button></a>
            </div>


        <div id="artistlist" class="overflow-auto">
            <!--A table that displays the information from the artist table in the database-->
            <table id="artisttable" class='table'>
                    <thead class='thead-dark'>
                        <tr>
                          <th scope='col'>Artist ID</th>
                          <th scope='col'>Artist Image</th>
                          <th scope='col'>Artist Name</th>
                          <th scope='col'>Nickname</th>
                          <th scope='col'>Debut Year</th>
                          <th scope='col'>Number of Members</th>
                          <th scope='col'></th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                // Fetches the information 
                require 'require/getArtist.php';
                foreach ($artists as $art) {
                    $artistid = $art->get_artistid();
                    $filepath = $art->get_artistimage();
                    $artistname = $art->get_artistname();
                    $nickname = $art->get_nickname();
                    $debutyear = $art->get_debutyear();
                    $membernum = $art->get_membernum();

                    echo "<tr id='{$artistid}row'>
                            <th scope='row'>$artistid</th>
                            <td>
                                <img class='artistimage' src='$filepath' alt='$artistname image'>
                            </td>
                            <td>$artistname</td>
                            <td>$nickname</td>
                            <td>$debutyear</td>
                            <td>$membernum</td>
                            <td><div class='row editdelete-con'>
                                <a href='deleteArtist.php?id=$artistid' onclick='javascript:return confirm(`Are you sure you want to delete this artist?`)' class='btn btn-danger small-del' type='submit'>
                                  <img src='../images/delete.png' title='Delete album'>
                                </a>

                                <a href='updateArtist.php?id=$artistid'><button id='$artistid' class='btn btn-secondary' name='edit'>
                                    <img src='../images/edit.png' title='Edit artist'>
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
        <div class="row footer-but-con justify-content-between"><a href='index.php'><button class='btn btn-link'><b><</b> Back</button></a>
        </div>
    </div>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="update.js"></script>
  </body>
    <?php
    include '../includes/footer.php';
    ?>
</html>
