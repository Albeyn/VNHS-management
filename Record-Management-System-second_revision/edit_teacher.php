<?php
include 'database_conn.php'; // Database connection


if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $query = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id'";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $teacher_id = $_POST['teacher_id'];
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $contact_info = $_POST['contact_info'];

    $query = "UPDATE teachers SET name = '$name', subject = '$subject', contact_info = '$contact_info' WHERE teacher_id = '$teacher_id'";

    if (mysqli_query($conn, $query)) {
        header("Location: view_teachers.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="sidebar-navbar.css">
    <?php include 'navbar.php'?>
    <title>Edit Teacher</title>
    <style>
        /* General Body Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="hidden"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }

            form input,
            button {
                font-size: 14px;
            }
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
      <a href="student_record.php"
        >Student Records</a
      >
      <a href="view_teachers.php"
        >Teacher Records</a
      >
      <a href="settings.html">Settings</a>
      <a href="#logout" class="logout">Log out</a>
    </div>

   

    <div class="container">
        <h2>Edit Teacher Information</h2>
        <form method="POST" action="">
            <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $teacher['name']; ?>" required>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" value="<?php echo $teacher['subject']; ?>" required>

            <label for="contact_info">Contact Info:</label>
            <input type="text" id="contact_info" name="contact_info" value="<?php echo $teacher['contact_info']; ?>" required>

            <button type="submit" name="submit">Update Teacher</button>
        </form>
    </div>
    <script src="burger_menu.js"></script>
</body>

</html>