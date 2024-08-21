<?php
$conn = new mysqli("localhost", "my_user","my_password","my_db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$msg="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $email = $_POST["email"];
        $name  = $_POST["name"];
        $semw = isset($_POST["semw"]) ? 1 : 0;
        $semm = isset($_POST["semm"]) ? 1 : 0;
        $jcw = isset($_POST["jcw"]) ? 1 : 0;
        $jcm = isset($_POST["jcm"]) ? 1 : 0;
        $sql = "DELETE FROM mailinglist WHERE email = '$email'";
        $conn->query($sql);
        $sql = "INSERT INTO mailinglist (name, email, semw,semm,jcw,jcm ) VALUES ('$name','$email', '$semw', '$semm', '$jcw', '$jcm')";
        if ($conn->query($sql) === TRUE) {
            $msg= "Email added successfully.";
        } else {
            $msg= "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $email = $_POST["email"];
        $sql = "DELETE FROM mailinglist WHERE email = '$email'";
        if ($conn->query($sql) === TRUE) {
            $msg="Email removed successfully.";
        } else {
            $msg= "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
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
        <a href="elist.php">Hep-Th Seminars</a>
        <a href="ecal.php">Seminars Calendar</a>
        <a href="jclub.php">Hep-Th Journal Club</a>
        <a href="visinfo.php">Visitor Info</a>
        <a href="mailing.php" class="acive">Mailing List</a>
        <!--<a href="#" class="right">Link</a>-->
      </div>
  </div>
    <div class="row">
      <div class="main">
        <!--<form method="post" action="">
            <label for="name">Name:</label>
            <input type="name" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>


            <label for="semw">Seminar Weekly Reminder:</label>
            <input type="checkbox" id="semw" name="semw">

            <label for="semm">Seminar Morning Reminder:</label>
            <input type="checkbox" id="semm" name="semm">

            <label for="jcw">Journal Club Weekly Reminder:</label>
            <input type="checkbox" id="jcw" name="jcw">

            <label for="jcm">Journal Club Morning reminder:</label>
            <input type="checkbox" id="jcm" name="jcm">

            <input type="hidden" name="action" value="add">
            <button type="submit">Add to Mailing List</button>
        </form>
        <hr>
        <form method="post" action="">
            <label for="email_remove">Email to remove:</label>
            <input type="email" id="email_remove" name="email" required>

            <input type="hidden" name="action" value="remove">
            <button type="submit">Remove from Mailing List</button>
        </form>-->
<?php
if ($msg!="") {echo $msg;}else{?>

            <div class="wrapper">
            <h1>Mailing List Options</h1>
            <div class="grid">
                <form method="post" action="">
                    <fieldset>
                        <!--<legend>Choose your delivery preference</legend>-->
                        <legend>Choose Reminders</legend>
                        <div class="form__group">
                            <label for="name">Name:</label>
                            <input type="name" id="name" name="name">
                        </div>
                        <div class="form__group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                         </div>
                        <div class="form__group">
                            <input type="checkbox" id="semw"  name="semw">
                            <label for="semw">Seminar Weekly</label>
                        </div>
                        <div class="form__group">
                            <input type="checkbox" id="semm"  name="semm">
                            <label for="semw">Seminar Morning</label>
                        </div>
                        <div class="form__group">
                            <input type="checkbox" id="jcw"  name="jcw">
                            <label for="semw">Journal Club Weekly</label>
                        </div>
                        <div class="form__group">
                            <input type="checkbox" id="jcm"  name="jcm">
                            <label for="semw">Journal Morning</label>
                        </div>
                        <div class="form__group">
                        <input type="submit" name="add" value="Add to / update Mailing List">
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="grid">
                <form method="post" action="">
                    <fieldset>
                        <!--<legend>Choose your delivery preference</legend>-->
                        <legend>Unsubscribe</legend>
                        <div class="form__group">
                            <label for="email_remove">Email to remove:</label>
                            <input type="email" id="email_remove" name="email" required>
                       </div>
                        <div class="form__group">
                        <input type="submit" name="delete" value="Remove From Mailing List">
                        </div
                    </fieldset>
                </form>
            </div>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="footer">
      <h2></h2>
    </div>

  </body>
</html>


