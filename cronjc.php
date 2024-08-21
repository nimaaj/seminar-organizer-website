<?php
$conn = new mysqli("localhost", "my_user","my_password","my_db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mails = $conn->query("SELECT * FROM mailinglist WHERE jcm = 1");
$jcResult = $conn->query("SELECT * FROM jcevnets WHERE date = CURDATE()");
$conn->close();

$messagejc = '';

if ($jcResult->num_rows > 0) {
    $jcrow = $jcResult->fetch_assoc();
    $messagejc .= '<strong><span style="color: #000000; font-size: large;">Today\'s Journal Club Info:</span></strong><br />
                <table>
                    <tr><td><strong>Speaker :</strong></td><td>'. $jcrow['name'].' from '.$jcrow['affiliation'].'</td></tr>
                    <tr><td><strong>Date and Time :</strong></td><td>'. $jcrow['date'].' at '.$jcrow['time'].'</td></tr>
                    <tr><td><strong>Location:</strong></td><td>'. $jcrow['location'].' (<a href=\"'.$jcrow['zlink'].'\"> '.$jcrow['zlink'].' </a>)</td></tr>
                    <tr><td><strong>Title :</strong></td><td>'. $jcrow['title'].'</td></tr>
                    <tr><td><strong>Abstract :</strong></td><td>'. $jcrow['abstract'].'</td></tr>
                </table>';
    while ($row = $mails->fetch_assoc()):
        $to = $row['email']; // The recipient's email address
        $subject = 'Today\'s McGill Hep-Th Journal Club'; // The subject of the email
        $headers = 'From: test@test.com' . "\r\n" . //(****Fill****)
        'Reply-To: test@test.com' . "\r\n" .//(****Fill****)
        'X-Mailer: PHP/' . phpversion()."MIME-Version: 1.0\r\n".
        "Content-Type: text/html; charset=UTF-8\r\n";
        $message='';
        $message ='<p>Hi '. $row['name'].',<br>'.$message."<br>";
        $message.=$messagejc;
        $message .= '
                    <div>
                        <span style="color: #000000; font-size: small;">
                            <strong>Please note:</strong>&nbsp;This is an automated message. Please do not reply to this message. Follow&nbsp;<a href="somelink" target="_blank" rel="noopener">this link&nbsp;</a>to modify your
                            mailing list options or to remove this email from the list.
                        </span>
                    </div>'; // The message body
            mail($to, $subject, $message, $headers);
    endwhile;
}
?>
