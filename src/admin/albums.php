<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Albums | Admin</title>

    <style>
        :root {
            --red: #750000;
            --darkred: #410505;
        }
        #albumlist {
            width: 40vw;
            height: 80vh;
        }
        .albumimage {
            width: 70px; height: auto;
        }
        .editdelete-con button{
            height: 32px;
            padding-top: 3px;
            width: 70px;
            margin-bottom: 12px;
        }
        button[name="delete"] {
            background-color: var(--red);
            border-color: var(--red);
        }
        button[name="delete"]:hover {
            background-color: var(--darkred);
            border-color: var(--darkred);
        }

        table {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <?php
        include "../includes/database.php";

        echo "<div>" . date("m/d/Y")."</div>" ;

        $query = 'SELECT albumid, albumimg, albumname, artists.artistname, releaseddate FROM albums JOIN artists USING(artistid)';
        $stmt = $database->stmt_init();
        $stmt -> prepare($query);
        $stmt -> bind_result($albumid, $albumimg, $albumname, $artistname, $releaseddate);
        $stmt -> execute();

        include '../includes/dataclass.php';

        $albums = [];
        while($stmt -> fetch()) {
            $album = new Album($albumname, $artistname, $releaseddate, $albumimg);
            $album -> set_albumID($albumid);
            $test = $album->get_albumname();
            $albums[] = $album;
        }

        require "../includes/searchAlbumBar.html";

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
                    <td><div class='col editdelete-con'>
                        <form action='updateAlbum.php' method='post' target='_self'>
                                <input type='hidden' value='$albumid' name='albumid'>
                                <input type='hidden' value='$albumimg' name='albumimage'>
                                <input type='hidden' value='$albumname' name='albumname'>
                                <input type='hidden' value='$artistname' name='artistname'>
                                <input type='hidden' value='$releaseddate' name='releaseddate'>
                               
                                <button id='$albumid' class='btn btn-secondary' type='submit' name='edit'>Edit</button>
                        </form><br>
                        <button value='$albumid' class='btn btn-danger' onclick='getAlbum(this.id)' type='button' name='delete'>Delete
                          <!--  <img src='../images/delete_icon.jpg' alt='delete button' title='Delete $albumname' style='width: 15px;height: auto;'> -->
                        </button>
                        </div>
                    </td>
                  </tr>";
        }

        echo "</tbody></table></div>";

        include '../includes/jqueryAndBootstrap.php';
    ?>
    <script type="text/javascript" src="databaseCon.js"></script>
</body>
<?php
    include '../includes/footer.html';
?>
</html>