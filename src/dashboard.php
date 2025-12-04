<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: #f4f6f9;
        }

        .navbar {
            background: #0d6efd;
            padding: 15px 25px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.15);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }

        .container {
            margin: 40px auto;
            width: 90%;
            max-width: 900px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .welcome {
            font-size: 26px;
            font-weight: bold;
            color: #333;
        }

        .section-title {
            margin-top: 30px;
            font-size: 20px;
            font-weight: 600;
            color: #444;
        }

        .card {
            background: #fafafa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 15px;
            border: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 15px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #0b5ed7;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">
            <strong>NEW VERSION Dashboard</strong>
        </div>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome">
            Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname']); ?> 👋
        </div>

        <p style="color:#666;">You are successfully logged in.</p>



    </div>

</body>
</html>
