<?php
include("database_conn.php");

if (isset($_POST['assign_student'])) {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];

    
    $check_query = "SELECT * FROM student_class WHERE student_id = ? AND class_id = ?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, 'ii', $student_id, $class_id);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "Student is already assigned to this class.";
    } else {
        
        $query = "INSERT INTO student_class (student_id, class_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $student_id, $class_id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Student successfully assigned to the class.";
        } else {
            echo "Error assigning student to class.";
        }
    }
}
?>
