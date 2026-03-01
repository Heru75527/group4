<?php
include 'koneksi.php';

$id = $_GET['id'];
$type = $_GET['type'];

$mapping = [
    'student'    => 'Student',
    'grade'      => 'Student Examination Grade',
    'piano'      => 'Piano Course',
    'instructor' => 'Instructor',
    'vocal'      => 'Vocal Course',
    'violin'     => 'Violin Course',
    'classroom'  => 'Classroom',
    'schedule'   => 'Course_Schedule'
];

$table = $mapping[$type];


$res = mysqli_query($conn, "SHOW COLUMNS FROM `$table` ");
$col = mysqli_fetch_array($res);
$pk = $col[0];


$sql = "DELETE FROM `$table` WHERE `$pk` = '$id'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data Berhasil Dihapus'); window.location='view.php?type=$type';</script>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>