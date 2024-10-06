<?php
include("database_conn.php");

$message = '';
$message_class = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_term = $_POST['search_term'];

    $sql = "SELECT * FROM students WHERE student_id LIKE ? OR first_name LIKE ? OR last_name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term_wildcard = "%$search_term%";
    $stmt->bind_param("sss", $search_term_wildcard, $search_term_wildcard, $search_term_wildcard);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $search_results = "<h2>Search Results</h2>";
        $search_results .= "<table>";
        $search_results .= "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $search_results .= "<tr>";
            $search_results .= "<td>" . htmlspecialchars($row['student_id']) . "</td>";
            $search_results .= "<td>" . htmlspecialchars($row['first_name']) . "</td>";
            $search_results .= "<td>" . htmlspecialchars($row['last_name']) . "</td>";
            $search_results .= "<td>";
            $search_results .= "<a href='edit_student.php?student_id=" . urlencode($row['student_id']) . "' class='button'>Edit</a> ";
            $search_results .= "<a href='delete.php?student_id=" . urlencode($row['student_id']) . "' onclick='return confirm(\"Are you sure you want to delete this record?\");' class='button button-danger'>Delete</a>";
            $search_results .= "</td>";
            $search_results .= "</tr>";
        }
        $search_results .= "</table>";
    } else {
        $search_results = "<p>No students found.</p>";
    }

    $stmt->close();
}


if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        $student = null;
        $message = "No student found with the given ID.";
        $message_class = "error";
    }
    $stmt->close();
} else {
    $student = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard_style.css">
    <link rel="stylesheet" href="sidebar-navbar.css">
    <title>Search and Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            margin-left: 800px;

        }

        h2 {
            color: #333;
            margin-bottom: 20px;


        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }


        .search-form {
            display: flex;
            /* flex-wrap: wrap; */

        }

        .search-form button {
            height: 38 px;
        }

        .search-form input[type="text"] {
            margin-right: 10px;
        }

        .search-form button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;

        }

        table {
            margin: 20px;
            width: 98%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
        }

        .button {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            background-color: #007bff;
            border: none;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button.button-danger {
            background-color: #dc3545;
        }

        .button.button-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="burger-menu" id="burgerMenu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="sidebar" id="sidebar">
        <h2>VNHS RMS</h2>
        <a href="Dashboard.php">Dashboard</a>
        <a href="student_record.php">Student Records</a>
        <a href="view_teachers.php">Teacher Records</a>
        <a href="settings.html">Settings</a>
        <a href="#logout" class="logout">Log out</a>
    </div>

    <nav class="navbar">
        <img src="vega national high school.png" alt="" class="logo" />
        <div class="nav-links">
            <a href="Dashboard.html">Dashboard</a>
            <a href="student_record.php">Student Records</a>
            <a href="view_teachers.php">Teacher Records</a>
            <a href="settings.html">Settings</a>
            <a href="#logout" class="logout">Log out</a>
        </div>
    </nav>



    <form class="search-form" method="post" action="edit_student.">
            <select name="search-type" class="search-type">
                <option value="id">Search by ID</option>
                <option value="name">Search by Name</option>
            </select>
            <input type="text" placeholder="Search..." name="search-input">
            <input type="submit" class="search-button" value="Search" name="submit-button">
        </form>

    <?php if (isset($search_results)) echo $search_results; ?>

    <?php if ($student): ?>
        <h2>Edit Student Information</h2>
        <form action="update_student.php" method="POST">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>

            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade_level" value="<?php echo htmlspecialchars($student['grade_level']); ?>" required>

            <label for="enrollment_date">Enrollment Date:</label>
            <input type="date" id="enrollment_date" name="enrollment_date" value="<?php echo htmlspecialchars($student['enrollment_date']); ?>" required>
<!-- 
            <label for="emergency_contacts">Emergency Contacts:</label>
            <input type="text" id="emergency_contacts" name="emergency_contacts" value="<?php echo htmlspecialchars($student['emergency_contacts']); ?>"> -->

            <label for="parent_names">Parent Names:</label>
            <input type="text" id="parent_names" name="parent_names" value="<?php echo htmlspecialchars($student['parent_names']); ?>">

            <label for="parent_contact">Parent Contact:</label>
            <input type="text" id="parent_contact" name="parent_contact" value="<?php echo htmlspecialchars($student['parent_contact']); ?>">

            <button class="button
            " type="submit" name="update">Update</button>
        </form>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <div class="message <?php echo $message_class; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <script src="burger_menu.js"></script>
</body>

</html>