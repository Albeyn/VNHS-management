<?php
include("database_conn.php");

// Check if student_id is provided
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Prepare the SQL query to delete the student's record
    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        $message = "Student record deleted successfully!";
        $message_class = "success";
    } else {
        $message = "Error deleting record: " . $conn->error;
        $message_class = "error";
    }

    $stmt->close();
    $conn->close();
    header("Location: edit_student.php?message=" . urlencode($message) . "&message_class=" . urlencode($message_class));
    exit;
    
} else {
    echo "No student ID provided.";
}
?>
