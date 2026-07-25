<?php
include('dbconnection.php');
session_start();

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM student WHERE Stu_email = '$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $student = $result->fetch_assoc();

    if (password_verify($password, $student['Stu_password'])) {
      $_SESSION['id'] = $student['id'];
      $_SESSION['name'] = $student['Stu_name'];
      header("location: index.php");
      exit();
    } else {
      $_SESSION['loginError'] = "Invalid password!";
    }
  } else {
    $_SESSION['loginError'] = "Email not found!";
  }
}

?>

<!-- Html Code -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/loginStyle.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    .reg_success {
      background-color: #baf0c6eb;
      color: #155724;
      padding: 1px;
      font-size: 0.9rem;
      border-radius: 5px;
    }

    .loginError {
      background-color: #f8d7da;
      color: #721c24;
      font-size: 0.89rem;
      padding: 2px;
      border-radius: 3px;
      text-align: center;
    }
  </style>
</head>

<body>
  <form action="login.php" method="post">
    <div class="login">
      <h2>Login to Driving School</h2>
      <?php
      if (isset($_SESSION['reg_success'])) {
        echo '<p class="reg_success">' . $_SESSION['reg_success'] . '</p>';
        session_unset();
      };
      if (isset($_SESSION['loginError'])) {
        echo '<div class="loginError">' . $_SESSION['loginError'] . '</div>';
        session_unset();
      }
      ?>
      <p value=""></p>
      <div>
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>

      <div>
        <input type="submit" name="login" value="Login">
        <p>Don't have an account? <a href="register.php"> Register here</a></p>
      </div>
    </div>
  </form>
</body>

</html>