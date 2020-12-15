<?php
/**
 * The home page showing clickable buttons that redirects the admin to
 * view artists and albums.
 *
 * @author Alvin John Cutay
 */
include ("../includes/sessionHandling.php");
include ('../includes/head.html'); ?>
    <title>Home | Admin</title>

    <style type="text/css">
       <?php include 'style.css'?>
    </style>
</head>

<body class="home">
    <?php include '../includes/navbanner.php' ?>
    <div class="home-con container">
        <div class='path-links'>
            <pre><a href='index.php' target='_self'>Admin Home</a></pre>
        </div>
    </div>
    <div class='menu-con container row'>

        <a class='col-4 menu-item' href='artist.php' target='_self'>
           <div id="artist" class='col rounded border border-secondary' >
                <p class='text-center text-secondary'><svg viewBox='0 0 16 16' class='bi bi-people-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                        <path fill-rule='evenodd' d='M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z'/></svg>
                        <br>Artists
                </p>
            </div>
        </a>
        <a class='col-4 menu-item' href='albums.php' target='_self'>
            <div class='col rounded border border-secondary'>
                <p class='text-center text-secondary'> <svg viewBox="0 0 16 16" class="bi bi-collection-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7z"/>
                        <path fill-rule="evenodd" d="M2 3a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 0-1h-11A.5.5 0 0 0 2 3zm2-2a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7A.5.5 0 0 0 4 1z"/>
                    </svg><br>Albums
                </p>
            </div>
        </a>
    </div>
<?php include '../includes/footer.php'; ?>

