<?php
// Database connection parameters

$conn = new mysqli("localhost", "my_user","my_password","my_db");
// Check connection
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold the form values
// $name = $affiliation = $date = $time = $location = $title = $abstract = $zoom_link = "";
// $id = 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert
    if (isset($_POST['add'])) {
        // Add your insert logic here
        $token = bin2hex(random_bytes(16));
        $sql   = "INSERT INTO jcevnets (name, affiliation, date, time, location, title, abstract, zoom_link, token)
                VALUES ('" . $_POST['name'] . "', '" . $_POST['affiliation'] . "', '" . $_POST['date'] . "', '" . $_POST['time'] . "', '" . $_POST['location'] . "', '" . $_POST['title'] . "', '" . $_POST['abstract'] . "', '" . $_POST['zoom_link'] . "', '" . $token . "')";
        $conn->query($sql);
        header("Location: jcadmin.php"); // Redirect to the same page to see the updated list
    }

    // Edit
    if (isset($_POST['edit'])) {
        $id  = $_POST['id'];
        $sql = "UPDATE jcevnets SET name='" . $_POST['name'] . "', affiliation='" . $_POST['affiliation'] . "', date='" . $_POST['date'] . "', time='" . $_POST['time'] . "', location='" . $_POST['location'] . "', title='" . $_POST['title'] . "', abstract='" . $_POST['abstract'] . "', zoom_link='" . $_POST['zoom_link'] . "' WHERE id=$id";
        $conn->query($sql);
        header("Location: jcadmin.php"); // Redirect to the same page to see the updated list
    }

    // Delete
    if (isset($_POST['delete'])) {
        $id  = $_POST['id'];
        $sql = "DELETE FROM jcevnets WHERE id=$id";
        $conn->query($sql);
        header("Location: jcadmin.php"); // Redirect to the same page to see the updated list
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    //    exit;
}
// Fetch data
$sql    = "SELECT * FROM jcevnets WHERE date >= CURDATE() OR date = '0000-00-00' ORDER BY date";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
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

<h2>Manage Event</h2>

<form action="" method="post">
    <input type="hidden" name="id" value="<?php
echo $id;
?>">
    Name: <input type="text" name="name" required value="<?php
echo $name;
?>"><br>
    Affiliation: <input type="text" name="affiliation" required value="<?php
echo $affiliation;
?>"><br>
    Date: <input type="date" name="date" required value="<?php
echo $date;
?>"><br>
    Time: <input type="time" name="time" required value="<?php
echo $time;
?>"><br>
    Location: <input type="text" name="location" required value="<?php
echo $location;
?>"><br>
    Title: <input type="text" name="title" required value="<?php
echo $title;
?>"><br>
    Abstract: <textarea name="abstract"><?php
echo $abstract;
?></textarea><br>
    Zoom Link: <input type="text" name="zoom_link" value="<?php
echo $zoom_link;
?>"><br>
    <input type="submit" name="add" value="Add">
</form>


<h2>Current Events</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Affiliation</th>
            <th>date</th>
            <th>time</th>
            <th>location</th>
            <th>zoom link</th>
            <th>Title/Abstract Link</th>
        </tr>
        <?php
while ($row = $result->fetch_assoc()):
?>
           <tr>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <td><input type="text" name="name" value="<?= $row['name'] ?>" required></td>
                        <td><input type="Text" name="affiliation" value="<?= $row['affiliation'] ?>" required></td>
                        <td><input type="date" name="date" value="<?= $row['date'] ?>" required></td>
                        <td><input type="time" name="time" value="<?= $row['time'] ?>" required></td>
                        <td><input type="Text" name="location" value="<?= $row['location'] ?>" required></td>
                        <td><input type="Text" name="zoom_link" value="<?= $row['zoom_link'] ?>" required></td>
                        <td>
                        <p class="text-to-copy" style="font-size:50%">some url/jcdetails.php?token=<?= $row['token'] ?></p>
                        <a href="#" class="copy-link">Click to copy title/abstract link</a>
                        </td>
                        <td><button type="submit" name="edit">Update</button></td>
                        <td><button type="submit" name="delete">Delete</button></td>
                    </form>

            </tr>
        <?php
endwhile;
?>
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
</body>
</html>
