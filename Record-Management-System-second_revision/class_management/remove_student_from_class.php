<?php
include("database_conn.php");

if (isset($_GET['remove_student_id'])) {
    $student_id = $_GET['remove_student_id'];
    $class_id = $_GET['class_id'];

    $query = "DELETE FROM student_class WHERE student_id = ? AND class_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $student_id, $class_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "Student removed from class successfully.";
    } else {
        echo "Error removing student from class.";
    }
}
?>
