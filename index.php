<?php
session_start();
include('dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driving School</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- Google Font: Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <style>
    .btn-logout{
      width: 130px;
      text-align: center;
    }
    .welcome{
      display: block;
      width: auto;
      `font-weight: 420;
    }

    #footer{
      width: full;
    }


  </style>
</head>

<body>
  <div class="navigation">
    <div class="logo">
      Driving School
    </div>
    <div class="naviLinks">
      <ul class="nav_list">
        <li><a class="ho" href="#heroSection">Home</a></li>
        <li><a class="ho" href="#bodyContact">Services</a></li>
        <li><a class="ho" href="#footer">Contact us</a></li>
      </ul>
    </div>
    <?php
    if (isset($_SESSION['name'])) {
      echo '<p class="welcome">welcome,' . " " . $_SESSION['name'] . '</p>
            <div class="nav-btn">
              <a href="logout.php" name= "logout" class="btn-logout">Log Out</a>
            </div>';
    } else {
      echo '<div class="nav-btn">
              <a href="login.php" class="btn-login">Login</a>
              <a href="register.php" class="btn-reg">Register</a>
            </div>';
    }
    ?>
  </div>

  <div class="nav-spacer" aria-hidden="true"></div>
  <div id="wrapper">
    <div id="subWrapper">
      <section id="heroSection">
        <div class="description">
          <h1>Drive with confidence,lern<br>with us!</h1>
          <p class="lead">Practice road signs, read driving rules, take mock quizzes,<br>and complete a basic
            medical self-check — all online.</p>

          <?php
          if (isset($_SESSION['name'])) {
            echo '<div class="heroLinks">
                <li class="btn1"><a href="roadSign.html">Start Tutorial</a></li>
                <li class="btn2"><a href="quiz.php">Take Quiz</a></li>
            </div>';
          } else {
            echo '<div class="heroLinks">
              <li class="btn1"><a href="login.php">Login to Start</a></li>
              <li class="btn2"><a href="register.php">Register Now</a></li>
              </div>';
          }
          ?>
        </div>
        <figure class="heroImage" aria-hidden="false">
          <img src="img/dr_car.png" alt="image1">
        </figure>
      </section>
      <div id="bodyContact">
        <h3>Our Services</h3>
        <p style="color:rgba(47, 45, 45, 0.956); font-size:1rem; text-align:center;">Comprehensive driving
          lessons designed to make you a safe and confident driver</p>
        <div id="ourService">
          <div class="s1">
            <div class="cardImg"><img src="img/tu.jpg" alt="s1Image"></div>
            <h4>📚 Tutorial</h4>
            <p style="min-height: 70px;">Interactive exercises for road signs and driving scenarios. Learn at your own pace with
              step-by-step guides.</p>

            <?php
            if (isset($_SESSION['name'])) {
              echo '<div><a href="roadSign.html">→ Start Learning</a></div>';
            } else {
              echo '<div><a href="login.php">→ Login to Access</a></div>';
            }
            ?>

          </div>
          <div class="s2">
            <div class="cardImg"><img src="img/exam.png" alt="s1Image"></div>
            <h4>📝 Road Signs Quiz</h4>
            <p style="min-height: 70px;">A traffic sign quiz testing knowledge of common road signs and their meanings.</p>

            <?php
            if (isset($_SESSION['name'])) {
              echo '<div><a href="quiz.php">→ Take Quiz paper</a></div>';
            } else {
              echo '<div><a href="login.php">→ Login to Access</a></div>';
            }
            ?>

          </div>
          <div class="s3">
            <div class="cardImg"><img src="img/medical.png" alt="s1Image"></div>
            <h4>🏥 Online Medical Check</h4>
            <p style="min-height: 70px;">Online self-assessment to help you prepare for required medical
              checks.</p>

            <?php
            if (isset($_SESSION['name'])) {
              echo '<div><a href="medical.php">→ Start Assessment</a></div>';
            } else {
              echo '<div><a href="login.php">→ Login to Access</a></div>';
            }
            ?>

          </div>
        </div>
      </div>
      <div id="footer">
        <div id="footer1">
          <div class="footer-logo">
            <span>Driving School</span>
            <p>This is a training website created for<br> educational purposes only.</p>
          </div>
          <div class="ContactUs">
            <h5>Our Services</h5>
            <li><a href="">> Tutorial</a></li>
            <li><a href="">> Exam Papers</a></li>
            <li><a href="">> Online Medical Check</a></li>
          </div>
          <div class="ContactUs">
            <h5>Quick Links</h5>
            <li><a href="#heroSection">> Home</a></li>
            <li><a href="#bodyContact">> Our Services</a></li>
            <li><a href="#footer">> Contact us</a></li>
          </div>
          <div class="ContactUs" style="color: #aaa;  line-height: 2.3em;">
            <h5 style="color: white; ">Contact Us</h5>
            <li>📧 thavinduharshana53@gmail.comm</li>
            <li>☎️ 075 202 5500</li>
            <li>📍123 Kandy Road, Mawathagama City</li>
          </div>
        </div>
        <div class="copyright">
          <p>&copy; 2025 Driving School System. All rights reserved | Study materials for driver education</p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>