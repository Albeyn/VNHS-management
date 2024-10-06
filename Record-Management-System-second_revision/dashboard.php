<?php
include("database_conn.php");


$sql = "SELECT COUNT(*) AS total_students FROM students";
$sql_teachers = "SELECT COUNT(*) AS total_teachers FROM teachers";

$result = $conn->query($sql);
$result_teachers = $conn->query($sql_teachers);

if ($result) {
  $row = $result->fetch_assoc();
  $total_students = $row['total_students'];
} else {
  $total_students = "N/A";
}


if ($result_teachers) {
  $row_teachers = $result_teachers->fetch_assoc();
  $total_teachers = $row_teachers['total_teachers'];
} else {
  $total_teachers = "N/A";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <link rel="stylesheet" href="dashboard_style.css" />
  <link rel="stylesheet" href="sidebar-navbar.css" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css"
    rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
  <?php include 'navbar.php'; ?>
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
    <a href="settings.php">Settings</a>
    <a href="#logout" class="logout">Log out</a>
  </div>

 
  <div class="content">
    <div class="welcome">
      <h1>Welcome, Ma'am Venice!</h1>
      <p>Role: Teacher</p>
      <p>Date: [Current Date]</p>
    </div>

    <div class="metrics">
      <div class="metric">Total Students: <?php echo $total_students; ?></div>
      <div class="metric">Total Teachers: <?php echo $total_teachers; ?></div>
      <div class="metric">Section: 30</div>
    </div>

    <div class="summary">
      <div class="events">
        <h2>Upcoming Events</h2>
        <ul>
          <li>Exam on Aug 30</li>
          <li>Parent Meeting Sep 3</li>
        </ul>
      </div>
    </div>

    <div class="quick-links">
      <h2>Quick Links</h2>
      <ul>
        <li><a href="student_record.html">Add New Record</a></li>
        <li><a href="#view-reports">View Reports</a></li>
        <li><a href="#manage-classes">Manage Students</a></li>
      </ul>
    </div>

    <div class="calendar">
      <h2>Calendar / Upcoming Events</h2>
      <div class="calendar-widget" id="calendar"></div>
    </div>

    <div class="messages">
      <h2>Recent Messages</h2>
      <ul>
        <li>Richomd: "Reminder about tomorrow's..."</li>
        <li>Ella: "Please review the attached..."</li>
      </ul>
    </div>

    <div class="announcements">
      <h2>System Announcements</h2>
      <ul>
        <li>"New feature added: Automated grading system"</li>
        <li>"Scheduled maintenance on Sep 1"</li>
      </ul>
    </div>
  </div>
  <script src="burger_menu.js"></script>
</body>

</html>