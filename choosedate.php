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
}
function stringToIntArray($str) {
    $strArray = explode(',', $str); // Split the string at each comma
    $intArray = array_map('intval', $strArray); // Convert each element to an integer
    return $intArray;
}
//$rdates= stringToIntArray();
// Check if the speaker has already chosen a date
$chosenDateQuery = "SELECT date FROM seminar_dates WHERE speaker_id = ?";
$chosenDateStmt = $mysqli->prepare($chosenDateQuery);
$chosenDateStmt->bind_param("i", $speaker['id']);
$chosenDateStmt->execute();
$chosenDateResult = $chosenDateStmt->get_result();
$chosenDate = $chosenDateResult->fetch_assoc();

if ($chosenDate) {
    echo "You have already chosen a date: " . $chosenDate['date'];
    exit;
}


$datesQuery = "SELECT * FROM seminar_dates ORDER BY seminar_dates.date";
$datesResult = $mysqli->query($datesQuery);

if ($datesResult->num_rows === 0) {
    echo "No available dates.";
    exit;
}



//while ($row = $datesResult->fetch_assoc()) {    printf("%s,  %s <br>\n", $row['id'],$row['date']);}



// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chosenDateId = $_POST['chosen_date'];
    
    // Update the chosen date with the speaker's ID
    $updateQuery = "UPDATE seminar_dates SET speaker_id = ? WHERE id = ? AND speaker_id IS NULL";
    $updateStmt = $mysqli->prepare($updateQuery);
    $updateStmt->bind_param("ii", $speaker['id'], $chosenDateId);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Date chosen successfully!";
        $to = ''; // The recipient's email address (****Fill****)
        $subject = 'Seminar speaker confirmed a date'; // The subject of the email
        $message = 'This email is to confirm that '. $sname ." selected a date for their seminar.\n Visit ***some link*** for more info. \n This is an automated message."; // The message body
        $headers = 'From: test@test.com' . "\r\n" .//(****Fill****)
        'Reply-To: test@test.com' . "\r\n" .//(****Fill****)
        'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
        exit;
    } else {
        echo "The selected date is no longer available. Please choose another date.";
   }
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Choose a Seminar Date</title>
</head>
<body>
<img src="mcgill_sig_red.jpg"  style="width:332px;height:108px;align:left">
    <h1><?php printf("Choose a Seminar Date for %s", $sname); ?></h1>



     <form action="" method="post">
        <label for="chosen_date">Available Dates:</label>
        <div class="radio-container">
            <?php 
            $x = 1;
            while ($row = $datesResult->fetch_assoc()):

            if (!in_array($x,stringToIntArray($speaker['rmdates'])) and is_null($row['speaker_id']) ) {               
            echo(" <label class=\"radio-label\">\n");
            printf("<input type=\"radio\" name=\"chosen_date\" id=\"chosen_date\" value=\"%s\" class=\"radio-input\">\n", $row['id']);
            printf("<span class=\"radio-text\">%s</span>\n", $row['date']);
            echo("</label>\n");
            }
            $x++;
           endwhile; 
           ?>
        </div>
        <button type="submit" style="height:50px; width:100%; font-size: 20px;  color: white; background: #691004;border: 2px solid rgb(37, 34, 34);border-radius: 10px;">Submit</button>
    </form>
</body>
</html>
