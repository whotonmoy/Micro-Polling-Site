<?php
  require_once("db.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['poll_id']) && isset($_POST['answer'])) {
    $poll_id = $_POST['poll_id'];
    $selected_answer = $_POST['answer'];

    // Insert the vote into the Votes table
    $insert_query = "INSERT INTO Votes (ans_id, vote_dt) VALUES (ans_id, NOW())";
    $stmt = $db->prepare($insert_query);
    $stmt->bindParam('ans_id', $selected_answer, PDO::PARAM_INT);
    $stmt->execute();

    exit();
  }
  
  try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);
  } catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }


  $answers = "SELECT ans_id, answer FROM Answers WHERE poll_id = $poll_id"; 

  $answers = "SELECT Answers.answer FROM ANSWERS JOIN Votes ON Answers.ans_id = Votes.ans_id WHERE Answers.ans_id = $ans_id";

  $result_answers = $db->query($answers);

  if ($result_votes) {
    
    $votesArray = array();
    while ($row = $result_votes->fetch_assoc()) {
      $votesArray = $row;
    }

  }

  $db = null;

?>

<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Poll Vote Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- this meta is required for CSS validation to work properly -->
  <meta name="referrer" content="unsafe-url" />
</head>

<body>
  <div class="logsigngrid">
    <header>
      <h1>Micro-Polling Site</h1>
    </header>

    <div class="pollvote">

      <!-- Poll Title/Question -->
      <h1><?=$row['Polls.question']?></h1>

      <!-- Radio input to select poll option -->
      <div class="box">

          <?php
            foreach ($answers as $answer) {
              echo "<input type='radio' name='option-1' id='option-1' value='{$answer['ans_id']}'> {$answer['answer']}";
          ?>
          
        <!-- <input type="radio" name="option-1" id="option-1">
        <input type="radio" name="option-2" id="option-2">
        <input type="radio" name="option-3" id="option-3">
        <input type="radio" name="option-4" id="option-4">
        <input type="radio" name="option-5" id="option-5"> -->

        <label for="option-1" class="option-1">
          <div class="dot"></div>
          <div class="optiontext"><?=$answer?></div>
        </label>
        <!-- <label for="option-2" class="option-2">
          <div class="dot"></div>
          <div class="optiontext">></div>
        </label>
        <label for="option-3" class="option-3">
          <div class="dot"></div>
          <div class="optiontext">></div>
        </label>
        <label for="option-4" class="option-4">
          <div class="dot"></div>
          <div class="optiontext"></div>
        </label>
        <label for="option-5" class="option-5">
          <div class="dot"></div>
          <div class="optiontext"></div> -->
        </label>
      </div>

      <?php
          }
        ?>

      <button id="postpoll" type="submit">Submit</button>

      <!-- Expiry date of the vote -->
      <span id="expiry">
        <p>Expiry: 7/21/2023</p>
      </span>


      <!-- Information of the creator -->
      <div class="createdby">
        <span><b>Created by:</b></span>
        <img src="images/gojo.jpg" alt="User Avatar" width="50" height="54" id="pollvotedp">
        <span id="pollusername"><?=$username?></span>
      </div>

      <!-- Link to Poll Results Page -->
      <div class="pollresultslinkfromvote">
        <a href="pollresults.html">Poll Results Page</a>
      </div>
    </div>

    <!-- Hamburger menu -->
    <nav role='navigation'>
      <div id="menuToggle">
        <!--A fake / hidden checkbox is used as click reciever-->
        <input type="checkbox" />

        <!--spans to act as a hamburger.-->
        <span></span>
        <span></span>
        <span></span>

        <ul id="menu">
          <a href="mainpage.php">
            <li>Login</li>
          </a>
          <a href="signup.php">
            <li>Sign Up</li>
          </a>
        </ul>
      </div>
    </nav>

  </div>

</body>

</html>