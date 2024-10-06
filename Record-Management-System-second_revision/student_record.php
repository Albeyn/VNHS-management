<?php
include("database_conn.php");
include("navbar.php");

$fields = [];
$result = null;

$view_all_query = "SELECT * FROM students";
$query = $view_all_query;

// Handle delete request
if (isset($_GET['delete_student_id'])) {
    $student_id_to_delete = filter_input(INPUT_GET, 'delete_student_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($student_id_to_delete) {
        $delete_query = "DELETE FROM students WHERE student_id = ?";
        if ($stmt = mysqli_prepare($conn, $delete_query)) {
            mysqli_stmt_bind_param($stmt, 'i', $student_id_to_delete);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Student record deleted successfully.";
            } 
        }
    }
}

if (isset($_POST["submit-button"])) {
    $search = filter_input(INPUT_POST, "search-input", FILTER_SANITIZE_SPECIAL_CHARS);
    $search_type = $_POST['search-type'];

    if ($search_type == 'id') {
        $query = "SELECT * FROM students WHERE student_id = ?";
    } else if ($search_type == 'name') {
        $query = "SELECT * FROM students WHERE first_name LIKE ?";
        $search = "%$search%";
    }

    if ($stmt = mysqli_prepare($conn, $query)) {
        if ($search_type == 'id') {
            mysqli_stmt_bind_param($stmt, 'i', $search);
        } else if ($search_type == 'name') {
            mysqli_stmt_bind_param($stmt, 's', $search);
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $fields = mysqli_fetch_fields($result);
        } else {
            $fields = [];
            $no_results_message = "No records found matching your search criteria.";
        }
    }
} else if (isset($_POST["view-all-button"]) || !isset($_POST["submit-button"])) {
    $result = mysqli_query($conn, $view_all_query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $fields = mysqli_fetch_fields($result);
        } else {
            $fields = [];
            $no_results_message = "No records found in the database.";
        }
    }
}

function formatFieldName($field_name)
{
    $formatted = str_replace('_', ' ', $field_name);
    $formatted = ucwords($formatted);
    return $formatted;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #F8F9FA;
        }

        .content {
            margin: 20px auto;
            width: 95%;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-bar select,
        .search-bar input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-bar input[type="text"] {
            width: 300px;
            margin-left: 10px;
        }

        .search-button,
        .view-all-button {
            padding: 10px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-left: 10px;
        }

        .search-button:hover,
        .view-all-button:hover {
            background-color: #0056b3;
        }

        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .student-table th,
        .student-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .student-table th {
            background-color: #007BFF;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .editBtn,
        .deleteBtn {
            padding: 5px 10px;
            font-size: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .editBtn {
            background-color: #28A745;
        }

        .editBtn:hover {
            background-color: #218838;
        }

        .deleteBtn {
            background-color: #DC3545;
        }

        .deleteBtn:hover {
            background-color: #C82333;
        }

        .no-results {
            text-align: center;
            font-size: 30px;
        }

        .addBtn {
    padding: 10px 15px;
    font-size: 16px;
    background-color: #28A745;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.addBtn:hover {
    background-color: #218838;
}


    </style>
</head>

<body>
    <div class="content">
        <h1>Student Records</h1>
        <form class="search-bar" method="post" action="student_record.php">
            <select name="search-type" class="search-type">
                <option value="id">Search by ID</option>
                <option value="name">Search by Name</option>
            </select>
            <input type="text" placeholder="Search..." name="search-input">
            <input type="submit" class="search-button" value="Search" name="submit-button">
            <input type="submit" class="view-all-button" value="View All" name="view-all-button">
        </form>
      <!-- Add New Student Button -->
      <div class="action-buttons">
            <form action="add.php" method="post">
                <button type="submit" class="addBtn">Add New Student</button>
            </form>
        </div>


        <?php
        if (isset($no_results_message)) {
            echo "<div class='no-results'>$no_results_message</div>";
        }
        ?>

        <table class="student-table">
            <thead>
                <tr>
                    <?php
                    if ($fields) {
                        foreach ($fields as $field) {
                            echo "<th>" . formatFieldName($field->name) . "</th>";
                        }
                        echo "<th>Actions</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        foreach ($row as $cell) {
                            echo "<td>$cell</td>";
                        }
                        // Edit and Delete buttons
                        echo "<td>
                                <a class='editBtn' href='edit_student.php?student_id={$row['student_id']}'>Edit</a>
                                <a class='deleteBtn' href='student_record.php?delete_student_id={$row['student_id']}' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
