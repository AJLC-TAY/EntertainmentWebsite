<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Artists | Admin</title>
    <style type="text/css">
        <?php include 'style.css'; ?>
    </style>
  </head>

  <body>
    <?php include '../includes/navbanner.php' ?>
    <?php include '../includes/database.php'?>

    <div class="artist-list-con container">
        <div class='path-links'>
            <pre><a href='index.php' target='_self'>Admin Home</a> / <a href='artist.php' target='_self'><b>Artists</b></a></pre>
        </div>
        <div class="artist-list-header row justify-content-between"><h4>Artist List</h4><a href='addArtist.php' target='_self'><button class='btn btn-next'>Add New Artist</button></a>
            </div>
        <div id="artistlist" class="overflow-auto">
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
                require 'require/getArtist.php';
                foreach ($artists as $art) {
                    $artistid = $art->get_artistid();
                    $artistimage = $art->get_artistimage();
                    $artistname = $art->get_artistname();
                    $nickname = $art->get_nickname();
                    $debutyear = $art->get_debutyear();
                    $membernum = $art->get_membernum();

                    echo "<tr id='{$artistid}row'>
                            <th scope='row'>$artistid</th>
                            <td>
                                <img class='artistimage' src='$artistimage' alt='$artistname image'>
                            </td>
                            <td>$artistname</td>
                            <td>$nickname</td>
                            <td>$debutyear</td>
                            <td>$membernum</td>
                            <td><div class='row editdelete-con'>
                                <form id='artistform' method='post' >
                                    <input name='artistid' value='$artistid' hidden>
                                     <button class='btn btn-danger' onclick='deleteArtistFromTable($artistid)' type='button' name='delete'>
                                        <img src='../images/delete.png' title='Delete alrtist'>
                                     </button>
                                </form>
                                <a href='updateArtist.php?id=$artistid'><button id='$artistid' class='btn btn-secondary' name='edit'>
                                    <img src='../images/edit.png' title='Edit artist'>
                                </button>
                                </a> <br>
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
