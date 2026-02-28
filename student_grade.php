<?php
include 'koneksi.php';

$student_id = $_GET['student_id'] ?? '';

// Ambil info nama siswa
$student_info = mysqli_query($conn, "SELECT Name FROM Student WHERE student_id = '$student_id'");
$s_name = mysqli_fetch_assoc($student_info)['Name'];

// Ambil data nilai dari tabel Student Examination Grade
$query = "SELECT * FROM `Student Examination Grade` WHERE student_id = '$student_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grades - <?php echo $s_name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: white; padding: 50px; }
        .grade-card { background: #1e293b; border-radius: 20px; padding: 40px; border: 1px solid #334155; }
        .badge-grade { background: #00d2ff; color: #0f172a; padding: 10px 20px; border-radius: 8px; font-size: 1.5rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="grade-card shadow-lg text-center">
        <h4 class="text-secondary text-uppercase small mb-1">Examination Report</h4>
        <h1 class="fw-bold mb-4"><?php echo $s_name; ?></h1>
        <hr class="border-secondary mb-4">

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($grade = mysqli_fetch_assoc($result)): ?>
                <div class="row align-items-center py-3">
                    <div class="col-md-4 text-start">
                        <h5 class="mb-0"><?php echo $grade['Course_Type']; ?></h5>
                        <small class="text-secondary">Level <?php echo $grade['Level']; ?></small>
                    </div>
                    <div class="col-md-4">
                        <span class="text-secondary small">Final Result:</span><br><br>
                        <span class="badge-grade"><?php echo $grade['Grade']; ?></span>
                    </div>
                    <div class="col-md-4 text-end">
                        <small class="text-secondary italic">Exam ID: <?php echo $grade['grade_id']; ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="py-5">
                <p class="text-secondary">Siswa ini belum memiliki riwayat ujian.</p>
                <a href="add_grade.php?student_id=<?php echo $student_id; ?>" class="btn btn-outline-info">+ Add First Grade</a>
            </div>
        <?php endif; ?>

        <div class="mt-5">
            <a href="view_data.php?type=student" class="text-info text-decoration-none">← Kembali ke Student List</a>
        </div>
    </div>
</div>

</body>
</html>