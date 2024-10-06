<?php
include("C:/xampp/htdocs/Record-Management-System-second_revision/navbar.php"); 
include("database_conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Details</title>
    <link rel="stylesheet" type="text/css" href="/Record-Management-System-second_revision/sidebar-navbar.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .class-header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .class-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .class-header h3 {
            margin-top: 10px;
            font-size: 20px;
        }

        .student-list {
            margin-top: 30px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .student-list h2 {
            font-size: 22px;
            margin-bottom: 20px;
        }

        .student-list ul {
            list-style-type: none;
            padding: 0;
        }

        .student-list li {
            background-color: #f1f1f1;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .student-list li:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<?php

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
} elseif (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];
} else {
    echo "<p>Error: No class selected.</p>";
    exit();
}


$class_query = "
    SELECT c.subject, c.section, t.name AS teacher_name
    FROM classes c    
    JOIN teachers t ON c.teacher_id = t.teacher_id
    WHERE c.class_id = '$class_id'";
$class_result = mysqli_query($conn, $class_query);
$class_info = mysqli_fetch_assoc($class_result);


$student_query = "
    SELECT s.student_id, s.first_name, s.last_name
    FROM students s
    JOIN student_class sc ON s.student_id = sc.student_id
    WHERE sc.class_id = '$class_id'";
$student_result = mysqli_query($conn, $student_query);

if ($class_info) {
    echo "<div class='class-header'>";
    echo "<h1>Class: {$class_info['subject']} - Section: {$class_info['section']}</h1>";
    echo "<h3>Teacher: {$class_info['teacher_name']}</h3>";
    echo "</div>";
} else {
    echo "<p>Class information not found.</p>";
    exit();
}


if (mysqli_num_rows($student_result) > 0) {
    echo "<div class='student-list'>";
    echo "<h2>Students</h2>";
    echo "<ul>";
    while ($student = mysqli_fetch_assoc($student_result)) {
        echo "<li>{$student['first_name']} {$student['last_name']}</li>";
    }
    echo "</ul>";
    echo "</div>";
} else {
    echo "<p>No students found in this class.</p>";
}
?>

</body>
</html>
