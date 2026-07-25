<?php
include("dbconnection.php");
session_start();

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hash_password = password_hash($password, PASSWORD_DEFAULT);

  $checkEmail = "SELECT Stu_email FROM student WHERE stu_email='$email'";
  $emailResult = mysqli_query($conn, $checkEmail);

  if (mysqli_num_rows($emailResult) > 0) {
    $_SESSION['reg-failed'] = "Email already registered!";
  } else {
    $sql = "INSERT INTO student(Stu_name, Stu_email, Stu_password) VALUES('$name', '$email', '$hash_password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      header("location: login.php");
      $_SESSION['reg_success'] = "Registration successful! Please login.";
      exit();
    } else {
      echo "Error Inserting Data: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>register</title>
  <link rel="stylesheet" href="css/register.css">

  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <div class="register">
    <h2>Create Account</h2>
    <?php 
      if(isset($_SESSION['reg-failed'])){
        echo '<div class="reg_failed">'. $_SESSION['reg-failed'].'</div>';
        session_unset();
      }
    ?>
    <form action="register.php" method="post">
      <div>
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Enter your full name" required>
      </div>

      <div>
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>

      <div>
        <label>Password</label>
        <input type="password" name="password" placeholder="Create a password" required>
      </div>


      <div>
        <input type="submit" name="submit" value="Register">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>

    </form>
  </div>
</body>

</html>