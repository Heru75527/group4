<?php
include 'koneksi.php';
$id = $_GET['id']; $type = $_GET['type'];
$mapping = [
    'student' => 'Student', 'instructor' => 'Instructor', 'piano' => 'Piano Course',
    'vocal' => 'Vocal Course', 'violin' => 'Violin Course', 'grade' => 'Student Examination Grade',
    'classroom' => 'Classroom', 'schedule' => 'Course_Schedule'
];
$table = $mapping[$type];
$pk = mysqli_fetch_array(mysqli_query($conn, "SHOW COLUMNS FROM `$table` "))[0];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `$table` WHERE `$pk` = '$id'"));

if (isset($_POST['update'])) {
    $fields = [];
    foreach ($_POST as $key => $val) {
        if ($key != 'update') {
            $v = mysqli_real_escape_string($conn, $val);
            $fields[] = "`$key` = '$v'";
        }
    }
    $sql = "UPDATE `$table` SET " . implode(', ', $fields) . " WHERE `$pk` = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated Successfully!'); window.location='view.php?type=$type';</script>";
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
    <h3 class="mb-4 fw-bold">EDIT <?php echo str_replace('_', ' ', strtoupper($table)); ?></h3>
    <form method="POST">
        <?php foreach ($data as $col => $val): ?>
            <div class="mb-3">
                <label class="form-label small"><?php echo str_replace('_', ' ', strtoupper($col)); ?></label>
                <input type="text" name="<?php echo $col; ?>" value="<?php echo $val; ?>" class="form-control" <?php echo ($col == $pk) ? 'readonly' : ''; ?>>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="update" class="btn btn-info w-100 py-2 mt-3 shadow">UPDATE CHANGES</button>
        <a href="view.php?type=<?php echo $type; ?>" class="btn btn-link w-100 text-muted mt-2 text-decoration-none">Batal</a>
    </form>
</div>
</body>
</html>