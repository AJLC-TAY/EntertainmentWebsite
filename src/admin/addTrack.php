<?php
    echo ' <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" 
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';


    $albumid = '';
    echo "<div id='trackForm' style='float: left; width: 40vw'>";
    echo '<form method="post" enctype="multipart/form-data">';
    echo '<div class="form-group ">
                  <label class="control-label requiredField" for="trackname">Track name <span class="asteriskField">*</span></label>
                  <input class="form-control" id="trackname" name="trackname" type="text"/>
             </div>';
    echo '<div class="form-group ">
              <label class="control-label" for="image">Upload Music File</label>
              <input class="form-control" id="music" name="file" accept="audio/*" type="file"/>
          </div>';
    echo "<button class='btn btn-secondary' onclick='addTrack($albumid)' name='addalbum' type='submit'>Add Track</button>";
    echo "</form></div>";
    echo "<div id='tracklist' class=''></div>";
    include "../includes/jqueryAndBootstrap.php";
