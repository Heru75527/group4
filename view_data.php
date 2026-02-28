<?php
include 'koneksi.php';

// Menangkap parameter dari URL
$type = $_GET['type'] ?? 'student';
$search = $_GET['search'] ?? '';

// Mapping menu ke nama tabel asli di database
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

$table = $mapping[$type] ?? 'Student';

// PERBAIKAN: Menggunakan backtick (`) untuk menangani nama tabel yang mengandung spasi
$sql = "SELECT * FROM `$table` ";

if (!empty($search)) {
    $s = mysqli_real_escape_string($conn, $search);
    // Logika pencarian sederhana (bisa dikembangkan sesuai kolom tabel)
    $sql .= " WHERE 1 "; 
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management System - <?php echo strtoupper($table); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root { 
            --accent: #00d2ff; 
            --bg-card: #1e293b; 
            --bg-body: #0f172a; 
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        body { 
            background-color: var(--bg-body); 
            color: var(--text-main); 
            padding: 40px 20px;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .data-container { 
            background: var(--bg-card); 
            border-radius: 20px; 
            padding: 35px; 
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .header-section {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 25px;
            margin-bottom: 30px;
        }

        .table { 
            color: #e2e8f0; 
            border-color: #334155;
        }

        .table thead th { 
            background: var(--accent); 
            color: #0f172a; 
            border: none; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 1px;
            font-weight: 800;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
            transition: 0.2s;
        }

        .btn-info-custom {
            background: var(--accent);
            border: none;
            color: #0f172a;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .btn-outline-danger-custom {
            border: 1px solid #ef4444;
            color: #ef4444;
            font-size: 0.8rem;
        }

        .btn-outline-danger-custom:hover {
            background: #ef4444;
            color: white;
        }

        .search-input {
            background: #0f172a !important;
            border: 1px solid #334155 !important;
            color: white !important;
        }

        .back-link {
            color: var(--text-dim);
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

<div class="container-fluid data-container">
    <div class="header-section d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold m-0 text-uppercase tracking-wider">
                <?php echo str_replace('_', ' ', $table); ?> Records
            </h2>
            <p class="text-secondary small mb-0">Academic Management System • Music School</p>
        </div>
        
        <form method="GET" class="d-flex gap-2 w-50">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <input type="text" name="search" class="form-control search-input" 
                   placeholder="Search entries..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-info-custom px-4" type="submit">SEARCH</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <?php 
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Mengambil nama kolom otomatis dari metadata hasil query
                        $fields = mysqli_fetch_fields($result);
                        foreach ($fields as $field) {
                            echo "<th>" . strtoupper(str_replace('_', ' ', $field->name)) . "</th>";
                        }
                        echo "<th class='text-center'>ACTIONS</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <?php foreach ($row as $data): ?>
                                <td><?php echo htmlspecialchars($data ?? '-'); ?></td>
                            <?php endforeach; ?>
                            
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <?php if ($type == 'student'): ?>
                                        <a href="student_grade.php?student_id=<?php echo $row['student_id']; ?>" 
                                           class="btn btn-sm btn-info-custom rounded">VIEW GRADES</a>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    // Ambil nilai kolom pertama sebagai ID primer untuk hapus
                                    $primary_id = reset($row); 
                                    ?>
                                    <a href="delete.php?id=<?php echo $primary_id; ?>&type=<?php echo $type; ?>" 
                                       class="btn btn-sm btn-outline-danger-custom rounded" 
                                       onclick="return confirm('Delete this record?')">DELETE</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="20" class="text-center py-5 text-secondary italic">
                            No data found in table "<?php echo $table; ?>".
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="dashboard.php" class="back-link small">← Back to Dashboard Portal</a>
    </div>
</div>

</body>
</html>
