<!DOCTYPE html>
<html lang="en">
  <head>
    <title>McGill Hep-Th Events</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="events.css" >
  </head>
  <body>
  <div class="cheader">
      <div class="header">
        <img src="mcgill_sig_red.jpg" alt="Logo" class="logo" style="text-align:right;">
        <h1>McGill Hep-Th Events</h1>
        <!--  <h1><img src="mcgill_sig_red.jpg" width=200px> My Website</h1><p>A <b>responsive</b> website created by me.</p>-->
      </div>
      <div class="navbar">
        <a href="elist.php" >Hep-Th Seminars</a>
        <a href="ecal.php">Seminars Calendar</a>
        <a href="jclub.php" class="active">Hep-Th Journal Club</a>
        <a href="visinfo.php">Visitor Info</a>
        <a href="mailing.php">Mailing List</a>
        <!--<a href="#" class="right">Link</a>-->
      </div>
  </div>
    <div class="row">
      <!--  <div class="side"><h2>About Me</h2><h5>Photo of me:</h5><div class="fakeimg" style="height:200px;">Image</div><p>Some text about me in culpa qui officia deserunt mollit anim..</p><h3>More Text</h3><p>Lorem ipsum dolor sit ame.</p><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div></div>-->
      <div class="main">
        <h2>Upcoming Journal Club Meetings</h2> <?php
// Database connection
$mysqli = new mysqli("localhost", "my_user","my_password","my_db");


// Query all seminar dates along with speaker names

$speakersResult = $mysqli->query("SELECT * FROM jcevnets ORDER BY date DESC");



?> <?php
if ($speakersResult->num_rows > 0) {
    while ($row = $speakersResult->fetch_assoc()) {
?> <div class="event">
          <div class="event-title"> <strong>Title : </strong><?php
        echo $row['title'];
?> </div>
          <hr>
          <div class="event-info">
            <p><strong> Speaker:</strong> <?php
        echo $row['name'] . " (" . $row['affiliation'] . ")";
?> </p>
            <p><strong>Date:</strong> <?php
        echo $row['date'] . ", " . $srows['time'];
?> </p>
            <p><strong>Location:</strong> <?php
        echo $row['location'];
?> ( <a href="<?php
        echo $row['zlink'];
?>"> <?php
        echo $row['zlink'];
?> </a>) </p>
            <div class="show-abstract" onhover='' onclick="toggleAbstract('abstract<?php
        echo $row['id'];
?>')">Abstract
            <div class="abstract" id="abstract<?php
        echo $row['id'];
?>">
              <div class="abstract-content"> <?php
        echo $row['abstract'];
?> </div>
            </div>
          </div></div>
        </div> <?php
    }
}
?>
       <!--    <h5>Title description, Dec 7, 2017</h5><div class="fakeimg" style="height:200px;">Image</div><p>Some text..</p><p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p><br><h2>TITLE HEADING</h2><h5>Title description, Sep 2, 2017</h5><div class="fakeimg" style="height:200px;">Image</div><p>Some text..</p><p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>-->
      </div>
    </div>
    <div class="footer">
      <h2></h2>
    </div>

<script>
    function toggleAbstract(abstractId) {
        var abstractElement = document.getElementById(abstractId);
        if (abstractElement.style.display === "block") {
            abstractElement.style.display = "none";
        } else {
            abstractElement.style.display = "block";
        }
    }
</script>
  </body>
</html>
