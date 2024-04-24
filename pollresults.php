<?php
  require_once("db.php");

  $poll_id = $_GET['poll_id'];

  try {
    $db = new PDO($attr, $db_user, $db_pwd, $options);

    $uname_query = "SELECT Users.username, Users.avatar_url FROM Users JOIN Polls ON Users.user_id = Polls.user_id WHERE Polls.poll_id = $poll_id";
    $user_result = $db->query($uname_query);
    $uname_row = $uname_result->fetch(PDO::FETCH_ASSOC);
    $username = $uname_row[0];  
    
    $query = "SELECT Polls.question, Answers.ans_id, Answers.answer, COUNT(Votes.vote_id) AS vote_count, MAX(Votes.vote_dt) AS last_vote_dt
            FROM Polls
            LEFT JOIN Answers ON Polls.poll_id = Answers.poll_id
            LEFT JOIN Votes ON Answers.ans_id = Votes.ans_id
            WHERE Polls.poll_id = $poll_id
            GROUP BY Answers.ans_id
            ORDER BY Answers.ans_id";

  $result = $db->query($query);

  if ($result->rowCount() > 0) {
    $question = $row['question'];
    $answer_id = $row['answer_id'];
    $answer = $row['answer'];
    $vote_count = $row['vote_count'];
    $last_vote_dt = $row['last_vote_dt'];
  
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Poll Results Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- this meta is required for CSS validation to work properly -->
  <meta name="referrer" content="unsafe-url" />
</head>

<body>
  <div>
    <header>
      <h1>Micro-Polling Site</h1>
    </header>


    <span id="pollresultshead">
      <h1>Poll Result</h1>
    </span>


    <div class="pollresults">
      <h1>. <?= $question ?> </h1>

      <li>
        <h3> <?= $answer ?>  - Votes:  <?= $vote_count ?> </h3>
      </li>
        
      <!-- <li>
        <h3>Albert Einstein</h3>
        <span class="bar"><span class="Albert"></span></span>
      </li>
      <li>
        <h3>Galileo Galilei</h3>
        <span class="bar"><span class="Galileo"></span></span>
      </li>
      <li>
        <h3>Tonmoy Chowdhury</h3>
        <span class="bar"><span class="Tonmoy"></span></span>
      </li>
      <li>
        <h3>Stephen Hawkins</h3>
        <span class="bar"><span class="Stephen"></span></span>
      </li> -->

      <div id="updatetime">
        <p>Updated <?= $last_vote_dt ?></p>
      </div>
      <div class="createdby">
        <span><b>Created by:</b></span>
        <img src=" <?=$avatar_url?>" alt="User Avatar" width="50" height="54" id="pollvotedp">
        <span id="pollusername"><?= $username ?></span>
      </div>
    <?php
        } 
        else {
          echo "No polls Found!.";
        }

        $db->close();
      } 
      catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
      }
    ?>

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