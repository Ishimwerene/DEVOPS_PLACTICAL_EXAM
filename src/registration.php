<?php
// registration.php
session_start();

$db_host = '25rp188411_db';
$db_user = 'root';
$db_pass = 'rootpassword';
$db_name = '25rp188411_shareride_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $gender    = trim($_POST['gender'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    if (!$firstname || !$lastname || !$email || !$password) {
        $errors[] = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM tbl_users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            $stmt->close();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tbl_users (user_firstname, user_lastname, user_gender, user_email, user_password) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $firstname, $lastname, $gender, $email, $hashed);
            if ($stmt->execute()) {
                $success = "Registration successful. You may <a href='login.php'>login</a> now.";
            } else {
                $errors[] = "Registration failed: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Register - ShareRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Modern font -->
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
          width: 380px;
          background: #fff;
          padding: 35px 40px;
          border-radius: 12px;
          box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
      }
      h1 {
          margin-bottom: 25px;
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
      input, select {
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
          background: #27ae60;
          color: #fff;
          border: none;
          border-radius: 8px;
          font-size: 15px;
          cursor: pointer;
          transition: 0.3s;
      }
      button:hover {
          background: #1e8449;
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
      .success-box {
          background: #e8f8f0;
          color: #1e8449;
          border-left: 4px solid #2ecc71;
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

    <h1>Create Account</h1>

    <?php if ($errors): ?>
        <div class="error-box">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success-box"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <label>First name:
            <input type="text" name="firstname" required>
        </label>

        <label>Last name:
            <input type="text" name="lastname" required>
        </label>

        <label>Gender:
            <select name="gender">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </label>

        <label>Email:
            <input type="email" name="email" required>
        </label>

        <label>Password:
            <input type="password" name="password" required>
        </label>

        <button type="submit">Register</button>
    </form>

    <div class="back">
        <a href="index.php">← Back to Home</a>
    </div>

</div>

</body>
</html>
