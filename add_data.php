<?php
include 'koneksi.php';
$type = $_GET['type'] ?? '';
$mapping = [
    'piano' => 'Piano Course', 'vocal' => 'Vocal Course', 'violin' => 'Violin Course',
    'instructor' => 'Instructor', 'student' => 'Student', 'grade' => 'Examination Grade'
];
$table = $mapping[$type] ?? exit('Resource Not Found');

if (isset($_POST['save'])) {
    $cols = []; $vals = [];
    foreach ($_POST as $k => $v) {
        if ($k != 'save') {
            $cols[] = "`$k`";
            $vals[] = "'" . mysqli_real_escape_string($conn, $v) . "'";
        }
    }
    $query = "INSERT INTO `$table` (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ")";
    mysqli_query($conn, $query);
    header("Location: view_data.php?type=$type");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Add Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #fff; padding: 60px; }
        .form-box { background: #1e293b; padding: 40px; border-radius: 20px; max-width: 500px; margin: auto; }
        .form-control { background: #0f172a; border: 1px solid #334155; color: #fff; }
    </style>
</head>
<body>
<div class="form-box shadow-lg">
    <h4 class="mb-4 text-info">Add New <?php echo $table; ?></h4>
    <form method="POST">
        <?php if($type == 'grade'): ?>
            <div class="mb-3">
                <label class="small text-secondary">STUDENT NAME</label>
                <select name="student_id" class="form-control" required>
                    <?php 
                    $students = mysqli_query($conn, "SELECT id, name FROM Student");
                    while($s = mysqli_fetch_assoc($students)) echo "<option value='{$s['id']}'>{$s['name']}</option>";
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="small text-secondary">COURSE TYPE</label>
                <input type="text" name="Course_Type" class="form-control" placeholder="Piano/Vocal/Violin" required>
            </div>
            <div class="mb-3">
                <label class="small text-secondary">LEVEL</label>
                <input type="number" name="Level" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="small text-secondary">GRADE</label>
                <input type="text" name="Grade" class="form-control" placeholder="A/B/C" required>
            </div>
        <?php else: 
            $fields = mysqli_query($conn, "SHOW COLUMNS FROM `$table` ");
            while($f = mysqli_fetch_assoc($fields)): if($f['Extra'] == 'auto_increment') continue; ?>
                <div class="mb-3">
                    <label class="small text-secondary"><?php echo strtoupper($f['Field']); ?></label>
                    <input type="text" name="<?php echo $f['Field']; ?>" class="form-control" required>
                </div>
        <?php endwhile; endif; ?>
        <button type="submit" name="save" class="btn btn-info w-100 mt-3 fw-bold">Save Record</button>
    </form>
</div>
</body>
</html>