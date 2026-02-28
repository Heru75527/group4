<?php
include 'koneksi.php';
$type = $_GET['type'] ?? 'student';
$mapping = [
    'student' => 'Student', 'instructor' => 'Instructor', 'piano' => 'Piano Course',
    'vocal' => 'Vocal Course', 'violin' => 'Violin Course', 'grade' => 'Student Examination Grade',
    'classroom' => 'Classroom', 'schedule' => 'Course_Schedule'
];
$table = $mapping[$type];
$res_columns = mysqli_query($conn, "SHOW COLUMNS FROM `$table` ");

if (isset($_POST['submit'])) {
    $keys = []; $values = [];
    foreach ($_POST as $key => $val) {
        if ($key != 'submit') {
            $keys[] = "`$key`";
            $values[] = "'" . mysqli_real_escape_string($conn, $val) . "'";
        }
    }
    $sql = "INSERT INTO `$table` (" . implode(',', $keys) . ") VALUES (" . implode(',', $values) . ")";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data Saved!'); window.location='view.php?type=$type';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container-custom shadow-lg mx-auto" style="max-width: 550px;">
    <h3 class="mb-4 fw-bold">ADD <?php echo str_replace('_', ' ', strtoupper($table)); ?></h3>
    <form method="POST">
        <?php while ($col = mysqli_fetch_array($res_columns)): if ($col['Extra'] == 'auto_increment') continue; ?>
            <div class="mb-3">
                <label class="form-label small"><?php echo str_replace('_', ' ', strtoupper($col['Field'])); ?></label>
                <input type="text" name="<?php echo $col['Field']; ?>" class="form-control" placeholder="..." required>
            </div>
        <?php endwhile; ?>
        <button type="submit" name="submit" class="btn btn-info w-100 py-2 mt-3 shadow">SAVE DATA</button>
        <a href="view.php?type=<?php echo $type; ?>" class="btn btn-link w-100 text-muted mt-2 text-decoration-none">Cancel</a>
    </form>
</div>
</body>
</html>