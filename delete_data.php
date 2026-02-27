<?php
include 'koneksi.php';
$id = $_GET['id'] ?? '';
$type = $_GET['type'] ?? '';

$mapping = [
    'piano' => 'Piano Course', 'vocal' => 'Vocal Course', 'violin' => 'Violin Course',
    'instructor' => 'Instructor', 'student' => 'Student', 'grade' => 'Examination Grade'
];

if (isset($mapping[$type]) && !empty($id)) {
    $table = $mapping[$type];
    // Jika tipenya grade, hapus berdasarkan grade_id
    $pk = ($type == 'grade') ? 'grade_id' : 'id';
    mysqli_query($conn, "DELETE FROM `$table` WHERE `$pk` = '$id'");
}

header("Location: view_data.php?type=$type");