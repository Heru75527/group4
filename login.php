<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    if ($username == "admin" && $password == "admin123") {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Credentials. Access Denied.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Musical Academic Elite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #00d2ff;
            --dark-bg: #0f172a;
            --glass: rgba(30, 41, 59, 0.7);
        }

        body {
            background: radial-gradient(circle at top right, #1e293b, #0f172a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
            overflow: hidden;
        }

       
        .bg-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: var(--primary);
            filter: blur(150px);
            opacity: 0.1;
            z-index: -1;
            top: 10%;
            left: 10%;
        }

        .login-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px;
            border-radius: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .brand-logo {
            font-size: 2.5rem;
            margin-bottom: 5px;
            color: #fff;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .brand-sub {
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 3px;
            margin-bottom: 40px;
            display: block;
        }

        .form-label {
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
            text-align: left;
        }

        .form-control {
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid #334155;
            color: #fff;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .form-control:focus {
            background: rgba(15, 23, 42, 0.8);
            border-color: var(--primary);
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.2);
            color: #fff;
        }

        .btn-login {
            background: var(--primary);
            color: #0f172a;
            font-weight: 800;
            padding: 15px;
            border-radius: 12px;
            width: 100%;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 210, 255, 0.3);
            background: #00b8e6;
        }

        .footer-text {
            margin-top: 30px;
            color: #64748b;
            font-size: 0.8rem;
        }

        .error-msg {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

    <div class="login-card">
        <div class="brand-logo">🏛️ MUSICAL</div>
        <span class="brand-sub">Management System</span>

        <?php if(isset($error)): ?>
            <div class="error-msg"> <?php echo $error; ?> </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label">Administrative ID</label>
                <input type="text" name="username" class="form-control" placeholder="Enter username..." required>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label">Access Key</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" name="login" class="btn btn-login">Authorize Access</button>
        </form>

        <div class="footer-text">
            &copy; 2026 Musical Academic Elite. <br> Protected by Enterprise Encryption.
        </div>
    </div>

</body>
</html>