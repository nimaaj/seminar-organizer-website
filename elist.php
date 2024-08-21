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
        <h1 style="text-align:center;">McGill Hep-Th Events</h1>
        <!--  <h1><img src="mcgill_sig_red.jpg" width=200px> My Website</h1><p>A <b>responsive</b> website created by me.</p>-->
      </div>
      <div class="navbar">
        <a href="elist.php" class="active">Hep-Th Seminars</a>
        <a href="ecal.php">Seminars Calendar</a>
        <a href="jclub.php">Hep-Th Journal Club</a>
        <a href="visinfo.php">Visitor Info</a>
        <a href="mailing.php">Mailing List</a>
        <!--<a href="#" class="right">Link</a>-->
      </div>
  </div>
    <div class="row">
      <!--  <div class="side"><h2>About Me</h2><h5>Photo of me:</h5><div class="fakeimg" style="height:200px;">Image</div><p>Some text about me in culpa qui officia deserunt mollit anim..</p><h3>More Text</h3><p>Lorem ipsum dolor sit ame.</p><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div></div>-->
      <div class="main">
        <h2>Upcoming Seminars</h2> <?php
               // Database connection
               $mysqli = new mysqli("localhost", "my_user","my_password","my_db");


               // Query all seminar dates along with speaker names
               $datesResult = $mysqli->query("SELECT seminar_dates.id, seminar_dates.date, speakers.name AS speaker_name, speakers.id AS speaker_id FROM seminar_dates LEFT JOIN speakers ON seminar_dates.speaker_id = speakers.id ORDER BY seminar_dates.date");
               // Query all speakers for the dropdown
               $speakersResult2 = $mysqli->query("SELECT id, name FROM speakers");
               $speakersResult = $mysqli->query("SELECT * FROM speakers");

               $sql = "SELECT * FROM seminar_dates WHERE speaker_id IS NOT NULL ORDER BY seminar_dates.date";
               $result = $mysqli->query($sql);
               if ($result->num_rows > 0) {
                   while ($row = $result->fetch_assoc()) {
                       $stmt = $mysqli->prepare("SELECT * FROM speakers WHERE id = ?");
                       $stmt->bind_param("i", $row["speaker_id"]);  // "i" indicates the variable type is integer
                       $stmt->execute();

                       $sresult = $stmt->get_result();
                       $srows = $sresult->fetch_assoc();
                       ?>
        <div class="event" onclick="toggleAbstract('abstract<?php echo $srows['id']; ?>')">
          <div class="event-title"> <strong>Title : </strong><?php echo $srows['title']; ?> </div>
          <hr>
          <div class="event-info">
            <p><strong> Speaker:</strong> <?php echo $srows['name']." (".$srows['affiliation'].")"; ?> </p>
            <p><strong>Date:</strong> <?php echo $row['date'].", ".$srows['sem_time']; ?> </p>
            <p><strong>Location:</strong> <?php echo $srows['location']; ?> ( <a href="<?php echo $srows['zlink']; ?>"> <?php echo $srows['zlink']; ?> </a>) </p>
            <div class="show-abstract" onhover='' onclick="toggleAbstract('abstract<?php echo $srows['id']; ?>')">Abstract
            <div class="abstract" id="abstract<?php echo $srows['id']; ?>">
              <div class="abstract-content"> <?php echo $srows['abstract']; ?> </div>
            </div>
          </div></div>
        </div>
        <?php
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
