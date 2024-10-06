<?php
include 'database_conn.php';

// If the form is submitted, process the input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_id = $_POST['class_id'];
    $student_ids = $_POST['student_ids']; // This is an array of student IDs

    foreach ($student_ids as $student_id) {
        // Insert each student into the class
        $sql = "INSERT INTO students_classes (class_id, student_id) VALUES ('$class_id', '$student_id')";

        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Students to Class</title>
    <style>
        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Assign Students to Class</h2>

    <form action="" method="POST">
        <label for="class_id">Select Class:</label>
        <select name="class_id" id="class_id" required>
            <?php
            $query = "SELECT class_id, class_name FROM classes";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Error fetching classes: " . mysqli_error($conn));
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['class_id']}'>{$row['class_name']}</option>";
            }
            ?>
        </select><br>

        <label for="student_ids">Select Students:</label>
        <select name="student_ids[]" id="student_ids" multiple required>
            <?php
            $query = "SELECT student_id, first_name FROM students";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Error fetching students: " . mysqli_error($conn));
            }
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['student_id']}'>{$row['first_name']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Assign Students">
    </form>

    <h2>Students Assigned to Classes</h2>
    <table>
        <tr>
            <th>Class Name</th>
            <th>Student Name</th>
        </tr>
        <?php
 
        $query = "SELECT c.class_name, s.first_name
                  FROM students_classes sc
                  JOIN classes c ON sc.class_id = c.class_id
                  JOIN students s ON sc.student_id = s.student_id
                  ORDER BY c.class_name";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Error fetching assigned students: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['class_name']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
// Close the connection
mysqli_close($conn);
?>