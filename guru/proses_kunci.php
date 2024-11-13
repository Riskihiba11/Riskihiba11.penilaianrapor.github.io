<?php
session_start();
include '../db.php';

$student_id = $_GET['student_id'];
$subject_id = $_GET['subject_id']; 
$semester = $_GET['semester'];
$status = $_GET['status'];

// Cek apakah guru yang mengakses adalah pengajar mapel tersebut
$check_teacher = "SELECT * FROM subjects WHERE id = '$subject_id' AND teacher_id = '".$_SESSION['user_id']."'";
$result_teacher = $conn->query($check_teacher);

if($result_teacher->num_rows > 0) {
$query = "UPDATE grades SET status_kunci = '$status' 
          WHERE student_id = '$student_id' 
          AND subject_id = '$subject_id' 
          AND semester = '$semester'";
$result = $conn->query($query);

if($result) {
    header("Location: manage_grades.php");
} else {
    echo "<script>alert('Gagal mengubah status kunci!');
          window.location='manage_grades.php';</script>";
}
} else {
echo "<script>alert('Anda tidak memiliki akses!');
      window.location='manage_grades.php';</script>";
}
?>
