<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Home | Admin</title>

    <style>
        svg {
            width: 150px;
            height: auto;
            color: #1f1f1f;
        }
        a.col {
            text-decoration: none;
        }

        a div {
            height: 250px;
        }

        .container {
            margin: auto auto;
        }
    </style>
</head>

<body>
    <?php
        echo "<div>" . date("m/d/Y")."</div>" ;
        echo "<div class='container row'>
                    <a class='col-4' href='artists.php' target='_self'>
                       <div class='col rounded border border-secondary' >
                            <p class='text-center text-secondary'><svg viewBox='0 0 16 16' class='bi bi-people-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                    <path fill-rule='evenodd' d='M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z'/></svg>
                                    <br>Artists
                            </p>
                        </div></a>
                    <a class='col-4' href='albums.php' target='_self'>
                        <div class='col rounded border border-secondary'>
                            <p class='text-center text-secondary'><svg viewBox='0 0 16 16' class='bi bi-collection-play-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                    <path fill-rule='evenodd' d='M1.5 14.5A1.5 1.5 0 0 1 0 13V6a1.5 1.5 0 0 1 1.5-1.5h13A1.5 1.5 0 0 1 16 6v7a1.5 1.5 0 0 1-1.5 1.5h-13zm5.265-7.924A.5.5 0 0 0 6 7v5a.5.5 0 0 0 .765.424l4-2.5a.5.5 0 0 0 0-.848l-4-2.5zM2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z'/></svg>
                                    <br>Albums
                            </p>
                        </div></a>
            </div>";
    ?>
</body>
    <?php
        include 'footer.php';
    ?>
</html>


