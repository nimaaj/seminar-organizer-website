<?php
$conn = new mysqli("localhost", "my_user","my_password","my_db");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mails = $conn->query("SELECT * FROM mailinglist");
$semResult = $conn->query("SELECT * FROM speakers WHERE YEARWEEK(sem_date, 0) = YEARWEEK(CURDATE(), 0)");
$jcResult = $conn->query("SELECT * FROM jcevnets WHERE YEARWEEK(date, 0) = YEARWEEK(CURDATE(), 0)");
$conn->close();

$messagesem = '';
$messagejc = '';
if ($semResult->num_rows > 0) {
    $semrow = $semResult->fetch_assoc();
    $messagesem.=' <strong><span style="color: #000000; font-size: large;">This week\'s Upcoming Seminar info:</span></strong><br />
                <table>
                    <tr><td><strong>Speaker :</strong></td><td>'. $semrow['name'].' from '.$semrow['affiliation'].'</td></tr>
                    <tr><td><strong>Date and Time :&nbsp;&nbsp;</strong></td><td>'. $semrow['sem_date'].' at '.$semrow['sem_time'].'</td></tr>
                    <tr><td><strong>Location:&nbsp;&nbsp;</strong></td><td>'. $semrow['location'].' ('.$semrow['zlink'].')</td></tr>
                    <tr><td><strong>Title :</strong></td><td>'. $semrow['title'].'</td></tr>
                    <tr><td><strong>Abstract :</strong></td><td>'. $semrow['abstract'].'</td></tr>
                </table>
                <br />';
}else{
        $messagesem.=' <strong><span style="color: #000000; font-size: large;">There are no seminars scheduled this week.</span></strong><br />';
}
if ($jcResult->num_rows > 0) {
    $jcrow = $jcResult->fetch_assoc();
    $messagejc .= '<strong><span style="color: #000000; font-size: large;">This week\'s Upcoming Journal Club info:</span></strong><br />
                <table>
                    <tr><td><strong>Speaker :</strong></td><td>'. $jcrow['name'].' from '.$jcrow['affiliation'].'</td></tr>
                    <tr><td><strong>Date and Time :</strong></td><td>'. $jcrow['date'].' at '.$jcrow['time'].'</td></tr>
                    <tr><td><strong>Location:</strong></td><td>'. $jcrow['location'].' (<a href=\"'.$jcrow['zlink'].'\"> '.$jcrow['zlink'].' </a>)</td></tr>
                    <tr><td><strong>Title :</strong></td><td>'. $jcrow['title'].'</td></tr>
                    <tr><td><strong>Abstract :</strong></td><td>'. $jcrow['abstract'].'</td></tr>
                </table>';
}else{
    $messagejc .= '<strong><span style="color: #000000; font-size: large;">There are no journal club meetings scheduled this week.</span></strong><br />';
}

        while ($row = $mails->fetch_assoc()):
            $to = $row['email']; // The recipient's email address
            $subject = 'Weekly McGill Hep-Th Events'; // The subject of the email
            $headers = 'From: test@test.com' . "\r\n" .//(****Fill****)
            'Reply-To: test@test.com' . "\r\n" .//(****Fill****)
            'X-Mailer: PHP/' . phpversion()."MIME-Version: 1.0\r\n".
            "Content-Type: text/html; charset=UTF-8\r\n";
            $message='';
            $message ='<p>Hi '. $row['name'].',<br>'.$message."<br>";
            if ($row['semw']==1){$message.=$messagesem;}
            if ($row['jcw']==1){$message.=$messagejc;}
            $message .= '
                        <div>
                            <span style="color: #000000; font-size: small;">
                                <strong>Please note:</strong>&nbsp;This is an automated message. Please do not reply to this message. Follow&nbsp;<a href="some link" target="_blank" rel="noopener">this link&nbsp;</a>to modify your
                                mailing list options or to remove this email from the list.
                            </span>
                        </div>'; // The message body
            if ($row['semw']==1||$row['jcw']==1){
                mail($to, $subject, $message, $headers);
            }
        endwhile;
        ?>

