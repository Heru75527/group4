<?php
include 'koneksi.php';
$type = $_GET['type'] ?? '';
$mapping = [
    'piano' => 'Piano Course', 'vocal' => 'Vocal Course', 'violin' => 'Violin Course',
    'instructor' => 'Instructor', 'student' => 'Student', 'classroom' => 'Classroom',
    'grade' => 'Examination Grade'
];
$table = $mapping[$type] ?? exit('Resource Not Found');

// LOGIKA KHUSUS UNTUK GRADE (Agar data muncul dan bisa di-manage)
if ($type == 'grade') {
    // Kita JOIN dengan tabel Student untuk mendapatkan nama lengkap siswa
    $query = "SELECT g.grade_id, s.name AS STUDENT_NAME, g.Course_Type, g.Level, g.Grade 
              FROM `$table` g 
              LEFT JOIN Student s ON g.student_id = s.id";
} else {
    $query = "SELECT * FROM `$table` ";
}

$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $table; ?> Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #fff; padding: 60px 30px; }
        .data-container { background: #1e293b; border-radius: 24px; padding: 45px; border: 1px solid rgba(255,255,255,0.05); }
        .table { color: #e2e8f0; vertical-align: middle; }
        .table thead th { background: #00d2ff; color: #0f172a; font-weight: 800; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; padding: 15px; border: none; }
        .btn-gold { background: #00d2ff; color: #0f172a; font-weight: 800; border: none; padding: 10px 25px; border-radius: 12px; transition: 0.3s; }
    </style>
</head>
<body>
<div class="container-fluid data-container shadow-2xl">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h3 class="fw-bold m-0"><?php echo $table; ?> Archives</h3>
            <p class="text-secondary small m-0">Menampilkan data resmi dari Departemen Akademik.</p>
        </div>
        <div>
            <a href="add_data.php?type=<?php echo $type; ?>" class="btn btn-gold">+ Add New Record</a>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm ms-3">Back to Hall</a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php if($result) while($f = mysqli_fetch_field($result)) echo "<th>".strtoupper($f->name)."</th>"; ?>
                    <th class="text-center">MANAGE</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): 
                    while($row = mysqli_fetch_assoc($result)): 
                        // Deteksi otomatis Primary Key (grade_id untuk Grade, id untuk lainnya)
                        $pk_value = $row['grade_id'] ?? $row['id'] ?? '';
                ?>
                    <tr>
                        <?php foreach($row as $v) echo "<td>$v</td>"; ?>
                        <td class="text-center">
                            <a href="delete_data.php?id=<?php echo $pk_value; ?>&type=<?php echo $type; ?>" 
                               class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Hapus data ini?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; else: ?>
                    <tr><td colspan="10" class="text-center py-5 text-muted small">The archives are currently empty.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>