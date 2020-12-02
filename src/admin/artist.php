<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Artists | Admin</title>

    <style>
        :root {
            --red: #750000;
            --darkred: #410505;
        }
        #artistlist {
            width: 40vw;
            height: 80vh;
        }
        .artistimage {
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

        $query = 'SELECT artistid, artistname, artistimage, debutyear, membernum FROM artists';
        $stmt = $database->stmt_init();
        $stmt -> prepare($query);
        $stmt -> bind_result($artistid, $artistname, $artistimage, $debutyear, $membernum);
        $stmt -> execute();

        include '../includes/dataclass.php';

        $artists = [];
        while($stmt -> fetch()) {
            $artist = new Artist($artistid, $artistname, $artistimage, $debutyear, $membernum);
            $artist -> set_artistid($artistid);
            $test = $artist->get_artistname();
            $artists[] = $artist;
        }


        echo "<div>
                <a href='addArtist.php' target='_self'><button class='btn btn-secondary'>Add New Artist</button></a>
              </div>";
        echo '<div id="artistlist" class="overflow-auto">';
        echo "<table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col'>Artist ID</th>
                        <th scope='col'>Artist Name</th>
                        <th scope='col'>Artist Image</th>
                        <th scope='col'>Debut Year</th>
                        <th scope='col'>Number of Members</th>
                        <th scope='col'></th>
                    </tr>
                </thead>
                <tbody>";

        foreach ($artists as $art) {
            $artistid = $art->get_artistid();
            $artistname = $art->get_artistname();
            $artistimage = $art->get_artistimage();
            $debutyear = $art->get_debutyear();
            $membernum = $art->get_membernum();

            echo "<tr>
                    <th scope='row'>$artistid</th>
                    <td>
                        <img class='artistimage' src='$artistimage' alt='$artistname image'>
                    </td>
                    <td>$artistname</td>
                    <td>$debutyear</td>
                    <td>$membernum</td>
                    <td><div class='col editdelete-con'>
                        <form action='updateAlbum.php' method='post' target='_self'>
                                <input type='hidden' value='$artistid' name='albumid'>
                                <input type='hidden' value='$artistname' name='albumimage'>
                                <input type='hidden' value='$artistimage' name='albumname'>
                                <input type='hidden' value='$debutyear' name='artistname'>
                                <input type='hidden' value='$membernum' name='releaseddate'>

                                <button id='$artistid' class='btn btn-secondary' type='submit' name='edit'>Edit</button>
                        </form><br>
                        <button value='$artistid' class='btn btn-danger' onclick='getArtist(this.id)' type='button' name='delete'>Delete
                          <!--  <img src='../images/delete_icon.jpg' alt='delete button' title='Delete $artistname' style='width: 15px;height: auto;'> -->
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
