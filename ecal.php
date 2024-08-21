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
        <a href="ecal.php" class="active">Seminars Calendar</a>
        <a href="jclub.php">Hep-Th Journal Club</a>
        <a href="visinfo.php">Visitor Info</a>
        <a href="mailing.php">Mailing List</a>
        <!--<a href="#" class="right">Link</a>-->
      </div>
  </div>

    <div class="row">
      <!--  <div class="side"><h2>About Me</h2><h5>Photo of me:</h5><div class="fakeimg" style="height:200px;">Image</div><p>Some text about me in culpa qui officia deserunt mollit anim..</p><h3>More Text</h3><p>Lorem ipsum dolor sit ame.</p><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div><br><div class="fakeimg" style="height:60px;">Image</div></div>-->
      <div class="main">
        <iframe src="some link" style="border:solid 1px #777" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
        <center><br>
        <a href="some link/basic.ics" style="font-size:30px;border: 2px solid;color:#339;border-radius:5px;padding:10px;background:#ccc;" onMouseOver="this.style.color='#fff';this.style.background='#000'" onMouseOut="this.style.color='#339';this.style.background='#ccc'"> Download Calendar In .ics Format</a></center>
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
