<?php

// Database connection
$mysqli = new mysqli("localhost", "my_user","my_password","my_db");

// Get the token from the URL
$token = $_GET['token'];
// Check if both tk1 and tk2 are assigned

// Query the speaker using the token
$speakerQuery = "SELECT * FROM speakers WHERE unique_url = ?";
$stmt = $mysqli->prepare($speakerQuery);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$speaker = $result->fetch_assoc();

if (!$speaker) {
    echo "Invalid token!";
    exit;
} else{
    $sname=$speaker['name'];
    $speaker_id=$speaker['id'];
    $title = $speaker["title"];
    $abstract = $speaker["abstract"];
    $vsdate= $speaker["sem_date"];
    $vstime = $speaker["sem_time"];
    $vloc = $speaker["location"];
    $vzlink= $speaker["zlink"];
    $vaffil= $speaker["affiliation"];

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update database with new values
    $newTitle = $_POST["title"];
    $newAbstract = $_POST["abstract"];

    $updateSql = "UPDATE speakers SET title = ?, abstract = ? WHERE id = ?";
    $stmt = $mysqli->prepare($updateSql);
    $stmt->bind_param("ssi", $newTitle, $newAbstract,$speaker_id);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo '  <html>
                <head>
                    <meta http-equiv="refresh" content="5;url=some url/visinfo.php" />
                </head>
                <body>
                    <h1>Title and Abstract updated successfully! Redirecting...</h1>
                </body>
                </html>';
        $to = ''; // The recipient's email address (****Fill****)
        $subject = 'Seminar speaker update'; // The subject of the email
        $message = "This email is to confirm that <b>". $sname ."(".$vaffil.") </b>has submitted the title and abstract for their seminar. Visit somelink for more info.<br> Details are as follows:<br><hr> Speaker : <b>".$sname."</b><br>".
        "Affiliation : <b>".$vaffil."</b><br>".
        "Date : <b>".$vsdate."</b><br>".
        "Time : <b>".$vstime."</b><br>".
        "Location : <b>".$vloc."</b><br>".
        "Zoom : <b>".$vzlink."</b><br>".
        "Title : <b>".$newTitle."</b><br>".
        "Abstract : <b>".$newAbstract."</b><hr>".
        " <br> <small>This is an automated message.</small>";// The message body
        $headers = 'From: test@test.com' . "\r\n" . //(****Fill****)
        'Reply-To: test@test.com' . "\r\n" . //(****Fill****)
        'X-Mailer: PHP/' . phpversion()."MIME-Version: 1.0\r\n".
        "Content-Type: text/html; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);
        exit;
    } else {
        echo "No changes were made or there was an error. Please try again or contact your host to resolve the issue.";
   }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 40px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        .header-small {
            height:20px;
        }
    </style>
</head>
<body>
<div style="background-color: #fff;width: 100%">
    <img src="mcgill_sig_red.jpg"  style="width:332px;height:108px;">
</div>
<!-- <div style="background-image: url(rutherford+physics.jpg);height:133px;width:940px;margin-left: auto;  margin-right: auto;">
     <h2 style="color:#fff;text-align:right;"><br>Department of Physics&nbsp&nbsp&nbsp&nbsp</h2>
</div> -->

<div class="container">
<h1><?php printf("Seminar Details For %s", $sname); ?></h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
            </div>
            <div class="form-group">
                <label for="abstract">Abstract:</label>
                <textarea id="abstract" name="abstract" rows="8"><?php echo htmlspecialchars($abstract); ?></textarea>
            </div>
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
</body>
</html>
