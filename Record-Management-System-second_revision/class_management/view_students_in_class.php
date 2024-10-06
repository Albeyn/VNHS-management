<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/Record-Management-System-second_revision/sidebar-navbar.css">

    <style>
        
        .class-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .class-table th, .class-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .class-table th {
            background-color: #007BFF;
            color: white;
        }

        .class-table td {
            background-color: #f9f9f9;
        }

      
        .edit-button, .delete-button, .save-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-button:hover, .delete-button:hover, .save-button:hover {
            background-color: #0056b3;
        }

      
        .edit-row input, .edit-row select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .edit-row .save-button {
            background-color: #28a745;
        }

        .edit-row .save-button:hover {
            background-color: #218838;
        }

        
        .search-bar {
            margin: 20px 0;
        }

        .search-bar input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px; 
        }

        
        .schedule-column {
            color: #333;
            font-weight: bold;
            font-size: 14px;
            background-color: #e9ecef;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
        }

        .schedule-column input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .link {
            color: #007BFF;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .class-table th, .class-table td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>

    <script>
        function editClass(button) {
            const row = button.closest('tr');
            const nextRow = row.nextElementSibling;

            // Toggle the display of the edit row
            if (nextRow.style.display === 'none' || nextRow.style.display === '') {
                nextRow.style.display = 'table-row'; // Show the edit row
            } else {
                nextRow.style.display = 'none'; // Hide the edit row
            }
        }
    </script>
</head>
<body>

<?php  
include("database_conn.php");
include("C:/xampp/htdocs/Record-Management-System-second_revision/navbar.php"); 

$searchTerm = ""; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = $_POST['search_term'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_class'])) {
        $class_id = $_POST['class_id'];
        $subject = $_POST['subject'];
        $section = $_POST['section'];
        $teacher_id = $_POST['teacher_id'];
        $schedule = $_POST['schedule']; 

        
        $update_query = "UPDATE classes SET subject = ?, section = ?, teacher_id = ?, schedule = ? WHERE class_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssisi", $subject, $section, $teacher_id, $schedule, $class_id); 

        if ($stmt->execute()) {
            echo "<script>alert('Class updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating class: " . mysqli_error($conn) . "');</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['delete_class'])) {
        $class_id = $_POST['class_id'];

       
        $delete_query = "DELETE FROM classes WHERE class_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $class_id);

        if ($stmt->execute()) {
            echo "<script>alert('Class deleted successfully.');</script>";
        } else {
            echo "<script>alert('Error deleting class: " . mysqli_error($conn) . "');</script>";
        }
        $stmt->close();
    }
}


$query = "SELECT classes.class_id, classes.subject, classes.section, classes.schedule, teachers.teacher_id, teachers.name 
          FROM classes 
          LEFT JOIN teachers ON classes.teacher_id = teachers.teacher_id
          WHERE classes.section LIKE ? OR classes.subject LIKE ? OR teachers.name LIKE ?";

$stmt = $conn->prepare($query);
$searchParam = "%$searchTerm%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam); 
$stmt->execute();
$result = $stmt->get_result();


if ($result) {
    echo "<h1>Classes</h1>";

   
    echo "<div class='search-bar'>
            <form method='post'>
                <input type='text' name='search_term' value='" . htmlspecialchars($searchTerm) . "' placeholder='Search by section, subject, or teacher name...' />
                <button type='submit' name='search' class='edit-button'>Search</button>
            </form>
          </div>";

    echo "<table class='class-table'>";
    echo "<thead>
            <tr>
                <th>Section</th>
                <th>Subject</th>
                <th>Schedule</th> <!-- New schedule column header -->
                <th>Teacher</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        
        echo "
            <td>
                <a href='view_students_by_section.php?section={$row['section']}&class_id={$row['class_id']}' class='link'>{$row['section']}</a>
            </td>
            <td>{$row['subject']}</td>
            <td>{$row['schedule']}</td> <!-- Displaying the schedule -->
            <td><a href='/Record-Management-System-second_revision/view_teachers.php?teacher_id={$row['teacher_id']}' class='link'>{$row['name']}</a></td>
        ";

      
        echo "
            <td>
                <form method='post'>
                    <input type='hidden' name='class_id' value='{$row['class_id']}'>
                    <button type='button' onclick='editClass(this)' class='edit-button'>Edit</button>
                    <button type='submit' name='delete_class' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this class?\");'>Delete</button>
                </form>
            </td>
        ";
        echo "</tr>";

       
        echo "
            <tr class='edit-row' style='display: none;'>
                <form method='post'>
                    <input type='hidden' name='class_id' value='{$row['class_id']}'>
                    <td><input type='text' name='section' value='{$row['section']}' required></td>
                    <td><input type='text' name='subject' value='{$row['subject']}' required></td>
                    <td><input type='text' name='schedule' value='{$row['schedule']}' required></td> <!-- Schedule input field -->
                    <td>
                        <select name='teacher_id' required>
        ";

        
        $teacher_query = "SELECT teacher_id, name FROM teachers";
        $teacher_result = mysqli_query($conn, $teacher_query);
        while ($teacher_row = mysqli_fetch_assoc($teacher_result)) {
            $selected = $teacher_row['teacher_id'] == $row['teacher_id'] ? 'selected' : '';
            echo "<option value='{$teacher_row['teacher_id']}' $selected>{$teacher_row['name']}</option>";
        }
        echo "
                        </select>
                    </td>
                    <td>
                        <button type='submit' name='edit_class' class='save-button'>Save</button>
                    </td>
                </form>
            </tr>
        ";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "Error fetching classes: " . mysqli_error($conn);
}

$conn->close();
?>
</body>
</html>
