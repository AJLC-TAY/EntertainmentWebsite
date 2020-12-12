
<link rel="stylesheet" type="text/css" href="../admin/navbennerStyle.css">
<div id='banner' class="container">
    <div class="row">
        <div id='logo'>
            <a href="../admin/index.php" target="_self"><img alt="logo" src="../images/logo site.png"></a>
        </div>
        <div id='header-desc-con'class="col">
            <?php echo "<p class='admin-desc'><span class='admin-header'>Administrative Page</span><br>Today is " . date("l, d F Y ")."<br> You are logged in as <b>".$_SESSION["username"]."</b></p>"?>
        </div>
<!--        <nav class="col">-->
<!--            <ul class="nav-links">-->
<!--                <li><a href="../admin/artist.php" class="link-focus">Artist</a></li>-->
<!--                <li><a href='../admin/albums.php' target='_self'>Album</a></li>-->
<!--            </ul>-->
<!--        </nav>-->

        <div class="logout-con">
            <a href="../admin/logout.php"><button class="btn btn-secondary">Log out</button></a>
        </div>

    </div>
<hr>
</div>
