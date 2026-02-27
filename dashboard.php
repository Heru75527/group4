<?php 
session_start();
include 'koneksi.php'; 
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Musical Academic | Elite Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bg-body: #0f172a; --bg-sidebar: #1e293b; --accent: #00d2ff; --glass: rgba(255, 255, 255, 0.03); }
        body { background-color: var(--bg-body); color: #f8fafc; font-family: 'Inter', sans-serif; }
        .sidebar { width: 280px; height: 100vh; background: var(--bg-sidebar); position: fixed; display: flex; flex-direction: column; border-right: 1px solid rgba(255,255,255,0.05); }
        .brand { padding: 40px 30px; border-bottom: 2px solid var(--accent); }
        .nav-header { font-size: 0.7rem; color: #64748b; padding: 30px 30px 10px; font-weight: 800; text-transform: uppercase; }
        .nav-link { color: #94a3b8; padding: 12px 30px; display: block; text-decoration: none; transition: 0.3s; font-weight: 500; }
        .nav-link:hover, .nav-link.active { color: #fff; background: var(--glass); border-right: 4px solid var(--accent); }
        .main-content { margin-left: 280px; padding: 60px; }
        .academic-card { background: var(--glass); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 30px; transition: 0.4s; }
        .icon-box { width: 50px; height: 50px; background: rgba(0,210,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 20px; color: var(--accent); }
    </style>
</head>
<body>

<div class="sidebar shadow-lg">
    <div class="brand">
        <h4>MUSICAL ACADEMY</h4>
        <small>Management System</small>
    </div>
    <div class="flex-grow-1">
        <div class="nav-header">Academic Overview</div>
        <a href="dashboard.php" class="nav-link active">🏛️ Grand Hall Dashboard</a>
        <div class="nav-header">Departments</div>
        <a href="view_data.php?type=piano" class="nav-link">🎹 Piano Virtuosos</a>
        <a href="view_data.php?type=vocal" class="nav-link">🎤 Vocal Ensemble</a>
        <a href="view_data.php?type=violin" class="nav-link">🎻 Violin Symphony</a>
        <div class="nav-header">Administration</div>
        <a href="view_data.php?type=grade" class="nav-link">📝 Examination Grade</a>
        <a href="view_data.php?type=instructor" class="nav-link">👨‍🏫 Faculty Members</a>
        <a href="view_data.php?type=student" class="nav-link">🎓 Student Registry</a>
    </div>
    <div class="p-4 border-top border-dark">
        <a href="logout.php" class="nav-link text-danger fw-bold p-0">🚪 System Logout</a>
    </div>
</div>

<div class="main-content">
    <h1 class="fw-bold">Institutional Overview</h1>
    <div class="row g-4 mt-4">
        <?php
        $stats = [['Student', 'student', '🎓'], ['Instructor', 'instructor', '👨‍🏫'], ['Exam Grade', 'grade', '📝']];
        foreach ($stats as $s) {
            $table = ($s[1] == 'grade') ? 'Examination Grade' : $s[0];
            $res = mysqli_query($conn, "SELECT COUNT(*) as total FROM `$table` ");
            $count = ($res) ? mysqli_fetch_assoc($res)['total'] : 0;
            echo "
            <div class='col-md-4'>
                <div class='academic-card shadow-sm'>
                    <div class='icon-box'>{$s[2]}</div>
                    <h6 class='text-secondary small fw-bold'>TOTAL {$s[0]}</h6>
                    <h2 class='fw-bold mb-0'>$count</h2>
                </div>
            </div>";
        }
        ?>
    </div>
</div>
</body>
</html>