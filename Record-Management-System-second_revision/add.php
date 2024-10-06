<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>
    <link rel="stylesheet" href="sidebar-navbar.css">
    <link rel="stylesheet" type="text/css" href="/Record-Management-System-second_revision/sidebar-navbar.css">
    <?php include("C:/xampp/htdocs/Record-Management-System-second_revision/navbar.php"); ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            margin: auto;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
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
        <a href="Dashboard.html">Dashboard</a>
        <a href="student_record.php">Student Records</a>
        <a href="view_teachers.php">Teacher Records</a>
        <a href="settings.html">Settings</a>
        <a href="#logout" class="logout">Log out</a>
    </div>

    <div class="form-container">
        <h2>Add Student Information</h2>
        <form action="" method="POST">

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="address">Home Address:</label>
                <textarea id="address" name="address" required></textarea>
            </div>

            <div class="form-group">
                <label for="grade_level">Grade Level:</label>
                <input type="text" id="grade_level" name="grade_level" required>
            </div>

            <div class="form-group">
                <label for="enrollment_date">Enrollment Date:</label>
                <input type="date" id="enrollment_date" name="enrollment_date" required>
            </div>

            <div class="form-group">
                <label for="parent_names">Parent Names:</label>
                <input type="text" id="parent_names" name="parent_names" required>
            </div>

            <div class="form-group">
                <label for="parent_contact">Parent Contact:</label>
                <input type="tel" id="parent_contact" name="parent_contact" required>
            </div>

            <button type="submit" name="submit_button">Submit</button>
        </form>
    </div>
    <script src="burger_menu.js"></script>
</body>

</html>

<?php
include("database_conn.php");

// Function to generate a unique student ID
function generateStudentId($conn)
{
    $current_year = date("Y");

    $sql = "SELECT student_id FROM students WHERE student_id LIKE ? ORDER BY student_id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $search_term = $current_year . '%';
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_student_id = $row['student_id'];
        $last_sequence = (int)substr($last_student_id, 4);
        $new_sequence = $last_sequence + 1;
    } else {
        $new_sequence = 1;
    }

    $student_id = $current_year . str_pad($new_sequence, 4, '0', STR_PAD_LEFT);
    return $student_id;
}

if (isset($_POST['submit_button'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $home_address = $_POST['address'];
    $grade_level = $_POST['grade_level'];
    $enrollment_date = $_POST['enrollment_date'];
    $parent_names = $_POST['parent_names'];
    $parent_contact = $_POST['parent_contact'];

    $student_id = generateStudentId($conn);

    // Updated SQL statement with 11 parameters
    $sql = "INSERT INTO students (student_Id, first_name, last_name, dob, gender, phone, home_address, grade_level, enrollment_date, parent_names, parent_contact) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Corrected to match the number of bound parameters
        $stmt->bind_param("sssssssssss", $student_id, $first_name, $last_name, $dob, $gender, $phone, $home_address, $grade_level, $enrollment_date, $parent_names, $parent_contact);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record has been successfully created.');
                    window.location.href = 'student_record.php'; 
                  </script>";
        } else {
            echo "<script>
                    alert('An error occurred while inserting the record: " . addslashes($stmt->error) . "');
                    window.history.back(); 
                  </script>";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>
