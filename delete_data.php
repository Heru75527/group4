<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

$mapping = [
    'piano' => 'Piano Course', 
    'grade' => 'Student Examination Grade', 
    'student' => 'Student', 
    'instructor' => 'Instructor'
];

if (isset($mapping[$type]) && !empty($id)) {
    $table = $mapping[$type];
    // Tentukan kolom kunci (PK)
    if($type == 'grade') $pk = 'grade_id';
    elseif($type == 'piano') $pk = 'Course_ID';
    else $pk = 'id';

    mysqli_query($conn, "DELETE FROM `$table` WHERE `$pk` = '$id'");
}

header("Location: view_data.php?type=$type");