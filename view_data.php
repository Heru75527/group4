<?php
include 'koneksi.php';

$type = $_GET['type'] ?? 'student';
$search = $_GET['search'] ?? '';

$mapping = [
    'student'    => 'Student',
    'grade'      => 'Student Examination Grade',
    'piano'      => 'Piano Course',
    'instructor' => 'Instructor'
];

$table = $mapping[$type] ?? 'Student';

// --- LOGIKA JOIN TABEL STUDENT & GRADE ---
if ($type == 'student') {
    $s = mysqli_real_escape_string($conn, $search);
    
    // Query menggabungkan data Student dengan Grade berdasarkan student_id
    $sql = "SELECT 
                s.student_id, 
                s.Name, 
                s.Address, 
                s.Age, 
                g.Course_Type, 
                g.Level, 
                g.Grade
            FROM `Student` s
            LEFT JOIN `Student Examination Grade` g ON s.student_id = g.student_id";
    
    if (!empty($search)) {
        $sql .= " WHERE s.Name LIKE '%$s%' OR s.student_id LIKE '%$s%'";
    }
} else {
    $sql = "SELECT * FROM `$table` ";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Student Academic Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --accent: #00d2ff; --bg-card: #1e293b; --bg-body: #0f172a; }
        body { background-color: var(--bg-body); color: #f8fafc; padding: 40px; }
        .data-container { background: var(--bg-card); border-radius: 15px; padding: 30px; border: 1px solid rgba(255,255,255,0.1); }
        .table { color: #e2e8f0; }
        .table thead th { background: var(--accent); color: #0f172a; border: none; }
        .badge-grade { background: #10b981; color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; }
        .btn-action { font-size: 0.8rem; font-weight: bold; }
    </style>
</head>
<body>

<div class="container-fluid data-container shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold m-0 text-uppercase">Student Academic List</h2>
            <p class="text-secondary small">Data Terintegrasi Profil & Nilai Ujian</p>
        </div>
        <form method="GET" class="d-flex gap-2 w-50">
            <input type="hidden" name="type" value="student">
            <input type="text" name="search" class="form-control bg-dark text-white border-secondary" placeholder="Cari Nama atau ID Siswa..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-info" type="submit">Search</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID SISWA</th>
                    <th>NAMA</th>
                    <th>UMUR</th>
                    <th>ALAMAT</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                       <tr>
                            <td><?php echo $row['student_id']; ?></td>
                            <td class="fw-bold"><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Age']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td class="text-center">
                        <div class="btn-group">
                    <a href="student_grade.php?student_id=<?php echo $row['student_id']; ?>&type=student" 
                        class="btn btn-sm btn-info text-white fw-bold">View Grades</a>
            
                    <a href="delete.php?id=<?php echo $row['student_id']; ?>&type=student" 
                        class="btn btn-sm btn-outline-danger" 
                        onclick="return confirm('Hapus siswa?')">Delete</a>
                        </div>
                    </td>
                </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center py-5 text-secondary">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <a href="dashboard.php" class="text-secondary text-decoration-none small">← Kembali ke Dashboard</a>
</div>

</body>
</html>