<?php
include 'database_conn.php'; // Database connection

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    $query = "DELETE FROM teachers WHERE teacher_id = '$teacher_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
header('Location: view_teachers.php'); // Redirect back to the teacher list
?>
