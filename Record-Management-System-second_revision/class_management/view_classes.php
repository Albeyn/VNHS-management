<?php
include("database_conn.php");
include ("navbar.php");

$query = "SELECT c.class_name, c.section, t.name, t.subject, c.year_level, c.schedule 
          FROM classes c
          JOIN teachers t ON c.teacher_id = t.teacher_id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Classes</title>
</head>
<body>

<h1>Classes</h1>

<table border="1">
    <thead>
        <tr>
            <th>Class Name</th>
            <th>Section</th>
            <th>Teacher</th>
            <th>Subject</th>
            <th>Year Level</th>
            <th>Schedule</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($class = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$class['class_name']}</td>
                    <td>{$class['section']}</td>
                    <td>{$class['name']} </td>
                    <td>{$class['subject']}</td>
                    <td>{$class['year_level']}</td>
                    <td>{$class['schedule']}</td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
