<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"],
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
    </style>

</head>

<body>
    <h2>Add New Class</h2>

    <form action="add_class.php" method="POST">
        <label for="class_name">Class Name:</label>
        <input type="text" id="class_name" name="class_name" required><br>

        <label for="teacher_id">Assign Teacher:</label>
        <select name="teacher_id" id="teacher_id" required>
            <?php
            include 'database_conn.php';

            // Test database connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Fetching teachers
            $query = "SELECT teacher_id, name FROM teachers";
            $result = mysqli_query($conn, $query);

            // Check for query execution errors
            if (!$result) {
                die("Error executing query: " . mysqli_error($conn));
            }

            // Loop through and display teachers in the dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['teacher_id']}'>{$row['name']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Add Class">
    </form>

    <h2>Class List</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Class Name</th>
            <th>Teacher</th>
        </tr>
        <?php
        // Fetching class list with teacher names
        $query = "SELECT c.class_id, c.class_name, t.name
                  FROM classes c
                  JOIN teachers t ON c.teacher_id = t.teacher_id";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Error fetching class list: " . mysqli_error($conn));
        }

        // Display each class and its teacher
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['class_name']}</td>
                    <td>{$row['name']}</td>
                  </tr>";
        }
        ?>
    </table>

</body>

</html>