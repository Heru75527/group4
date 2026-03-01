<?php
include 'koneksi.php';


$menus = [
    ['type' => 'student', 'label' => 'Student List', 'icon' => '👨‍🎓', 'desc' => 'Manage student profiles'],
    ['type' => 'instructor', 'label' => 'Instructor', 'icon' => '👨‍🏫', 'desc' => 'Manage music teachers'],
    ['type' => 'piano', 'label' => 'Piano Course', 'icon' => '🎹', 'desc' => 'Piano lesson records'],
    ['type' => 'vocal', 'label' => 'Vocal Course', 'icon' => '🎤', 'desc' => 'Vocal lesson records'],
    ['type' => 'violin', 'label' => 'Violin Course', 'icon' => '🎻', 'desc' => 'Violin lesson records'],
    ['type' => 'classroom', 'label' => 'Classroom', 'icon' => '🏫', 'desc' => 'Room assignments'],
    ['type' => 'schedule', 'label' => 'Schedule', 'icon' => '📅', 'desc' => 'Course time slots']
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Academic Music School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --accent: #00d2ff; --bg-card: #1e293b; --bg-body: #0f172a; }
        body { background-color: var(--bg-body); color: #f8fafc; font-family: 'Inter', sans-serif; }
        
        .hero-section { padding: 60px 0; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        .menu-card { 
            background: var(--bg-card); 
            border: 1px solid rgba(255,255,255,0.05); 
            border-radius: 20px; 
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: block;
            height: 100%;
            padding: 30px;
        }
        
        .menu-card:hover { 
            transform: translateY(-10px); 
            background: rgba(255,255,255,0.05); 
            border-color: var(--accent);
            color: var(--accent);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            background: rgba(0, 210, 255, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<section class="hero-section mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Music School <span style="color: var(--accent);">Portal</span></h1>
        <p class="lead text-secondary">Academic Management System - Group 4</p>
    </div>
</section>

<div class="container pb-5">
    <div class="row g-4">
        <?php foreach ($menus as $menu): ?>
        <div class="col-md-3">
            <a href="view.php?type=<?php echo $menu['type']; ?>" class="menu-card shadow-sm">
                <div class="icon-circle">
                    <?php echo $menu['icon']; ?>
                </div>
                <h4 class="fw-bold"><?php echo $menu['label']; ?></h4>
                <p class="text-secondary small mb-0"><?php echo $menu['desc']; ?></p>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="text-center py-4 border-top border-secondary opacity-50 mt-5">
    <small>&copy; 2026 Academic Music School - All Records Secured</small>
</footer>

</body>
</html>