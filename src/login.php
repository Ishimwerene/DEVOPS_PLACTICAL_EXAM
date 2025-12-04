<?php
// login.php
session_start();

$db_host = '25rp18841_exam_db';
$db_user = 'root';
$db_pass = 'rootpassword';
$db_name = '25rp18841_exam_shareride_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Redirect if fields are empty
    if (!$email || !$password) {
        header("Location: index.php?error=empty");
        exit;
    }

    // Prepare query
    $stmt = $conn->prepare("SELECT user_id, user_password, user_firstname 
                            FROM tbl_users 
                            WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Email exists?
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hash, $firstname);
        $stmt->fetch();

        // Password correct?
        if (password_verify($password, $hash)) {

            // SUCCESS
            $_SESSION['login_message'] = "Well logged in!!";
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_firstname'] = $firstname;

            header("Location: dashboard.php");
            exit;

        } else {
            // WRONG PASSWORD
            header("Location: index.php?error=invalid");
            exit;
        }
    } else {
        // EMAIL NOT FOUND
        header("Location: index.php?error=invalid");
        exit;
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login - ShareRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Modern Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
      body {
          margin: 0;
          font-family: "Poppins", sans-serif;
          background: #eef2f7;
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
      }
      .container {
          width: 360px;
          background: #fff;
          padding: 35px 40px;
          border-radius: 12px;
          box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
      }
      h1 {
          margin: 0 0 25px;
          text-align: center;
          font-weight: 600;
          color: #2c3e50;
      }
      label {
          display: block;
          margin-bottom: 12px;
          font-size: 14px;
          color: #34495e;
      }
      input {
          width: 100%;
          padding: 10px;
          margin-top: 5px;
          border: 1px solid #ccc;
          border-radius: 8px;
          font-size: 14px;
      }
      button {
          width: 100%;
          margin-top: 18px;
          padding: 12px;
          background: #3498db;
          color: #fff;
          border: none;
          border-radius: 8px;
          font-size: 15px;
          cursor: pointer;
          transition: 0.3s;
      }
      button:hover {
          background: #2980b9;
      }
      .error-box {
          background: #ffe6e6;
          color: #c0392b;
          border-left: 4px solid #e74c3c;
          padding: 10px 12px;
          margin-bottom: 15px;
          border-radius: 6px;
          font-size: 14px;
      }
      .back {
          margin-top: 15px;
          text-align: center;
      }
      .back a {
          color: #2980b9;
          text-decoration: none;
          font-size: 14px;
      }
      .back a:hover {
          text-decoration: underline;
      }
  </style>
</head>

<body>

<div class="container">
    <h1>Login</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Email:
            <input type="email" name="email" required>
        </label>

        <label>Password:
            <input type="password" name="password" required>
        </label>

        <button type="submit">Login</button>
    </form>

    <div class="back">
        <a href="index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>
