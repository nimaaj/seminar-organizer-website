<?php
// Database connection
$mysqli = new mysqli("localhost", "my_user","my_password","my_db");

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
        $rmdates = $_POST['rmdates'];
        $token = bin2hex(random_bytes(16));
        if (!preg_match('/^(\d+(,\d+)*)?$/', $rmdates)) {
        $message="Input string should only contain comma-separated integers.";
        }else{
        $stmt = $mysqli->prepare("INSERT INTO speakers (name, hostname, unique_url,rmdates) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $hostname, $token,$rmdates);
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
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Query all seminar dates along with speaker names
$datesResult = $mysqli->query("SELECT seminar_dates.id, seminar_dates.date, speakers.name AS speaker_name, speakers.id AS speaker_id FROM seminar_dates LEFT JOIN speakers ON seminar_dates.speaker_id = speakers.id ORDER BY seminar_dates.date");
// Query all speakers for the dropdown
$speakersResult2 = $mysqli->query("SELECT id, name FROM speakers");
$speakersResult = $mysqli->query("SELECT * FROM speakers");



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
    <h2>Seminar details</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Host Name</th>
            <th>Time:</th>
            <th>Location</th>
            <th>Zoom Link</th>
            <th>Affiliation</th>
        </tr>
        <?php while ($row = $speakersResult->fetch_assoc()): ?>
            <tr>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td><input type="text" name="name" value="<?= $row['name'] ?>"></td>
                        <td><input type="Text" name="hostname" value="<?= $row['hostname'] ?>"></td>
                        <td><input type="time" name="sem_time" value="<?= $row['sem_time'] ?>"></td>
                        <td><input type="Text" name="location" value="<?= $row['location'] ?>"></td>
                        <td><input type="Text" name="zlink" value="<?= $row['zlink'] ?>"></td>
                        <td><input type="Text" name="affiliation" value="<?= $row['affiliation'] ?>"></td>
                        <td><button type="submit" name="editss">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
