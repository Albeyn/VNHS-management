<?php
include("database_conn.php");
include("C:/xampp/htdocs/Record-Management-System-second_revision/navbar.php"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/Record-Management-System-second_revision/sidebar-navbar.css">



    <title>Class Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: inline-block;
            width: 150px;
            margin-right: 10px;
        }
        select, input {
            margin-bottom: 10px;
            padding: 5px;
            width: 300px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-section {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>

<h1>Class Management</h1>


<div class="form-section">
    <h2>Add a New Class</h2>
    <form action="" method="post">
        <label for="class_name">Subject:</label>
        <input type="text" name="subject" id="class_name" required>
        <br>

        <label for="section">Section:</label>
        <input type="text" name="section" id="section" required>
        <br>

        <label for="teacher_id">Select Teacher:</label>
        <select name="teacher_id" id="teacher_id" required>
            <?php
            
            $teachers_query = "SELECT teacher_id, name FROM teachers";
            $teachers_result = mysqli_query($conn, $teachers_query);
            while ($teacher = mysqli_fetch_assoc($teachers_result)) {
                echo "<option value='{$teacher['teacher_id']}'>{$teacher['name']}</option>";
            }
            ?>
        </select>
        <br>

        <label for="year_level">Year Level:</label>
        <input type="number" name="year_level" id="year_level" required>
        <br>

        <label for="schedule">Schedule:</label>
        <input type="text" name="schedule" id="schedule" required>
        <br>

        <button type="submit" name="add_class">Add Class</button>
    </form>
</div>

<?php

if (isset($_POST['add_class'])) {
    $subject = $_POST['subject'];
    $section = $_POST['section'];
    $teacher_id = $_POST['teacher_id'];
    $year_level = $_POST['year_level'];
    $schedule = $_POST['schedule'];

    $add_class_query = "INSERT INTO classes (subject, section, teacher_id, year_level, schedule) 
                        VALUES ('$subject', '$section', '$teacher_id', '$year_level', '$schedule')";

    if (mysqli_query($conn, $add_class_query)) {
        echo "<p>Class added successfully!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($conn) . "</p>";
    }
}

?>




</body>
</html>
