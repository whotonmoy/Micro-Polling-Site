<?php
    session_start();
    require_once("db.php");
    
    // Checking whether the user has logged in or not.
    if (!isset($_SESSION["user_id"])) {
        header("Location: mainpage.php");
        exit();
    } else {
        $user_id = $_SESSION["user_id"];
        $username = $_SESSION["username"];
        $avatar_url = $_SESSION["avatar_url"];
    }

    // Connecting to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    $av = "SELECT avatar_url FROM Users WHERE user_id = $user_id";
    // $av_result = $db->query($av);
    // $av_row = $av_result->fetch(PDO::FETCH_ASSOC);
    // $avatar_url = $av_row[0];

    $query = "SELECT Polls.poll_id, Polls.question, Polls.created_dt, Answers.answer_id, Answers.answer, COUNT(Votes.vote_id) AS vote_count, MAX(Votes.vote_dt) AS last_vote_dt
              FROM Polls
              LEFT JOIN Answers ON Polls.poll_id = Answers.poll_id
              LEFT JOIN Votes ON Answers.answer_id = Votes.ans_id
              WHERE Polls.user_id = $user_id
              GROUP BY Answers.answer_id
              ORDER BY Polls.created_dt DESC";

    $result = $db->query($query);

    if ($result->rowCount() > 0) {
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $poll_id = $row['poll_id'];
          $question = $row['question'];
          $created_dt = $row['created_dt'];
          $answer_id = $row['answer_id'];
          $answer = $row['answer'];
          $vote_count = $row['vote_count'];
          $last_vote_dt = $row['last_vote_dt'];
  
          // Generate the links to the Poll Vote Page and Poll Results Page
          // $vote_page_link = "pollvote.php?poll_id=" . $poll_id;
          // $results_page_link = "pollresults.php?poll_id=" . $poll_id;

?>


<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Poll Management Page</title>
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <!-- this meta is required for CSS validation to work properly -->
  <meta name="referrer" content="unsafe-url" />
</head>

<body>
  <div class="managementgrid">
    <header>
      <h1>Micro-Polling Site</h1>
    </header>

    <span id="pollmanagementheading">
      <h1>Polls Management</h1>
    </span>

    <!-- Create Polls Button  -->
    <button id="createpoll" type="button" onclick="window.location.href='pollcreate.php';">Create Polls</button>

    <!-- User info -->
    <div id="userinfo">
      <?=echo '<img src="' . $avatar_url . '" alt="User Avatar" width="285" height="450">'?>
      <?=echo '<p>' . $username . '</p>'?>
    </div>

    <table id="resultstable">
      <tr>
        <td>
          <div class="managementresults">
            <div class="pollresults">
              <?= echo '<h1>' . $question . '</h1>' ?>

              <!-- Created Time and date -->
              <div id="createtime">
                <?= echo '<p>Created ' . $created_dt . '</p>' ?>
              </div>

              <!-- Updated Time and date -->
              <div id="updatetime">
                <p>Updated <?= $last_vote_dt ?> </p>
              </div>

              <!-- Options for the Poll -->
              <li>
                <h3><?=$answer?> - Votes:  <?=$vote_count?></h3>
              </li>

            </div>
          </div>
        </td>
      </tr>
    </table>
    <?php
        }
      } else {
        echo "No polls found for the logged-in User.";
      }

      $db->close();
    ?>

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
          <a href="logout.php">
            <li>Logout</li>
          </a>
          <a href="pollvote.php">
            <li>Poll Vote Page</li>
          </a>
          <a href="pollresults.php">
            <li>Poll Results Page</li>
          </a>
        </ul>
      </div>
    </nav>


  </div>
</body>

</html>