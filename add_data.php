<?php
include 'koneksi.php';
$type = $_GET['type'] ?? '';
$mapping = [
    'piano' => 'Piano Course', 
    'grade' => 'Student Examination Grade', 
    'student' => 'Student', 
    'instructor' => 'Instructor'
];
$table = $mapping[$type] ?? exit('Error');

if (isset($_POST['save'])) {
    $cols = []; $vals = [];
    foreach ($_POST as $k => $v) {
        if ($k != 'save') {
            $cols[] = "`$k`";
            $vals[] = "'" . mysqli_real_escape_string($conn, $v) . "'";
        }
    }
    $sql = "INSERT INTO `$table` (" . implode(',', $cols) . ") VALUES (" . implode(',', $vals) . ")";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_data.php?type=$type");
    } else {
        die("MySQL Error: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: white; padding: 50px; }
        .form-box { background: #1e293b; padding: 40px; border-radius: 20px; max-width: 550px; margin: auto; }
        .form-control { background: #0f172a; color: white; border: 1px solid #334155; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="form-box shadow-lg">
    <h4 class="mb-4 text-info">Add to <?php echo $table; ?></h4>
    <form method="POST">
        <?php if($type == 'grade'): ?>
            <input type="text" name="grade_id" class="form-control" placeholder="Grade ID (GRD0001)" required>
            <input type="text" name="student_id" class="form-control" placeholder="Student ID" required>
            <input type="text" name="Course_Type" class="form-control" placeholder="Course Type" required>
            <input type="number" name="Level" class="form-control" placeholder="Level" required>
            <input type="text" name="Grade" class="form-control" placeholder="Grade (A/B/C)" required>
        <?php elseif($type == 'piano'): ?>
            <input type="text" name="Course_ID" class="form-control" placeholder="Course ID" required>
            <input type="text" name="student_id" class="form-control" placeholder="Student ID" required>
            <input type="text" name="Instructor_id" class="form-control" placeholder="Instructor ID" required>
            <input type="text" name="classroom_id" class="form-control" placeholder="Classroom ID" required>
            <input type="text" name="course_Level" class="form-control" placeholder="Course Level" required>
            <input type="text" name="Course_Day" class="form-control" placeholder="Course Day" required>
        <?php else: ?>
            <?php $res = mysqli_query($conn, "SHOW COLUMNS FROM `$table` ");
                  while($f = mysqli_fetch_assoc($res)): if($f['Extra'] == 'auto_increment') continue; ?>
                    <input type="text" name="<?php echo $f['Field']; ?>" class="form-control" placeholder="<?php echo $f['Field']; ?>" required>
            <?php endwhile; ?>
        <?php endif; ?>
        <button type="submit" name="save" class="btn btn-info w-100 fw-bold">Register Data</button>
    </form>
</div>
</body>
</html>