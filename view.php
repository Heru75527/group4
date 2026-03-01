<?php
include 'koneksi.php';
$type = $_GET['type'] ?? 'student';
$mapping = [
    'student' => 'Student', 'instructor' => 'Instructor', 'piano' => 'Piano Course',
    'vocal' => 'Vocal Course', 'violin' => 'Violin Course', 'grade' => 'Student Examination Grade',
    'classroom' => 'Classroom', 'schedule' => 'Course_Schedule'
];
$table = $mapping[$type] ?? 'Student';
$result = mysqli_query($conn, "SELECT * FROM `$table` ");
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container container-custom shadow-lg">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><?php echo str_replace('_', ' ', strtoupper($table)); ?></h2>
        <a href="add_data.php?type=<?php echo $type; ?>" class="btn btn-success px-4">+ ADD DATA</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <?php 
                    $fields = mysqli_fetch_fields($result);
                    foreach ($fields as $f) {
                       
                        echo "<th>" . str_replace('_', ' ', strtoupper($f->name)) . "</th>";
                    }
                    ?>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): $id = reset($row); ?>
                <tr>
                    <?php foreach($row as $d) echo "<td>$d</td>"; ?>
                    <<td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <?php if ($type == 'student'): ?>
                                <a href="student_grade.php?student_id=<?php echo $id; ?>" class="btn btn-sm btn-info shadow-sm">
                                    Grades
                                </a>
                            <?php endif; ?>

                            <a href="edit_data.php?id=<?php echo $id; ?>&type=<?php echo $type; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_data.php?id=<?php echo $id; ?>&type=<?php echo $type; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="dashboard.php" class="text-muted text-decoration-none small">← Back to Dashboard</a>
</div>
</body>
</html>