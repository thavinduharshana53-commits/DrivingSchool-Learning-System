<?php
include("dbconnection.php");
session_start();

//check user is log in
if (!isset($_SESSION['id'])) {
  header("location: login.php");
  exit();
}

$best_score = 0;

if (isset($_POST['submit_quiz'])) {
  $score = 0;
  $totQustions = 10;

  $correct_answer = array(
    'qustion1' => 'a',
    'qustion2' => 'c',
    'qustion3' => 'b',
    'qustion4' => 'c',
    'qustion5' => 'b',
    'qustion6' => 'd',
    'qustion7' => 'b',
    'qustion8' => 'c',
    'qustion9' => 'a',
    'qustion10' => 'b',
  );

  foreach ($correct_answer as $key => $value) {
    if (isset($_POST[$key]) && $_POST[$key] == $value) {
      $score++;
    }
  }


  $user_id = $_SESSION['id'];
  $activity_type = 'tutorial';
  $max_score = $totQustions;

  //save data into user prossess table
  $sql = "INSERT INTO user_progress(user_id, activity_type, score, max_score) VALUES('$user_id', '$activity_type', '$score', ' $max_score')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    $_SESSION['complete'] = "Quiz completed! Your score: $score / $totQustions";
    // Update best score if current score is higher
    if ($score > $best_score) {
      $best_score = $score;
    }
  } else {
    echo "Error saving progress: " . mysqli_error($conn);
  }
}

//find best score
$user_id = $_SESSION['id'];

$bestScore_sql = "SELECT MAX(score) AS best_score FROM user_progress  WHERE user_id = '$user_id' AND activity_type ='tutorial'";
$bestResult = mysqli_query($conn, $bestScore_sql);

if ($bestResult) {
  $best_row = $bestResult->fetch_assoc();
  $best_score = $best_row['best_score'];
}

if(isset($_POST["clear_answer"])){
  unset($_SESSION['complete']);
  
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Road Signs Quiz</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/quiz_style.css">
  <style>
    .complete {
      background-color: #baf0c6eb;
      color: #155724;
      padding: 10px;
      font-size: 1.1rem;
      font-weight: 550;
      border-radius: 5px;
      text-align: center;
    }

    .btn1, .btn2 {
      padding: 12px;
      width: 180px;
      font-size: 1.2rem;
      background-color: #0077b6;
      color: whitesmoke;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      border: 1px solid #0077b6;
    }

    .btn2 {
      background-color: #6c757d;
      color: white;
      font-size: 1.1rem;
      width: 140px;
      margin-left: 40px;
      border: none;
    }

    .btn1:hover {
      background-color: #014468ff;
    }

    .btn2:hover {
      background-color: #43494f;
    }
  </style>
</head>


<body>
  <div class="quiz">
    <div class="title">
      <h1>Road Signs Quiz</h1>
      <p>Study the road signs below and test your knowledge with the quiz. Select the correct meaning for each sign.</p>
      <?php
      if (isset($_SESSION['complete'])) {
        echo "<div class='complete'>" . $_SESSION['complete'] . "</div>";
        unset($_SESSION['complete']);
      }
      ?>
    </div>

    <div class="score">
      <h3>Your Best Score:
        <?php if (isset($best_score)) {
          echo $best_score . '/ 10';
        } else {
          echo "<span style='color: #f94352ff';>Not attempted yet</span>";
        }
        ?></h3>
      <p>Try to beat your best score!</p>
    </div>

    <form action="quiz.php" method="post">
      <div class="quiz_container">
        <p>Select your answers. Choose the correct answer and press submit button.</p>
        </p>

        <div class="qustion_card">
          <h3>1. What does this sign mean?</h3>
          <div class="qustion">
            <img src="img/Priority_signs/LK_road_sign_PRS-01.svg">
            <div class="answers">
              <input type="radio" name="qustion1" value="a">Stop and give priority<br>
              <input type="radio" name="qustion1" value="b" required>Give Way<br>
              <input type="radio" name="qustion1" value="c">No Entry<br>
              <input type="radio" name="qustion1" value="d">Speed limit ends
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>2. What should the driver do?</h3>
          <div class="qustion">
            <img src="img/Mandatory signs/Vienna_Convention_road_sign_D1b-V2-1.svg">
            <div class="answers">
              <input type="radio" name="qustion2" value="a" required>Turn right<br>
              <input type="radio" name="qustion2" value="b">Go straight<br>
              <input type="radio" name="qustion2" value="c">Turn left priority<br>
              <input type="radio" name="qustion2" value="d">Stop
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>3. This sign indicates?</h3>
          <div class="qustion">
            <img src="img/Regulatory signs/LK_road_sign_PHS-01.svg">
            <div class="answers">
              <input type="radio" name="qustion3" value="a" required>No Parking<br>
              <input type="radio" name="qustion3" value="b">No Entry<br>
              <input type="radio" name="qustion3" value="c">Stop<br>
              <input type="radio" name="qustion3" value="d">Road Closed
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>4. What does this warning sign mean?</h3>
          <div class="qustion">
            <img src="img/warning img/ID_Rambu_peringatan_6a.svg">
            <div class="answers">
              <input type="radio" name="qustion4" value="a" required>School ahead<br>
              <input type="radio" name="qustion4" value="b">Hospital ahead<br>
              <input type="radio" name="qustion4" value="c">Pedestrian crossing ahead<br>
              <input type="radio" name="qustion4" value="d">Road works ahead
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>5. What restriction does this sign show?</h3>
          <div class="qustion">
            <img src="img/Restrictive signs/LK_road_sign_RSS-02 (1).svg">
            <div class="answers">
              <input type="radio" name="qustion5" value="a" required>Width limit<br>
              <input type="radio" name="qustion5" value="b">Height limit<br>
              <input type="radio" name="qustion5" value="c">Speed limit<br>
              <input type="radio" name="qustion5" value="d">Weight limit
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>6. This sign means?</h3>
          <div class="qustion">
            <img src="img/Priority_signs/Vienna_Convention_road_sign_B1-V1.svg">
            <div class="answers">
              <input type="radio" name="qustion6" value="a" required>Stop always<br>
              <input type="radio" name="qustion6" value="b">No overtaking<br>
              <input type="radio" name="qustion6" value="c">Mandatory
              turn<br>
              <input type="radio" name="qustion6" value="d">Give way to other vehicles<br>
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>7. What danger is warned here?</h3>
          <div class="qustion">
            <img src="img/warning img/Jalan_licin.png">
            <div class="answers">
              <input type="radio" name="qustion7" value="a" required>Falling rocks<br>
              <input type="radio" name="qustion7" value="b">Slippery road<br>
              <input type="radio" name="qustion7" value="c">Steep descent<br>
              <input type="radio" name="qustion7" value="d">Narrow road<br>
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>8. This sign prohibits?</h3>
          <div class="qustion">
            <img src="img/Regulatory signs/Vienna_Convention_road_sign_C12-V1-LHT.svg">
            <div class="answers">
              <input type="radio" name="qustion8" value="a" required>Left turn<br>
              <input type="radio" name="qustion8" value="b">Right turn<br>
              <input type="radio" name="qustion8" value="c">U-turn<br>
              <input type="radio" name="qustion8" value="d">Overtaking
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>9. What does this sign indicate?</h3>
          <div class="qustion">
            <img src="img/Mandatory signs/Vienna_Convention_road_sign_D3b-V1-LHT.svg">
            <div class="answers">
              <input type="radio" name="qustion9" value="a" required>Roundabout compulsory<br>
              <input type="radio" name="qustion9" value="b">No entry<br>
              <input type="radio" name="qustion9" value="c">Warning only<br>
              <input type="radio" name="qustion9" value="d">Speed limit
            </div>
          </div>
        </div>

        <div class="qustion_card">
          <h3>10. This sign warns about?</h3>
          <div class="qustion">
            <img src="img/warning img/Vienna_Convention_road_sign_Ab-16-V1-LHT.svg">
            <div class="answers">
              <input type="radio" name="qustion10" value="a" required>Hospital<br>
              <input type="radio" name="qustion10" value="b">Road works ahead<br>
              <input type="radio" name="qustion10" value="c">Pedestrian crossing<br>
              <input type="radio" name="qustion10" value="d">Level crossing
            </div>
          </div>
        </div>
        <div class="btn_align">
          <input type="submit" class="btn1" name="submit_quiz" value="Submit Quiz">
          <a class="btn2" name="clear_answer" href="quiz.php" style="text-decoration: none;">Clear Answers</a>
        </div>
      </div>
    </form>
  </div>
  </div>
</body>
</html>