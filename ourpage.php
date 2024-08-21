<?php
// Database connection
$mysqli = new mysqli("localhost", "my_user","my_password","my_db");
        //////////////////////////////////////////////////
        // synchronize dates
        //////////////////////////////////////////////////
        // Execute the query
        $syncresult = $mysqli->query("SELECT * FROM seminar_dates WHERE speaker_id IS NOT NULL");

        // Check if the query returned any results
        if ($syncresult->num_rows > 0) {
            // Output the rows
            while($row = $syncresult->fetch_assoc()) {
                $stmt4 = $mysqli->prepare("UPDATE speakers SET sem_date = ? WHERE id = ?");
                $stmt4->bind_param("si", $row["date"] ,  $row["speaker_id"]);
                $stmt4->execute();
                $stmt4->close();
            }
        }


        echo "database synchronized successfully with";
        echo $syncresult->num_rows;
        echo "rows.";

function stringToIntArray($str) {
    if (!preg_match('/^(\d+(,\d+)*)?$/', $str)) {
        throw new InvalidArgumentException('Input string should only contain comma-separated integers.');
    }

    if ($str === '') {
        return [];
    }

    $strArray = explode(',', $str); // Split the string at each comma
    $intArray = array_map('intval', $strArray); // Convert each element to an integer
    return $intArray;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $date = $_POST['date'];
        $stmt = $mysqli->prepare("INSERT INTO seminar_dates (date) VALUES (?)");
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $message = "Date added successfully!";
    }  elseif (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $speaker_id = $_POST['speaker_id'] ?: NULL;

        $stmt = $mysqli->prepare("UPDATE seminar_dates SET date = ?, speaker_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $date, $speaker_id, $id);
        $stmt->execute();
        $message = "Date updated successfully!";
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $mysqli->prepare("DELETE FROM seminar_dates WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $message = "Date deleted successfully!";
    } elseif (isset($_POST['adds'])) {
        $name = $_POST['name'];
        $hostname = $_POST['hostname'];
        $affiliation = $_POST['affiliation'];
        $rmdates = $_POST['rmdates'];
        $token = bin2hex(random_bytes(16));
        if (!preg_match('/^(\d+(,\d+)*)?$/', $rmdates)) {
        $message="Input string should only contain comma-separated integers.";
        }else{
        $stmt = $mysqli->prepare("INSERT INTO speakers (name, hostname, affiliation, unique_url,rmdates) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $hostname,$affiliation, $token,$rmdates);
        $stmt->execute();
        $message = "Speaker added successfully!";
        }
    } elseif (isset($_POST['edits'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $hostname = $_POST['hostname'];
        $rmdates = $_POST['rmdates'];
        if (!preg_match('/^(\d+(,\d+)*)?$/', $rmdates)) {
        $message="Input string should only contain comma-separated integers.";
        }else{
        $stmt = $mysqli->prepare("UPDATE speakers SET name = ?, hostname = ?, rmdates = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $hostname,$rmdates,$id);
        $stmt->execute();
        $message = "Speaker updated successfully!";
        }
    } elseif (isset($_POST['deletes'])) {
        $id = $_POST['id'];

        $stmt = $mysqli->prepare("DELETE FROM speakers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $message = "Speaker deleted successfully!";
    } elseif (isset($_POST['editss'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $hostname = $_POST['hostname'];
        $sem_date = $_POST['sem_date'];
        $sem_time = $_POST['sem_time'];
        $location= $_POST['location'];
        $zlink= $_POST['zlink'];
        $affiliation = $_POST['affiliation'];
        $stmt = $mysqli->prepare("UPDATE speakers SET name = ?, hostname = ?, sem_date = ?, sem_time = ?, location = ?, zlink = ?, affiliation = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $name, $hostname,$sem_date,$sem_time,$location,$zlink,$affiliation,$id);
        $stmt->execute();
        $message = "Speaker updated successfully!";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    //exit;
}

// Query all seminar dates along with speaker names
$datesResult = $mysqli->query("SELECT seminar_dates.id, seminar_dates.date, speakers.name AS speaker_name, speakers.id AS speaker_id FROM seminar_dates LEFT JOIN speakers ON seminar_dates.speaker_id = speakers.id ORDER BY seminar_dates.date");
If(!$datesResult){
    echo "error query date results";
}
// Query all speakers for the dropdown
$upcomingspeakersResult = $mysqli->query("SELECT id, name FROM speakers WHERE sem_date >= CURDATE() OR sem_date = 0000-00-00 ORDER BY sem_date");
If(!$upcomingspeakersResult){
    echo "error upcomingspeakersResult";
}
$speakersResult = $mysqli->query("SELECT * FROM speakers WHERE sem_date >= CURDATE() OR sem_date = 0000-00-00 ORDER BY sem_date");
$speakersResult3 = $mysqli->query("SELECT * FROM speakers WHERE sem_date >= CURDATE() OR sem_date = 0000-00-00 ORDER BY sem_date");
$pastspeakersResult = $mysqli->query("SELECT * FROM speakers WHERE sem_date < CURDATE() AND sem_date != 0000-00-00 ORDER BY sem_date");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
        border: 1px solid white;
        border-collapse: collapse;
        }
        th, td {
        background-color: #96D4D4;
        }
    </style>
</head>
<body>
    <?php
    echo "<hr><p>"; echo $message; echo "</p><hr>";
    ?>
    <h1>Manage Seminar Dates</h1>
    <form action="" method="post">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        <button type="submit" name="add">Add Date</button>
    </form>
    <h2>Existing Dates</h2>
    <table>
        <!-- ... -->

        <?php
        $x=1;
        while ($row = $datesResult->fetch_assoc()): ?>
            <tr>
                <td>
                <?php echo $x;echo ")"; $x++;?>
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="date" name="date" value="<?= $row['date'] ?>">
                        <select name="speaker_id">
                            <option value="">Not Assigned</option>
                            <?php 
                            $upcomingspeakersResult->data_seek(0); 
                            while ($speaker = $upcomingspeakersResult->fetch_assoc()): ?>
                            <option value="<?= $speaker['id'] ?>" <?= $speaker['id'] == $row['speaker_id'] ? 'selected' : '' ?>><?= $speaker['name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit" name="edit">Update</button>
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <hr>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <label for="hostname">Host Name:</label>
        <input type="text" name="hostname" id="hostname" required>
        <label for="affiliation">Affiliation:</label>
        <input type="text" name="affiliation" id="affiliation" required>
        <label for="stdate">Remove Dates:</label>
        <input type="text" name="rmdates" id="rmdates">
        <button type="submit" name="adds">Add Speaker</button>
    </form>
    <h2>Current Speakers</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Host Name</th>
            <th>Name, Host Name, Remove Dates:</th>
            <th>Invite Link</th>
            <th>Title/Abstract Link</th>
        </tr>
        <?php while ($row = $speakersResult->fetch_assoc()): ?>
            <tr>
                <?php
            // SQL query to check if an entry with a specific speaker_id exists
                $stmt3 = $mysqli->prepare( "SELECT COUNT(*) as count FROM seminar_dates WHERE speaker_id = ?");
                $stmt3->bind_param("i",$row['id']);
                $stmt3->execute();
                $stmt3->bind_result($count);
                $stmt3->fetch();
                if ($count > 0) {
                    $clr="#393";
                } else {
                    $clr="#96D4D4";
                }
                $stmt3->close();
                ?>

                <td <?php echo "style=\"background-color:".$clr."\""; ?>>  <?= $row['name'] ?></td>
                <td <?php echo "style=\"background-color:".$clr."\""; ?> ><?= $row['hostname'] ?></td>
                <td <?php echo "style=\"background-color:".$clr."\""; ?>  >
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="text" name="name" value="<?= $row['name'] ?>">
                        <input type="Text" name="hostname" value="<?= $row['hostname'] ?>">
                        <input type="text" name="rmdates" value="<?= $row['rmdates'] ?>">
                        <button type="submit" name="edits">Update</button>
                        <button type="submit" name="deletes">Delete</button>
                    </form>
                </td>
                <td <?php echo "style=\"background-color:".$clr."\""; ?>  >
                <p class="text-to-copy" style="font-size:50%">some url/choosedate.php?token=<?= $row['unique_url'] ?></p>
                <a href="#" class="copy-link">Click to copy invite link</a>
                </td>
                <td <?php echo "style=\"background-color:".$clr."\""; ?>  >
                <p class="text-to-copy" style="font-size:50%">some url/titleabstract.php?token=<?= $row['unique_url'] ?></p>
                <a href="#" class="copy-link">Click to copy title/abstract link</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

<hr>
    <?php
    echo "<hr><p>"; echo $message; echo "</p><hr>";
    ?>
    <h2>Current Seminar details</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Host Name</th>
            <th>Date:</th>
            <th>Time:</th>
            <th>Location</th>
            <th>Zoom Link</th>
            <th>Affiliation</th>
            <th>Past Event</th>
        </tr>
        <?php while ($row = $speakersResult3->fetch_assoc()): ?>
            <tr>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td><input type="text" name="name" value="<?= $row['name'] ?>"></td>
                        <td><input type="Text" name="hostname" value="<?= $row['hostname'] ?>"></td>
                        <td><input type="date" name="sem_date" value="<?= $row['sem_date'] ?>"></td>
                        <td><input type="time" name="sem_time" value="<?= $row['sem_time'] ?>"></td>
                        <td><input type="Text" name="location" value="<?= $row['location'] ?>"></td>
                        <td><input type="Text" name="zlink" value="<?= $row['zlink'] ?>"></td>
                        <td><input type="Text" name="affiliation" value="<?= $row['affiliation'] ?>"></td>
<!--                        <td><input type="checkbox" id="pastevent" name="pastevent" value="<?= $row['pastevent'] ?>"></td>-->
                        <td><button type="submit" name="editss">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <hr>
    <h2>Past Seminar details</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Host Name</th>
            <th>Date:</th>
            <th>Time:</th>
            <th>Location</th>
            <th>Zoom Link</th>
            <th>Affiliation</th>
            <th>Past Event</th>
        </tr>
        <?php while ($row = $pastspeakersResult->fetch_assoc()): ?>
            <tr>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td><input type="text" name="name" value="<?= $row['name'] ?>"></td>
                        <td><input type="Text" name="hostname" value="<?= $row['hostname'] ?>"></td>
                        <td><input type="date" name="sem_date" value="<?= $row['sem_date'] ?>"></td>
                        <td><input type="time" name="sem_time" value="<?= $row['sem_time'] ?>"></td>
                        <td><input type="Text" name="location" value="<?= $row['location'] ?>"></td>
                        <td><input type="Text" name="zlink" value="<?= $row['zlink'] ?>"></td>
                        <td><input type="Text" name="affiliation" value="<?= $row['affiliation'] ?>"></td>
<!--                        <td><input type="checkbox" id="pastevent" name="pastevent" value="<?= $row['pastevent'] ?>"></td>-->
                        <td><button type="submit" name="editss">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <script>
        var copyLinks = document.querySelectorAll('.copy-link');

        copyLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                // Get the text you want to copy
                var textToCopy = event.target.previousElementSibling.innerText;

                // Create a temporary textarea element to hold the text
                var textarea = document.createElement('textarea');
                textarea.value = textToCopy;
                document.body.appendChild(textarea);

                // Select the text in the textarea
                textarea.select();

                // Execute the copy command
                document.execCommand('copy');

                // Remove the temporary textarea element
                document.body.removeChild(textarea);

            });
        });
    </script>
    <?php
        $mysqli->close();
    ?>
</body>
</html>
