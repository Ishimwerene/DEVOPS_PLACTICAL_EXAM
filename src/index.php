<?php
// index.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>New Vision - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Modern Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
      body {
          margin: 0;
          font-family: "Poppins", sans-serif;
          background: #f5f7fa;
          color: #333;
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
      }

      .container {
          text-align: center;
          background: #fff;
          padding: 40px 50px;
          border-radius: 12px;
          box-shadow: 0 8px 25px rgba(0,0,0,0.08);
          width: 350px;
      }

      h1 {
          font-weight: 600;
          margin-bottom: 20px;
          color: #2c3e50;
      }

      .menu a {
          display: block;
          margin: 12px 0;
          padding: 12px;
          background: #3498db;
          color: #fff;
          text-decoration: none;
          font-size: 15px;
          font-weight: 500;
          border-radius: 8px;
          transition: 0.3s ease;
      }

      .menu a:hover {
          background: #2980b9;
      }

      .footer {
          margin-top: 20px;
          font-size: 13px;
          color: #666;
      }
  </style>
</head>

<body>

<div class="container">
    <h1>ShareRide</h1>
    <p style="font-size: 14px; margin-bottom: 25px;">CODERWANDA</p>

    <div class="menu">
        <a href="registration.php">Register</a>
        <a href="login.php">Login</a>
    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> ShareRide Platform
    </div>
</div>

</body>
</html>
