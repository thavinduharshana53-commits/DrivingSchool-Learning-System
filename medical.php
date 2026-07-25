<?php
include("dbconnection.php");
session_start();

if (!isset($_SESSION['id'])) {
  header("location: login.php");
  exit();
}

if (isset($_POST['submit_ass'])) {
  $score = 0;
  $qus = 6;

  $answer = array(
    'q1' => 'no',
    'q2' => 'no',
    'q3' => 'no',
    'q4' => 'no',
    'q5' => 'no',
    'q6' => 'no'
  );

  foreach ($answer as $key => $value) {
    if (isset($_POST[$key]) && $_POST[$key] == $value) {
      $score++;
    }
  }

  $userId = $_SESSION['id'];
  $activity = "medical";
  $totQus =  $qus;

  $sql = "INSERT INTO user_progress(user_id, activity_type, score, max_score) VALUES('$userId', '$activity', '$score', '$totQus')";

  $result = mysqli_query($conn, $sql);

  if ($result) {
    if ($score >= 5) {
      $result = $score . "/" . $qus . " (Likely fit to drive)";
      $recomand = "You appear medically fit to drive. However, consult a doctor if you have any concerns.";
    } elseif ($score >= 3) {
      $result = $score . "/" . $qus . " (Some concerns)";
      $recomand = " You may have some medical concerns. Consider consulting a doctor before driving.";
    } elseif ($score <= 2) {
      $result = $score . "/" . $qus . " (Significant concerns)";
      $recomand = "You have several medical concerns. Please consult a doctor before driving.";
    }
  }
}

$userId = $_SESSION['id'];

$history_ssql = "SELECT COUNT(*) as count, MAX(completed_at) as lastCheck FROM user_progress WHERE
user_id = '$userId' AND activity_type ='medical'";
$hResult = mysqli_query($conn, $history_ssql);

if($hResult){
$resultRow = $hResult->fetch_assoc();
$takenTime = $resultRow['count'];
$lastCheck = $resultRow['lastCheck'];
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Self-Assessment</title>
  <link rel="stylesheet" href="css/medical.css">
  <style>
    .safe,
    .unsafe {
      padding: 10px 0px 10px 40px;
      border-radius: 4px;
      margin: 10px 0;
    }

    .safe { background-color: #baf0c6eb; color: #155724;}
    .unsafe {background-color: #fee2e2;color: #991b1b;}
    .safe span, .unsafe span{font-weight: bold; line-height: 1.8;}
    p{font-size: 1.1rem;}
  </style>
</head>

<body>
  <div class="title">
    <h1>Medical Self-Assessment</h1>
    <p>This questionnaire helps assess your fitness to drive. Answer honestly.</p>
  </div>

  <?php
  if (isset($result)) {
    if ($result >= 3) {
      echo "<div class='safe'>
      <h3>Assessment completed!</h3>
      <p><span>Your Score: </span>" . $result . "<br>
      <span>Recommendation: </span>" . $recomand . "</p>
      </div>";
    } else {
      echo "<div class='unsafe'>
      <h3>Assessment completed!</h3>
      <p><span>Your Score: </span>" . $result . "<br>
      <span>Recommendation: </span>" . $recomand . "</p>
      </div>";
    }
  }
  ?>

  <div class="history">
    <h3>Assessment History:</h3>
    <p>Times taken: <?php echo $takenTime;?></p>
    <p>Last check: <?php echo $lastCheck;?></p>
  </div>
  <div class="medic_container">
    <form action="medical.php" method="post">
      <div class="subtitle">
        <h2>Medical Questionnaire</h2>
        <p>Please answer all questions honestly. Select "Yes" or "No" for each.</p>
      </div>

      <div class="qustions">
        <div class="Q1">
          <p>1. Do you have any health problem that causes dizziness or fainting?</p>
          <span>Examples: epilepsy, low blood pressure, heart conditions.</span>
          <div class="option">
            <label><input type="radio" name="q1" value="yes">Yes<br></label>
            <label><input type="radio" name="q1" value="no">No<br></label>
          </div>
        </div>

        <div class="Q2">
          <p>2. Do you have vision problems that are not corrected by glasses or contact lenses?</p>
          <div class="option">
            <label><input type="radio" name="q2" value="yes">Yes<br></label>
            <label><input type="radio" name="q2" value="no">No<br></label>
          </div>
        </div>

        <div class="Q3">
          <p>3. Do you have hearing problems that make it hard to hear traffic sounds?
          </p>
          <div class="option">
            <label><input type="radio" name="q3" value="yes">Yes<br></label>
            <label><input type="radio" name="q3" value="no">No<br></label>
          </div>
        </div>

        <div class="Q4">
          <p>4. Do you have arthritis or joint problems that limit your movement?
          </p>
          <span>Examples: difficulty turning head, trouble using pedals or steering wheel</span>
          <div class="option">
            <label><input type="radio" name="q4" value="yes">Yes<br></label>
            <label><input type="radio" name="q4" value="no">No<br></label>
          </div>
        </div>

        <div class="Q5">
          <p>5. Are you taking any medicine that makes you feel sleepy or slows your reaction time?
          </p>
          <div class="option">
            <label><input type="radio" name="q5" value="yes">Yes<br></label>
            <label><input type="radio" name="q5" value="no">No<br></label>
          </div>
        </div>

        <div class="Q6">
          <p>6. Do you have sleep problems such as sleep apnea or narcolepsy?
          </p>
          <div class="option">
            <label><input type="radio" name="q6" value="yes">Yes<br></label>
            <label><input type="radio" name="q6" value="no">No<br></label>
          </div>
        </div>
      </div>
      <div class="btn_align">
        <button type="submit" class="btn" name="submit_ass">Submit Assessment</button>
        <button type="reset" class="btn2" name="clear_answer">Clear Answers</button>
      </div>
    </form>
  </div>

  <div class="Scored">
    <h2>How Your Assessment is Scored:</h2>
    <ul>
      <li><b>5-6 "No" answers:</b> Likely fit to drive</li>
      <li><b>3-4 "No" answers:</b> Some concerns - consider medical consultation</li>
      <li><b>0-2 "No" answers:</b> Significant concerns - consult a doctor</li>
    </ul>
    <p>Remember: This is not medical advice. Always consult with healthcare professionals.</p>
  </div>

</body>

</html>