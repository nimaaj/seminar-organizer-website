<?php
$conn = new mysqli("localhost", "my_user","my_password","my_db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mails = $conn->query("SELECT * FROM mailinglist WHERE semm = 1");
$semResult = $conn->query("SELECT * FROM speakers WHERE sem_date = CURDATE()");
$conn->close();

$messagesem = '';
if ($semResult->num_rows > 0) {
    $semrow = $semResult->fetch_assoc();
    $messagesem.='
                <strong><span style="color: #000000; font-size: large;">Today\'s Upcoming Seminar Info:</span></strong><br />
                <table>
                    <tr><td><strong>Speaker :</strong></td><td>'. $semrow['name'].' from '.$semrow['affiliation'].'</td></tr>
                    <tr><td><strong>Date and Time :&nbsp;&nbsp;</strong></td><td>'. $semrow['sem_date'].' at '.$semrow['sem_time'].'</td></tr>
                    <tr><td><strong>Location:&nbsp;&nbsp;</strong></td><td>'. $semrow['location'].' ('.$semrow['zlink'].')</td></tr>
                    <tr><td><strong>Title :</strong></td><td>'. $semrow['title'].'</td></tr>
                    <tr><td><strong>Abstract :</strong></td><td>'. $semrow['abstract'].'</td></tr>
                </table>
                <br />';
    while ($row = $mails->fetch_assoc()):
        $to = $row['email']; // The recipient's email address
        $subject = 'Today\'s McGill Hep-Th Seminar'; // The subject of the email
        $headers = 'From: test@test.com' . "\r\n" .//(****Fill****)
        'Reply-To: test@test.com' . "\r\n" .//(****Fill****)
        'X-Mailer: PHP/' . phpversion()."MIME-Version: 1.0\r\n".
        "Content-Type: text/html; charset=UTF-8\r\n";
        $message='';
        $message ='<p>Hi '. $row['name'].',<br>'.$message."<br>";
        $message.=$messagesem;
        $message .= '
            <div>
                <span style="color: #000000; font-size: small;">
                    <strong>Please note:</strong>&nbsp;This is an automated message. Please do not reply to this message. Follow&nbsp;<a href="some link" target="_blank" rel="noopener">this link&nbsp;</a>to modify your mailing list options or to remove this email from the list.
                </span>
            </div>'; // The message body
        echo $message;
        echo "<hr>";
        mail($to, $subject, $message, $headers);

    endwhile;
}
?>
