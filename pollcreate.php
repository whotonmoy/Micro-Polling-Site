<?php
    session_start();
    require_once("db.php");

    // Checking whether the user has logged in or not.
    if (!isset($_SESSION["user_id"])) {
        header("Location: mainpage.php");
        exit();
    } else {
        $user_id = $_SESSION["user_id"];
    }
    
    $errors = array();
    $question = "";
    $ans1 = "";
    $ans2 = "";
    $ans3 = "";
    $ans4 = "";
    $ans5 = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $question = test_input($_POST["question"]);
        $ans1 = test_input($_POST["ans1"]);
        $ans2 = test_input($_POST["ans2"]);
        $ans3 = test_input($_POST["ans3"]);
        $ans4 = test_input($_POST["ans4"]);
        $ans5 = test_input($_POST["ans5"]);

        $opentime = test_input($_POST["opentime"]);
        $closetime = test_input($_POST["closetime"]);

        $questionRegex = "/^.{1,99}$/";
        $answerRegex = "/^(|\s*.{1,49})$/";
        $dateRegex = "/^(000[1-9]|00[1-9]\d|0[1-9]\d\d|100\d|10[1-9]\d|1[1-9]\d{2}|[2-9]\d{3}|[1-9]\d{4}|1\d{5}|2[0-6]\d{4}|27[0-4]\d{3}|275[0-6]\d{2}|2757[0-5]\d|275760)-(0[1-9]|1[012])-(0[1-9]|[12]\d|3[01])T(0\d|1\d|2[0-4]):(0\d|[1-5]\d)(?::(0\d|[1-5]\d))?(?:.(00\d|0[1-9]\d|[1-9]\d{2}))?$/";


        if (!preg_match($questionRegex, $question)) {
            $errors["question"] = "Question input is invalid!";
        }
        if (!preg_match($answerRegex, $ans1)) {
            $errors["ans1"] = "Option 1 input is invalid!";
        }
        if (!preg_match($answerRegex, $ans2)) {
            $errors["ans2"] = "Option 2 input is invalid!";
        }
        if (!preg_match($answerRegex, $ans3)) {
            $errors["ans3"] = "Option 3 input is invalid!";
        }
        if (!preg_match($answerRegex, $ans4)) {
            $errors["ans4"] = "Option 4 input is invalid!";
        }
        if (!preg_match($answerRegex, $ans5)) {
            $errors["ans5"] = "Option 5 input is invalid!";
        }
        if (!preg_match($dateRegex, $opentime)) {
            $errors["opentime"] = "Opening Date/Time is invalid!";
        }
        if (!preg_match($dateRegex, $closetime)) {
            $errors["closetime"] = "Closing Date/Time is invalid!";
        }

        // Connecting to the database and verify the connection
        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);

            if (empty($errors)) {

                // create a new poll object and store it in the database
                $query = "INSERT INTO Polls (user_id, question, created_dt, open_dt, close_dt) VALUES ($user_id, $question, NOW(), $opentime, $closetime)";
                $result = $db->exec($query);

                if (!$result) {
                    $errors["Database Error:"] = "Failed to insert Poll!";
                }
                else {
                    $pid = $db->lastInsertId();
                    $result_ans1 = $db->exec("INSERT INTO Answers (poll_id, asnwer) VALUES ($pid, $ans1)");
                    $result_ans2 = $db->exec("INSERT INTO Answers (poll_id, asnwer) VALUES ($pid, $ans2)");
                    $result_ans3 = $db->exec("INSERT INTO Answers (poll_id, asnwer) VALUES ($pid, $ans3)");
                    $result_ans4 = $db->exec("INSERT INTO Answers (poll_id, asnwer) VALUES ($pid, $ans4)");
                    $result_ans5 = $db->exec("INSERT INTO Answers (poll_id, asnwer) VALUES ($pid, $ans5)");

                    if (!$result_ans1 || !$result_ans2 || !$result_ans3 || !$result_ans4 || !$result_ans5) {
                        $errors["Database Error:"] = "Failed to insert Answer!";
                    }
                    else {
                        $db = null;
                        header("Location:pollmanagement.php");
                        exit();
                    }
                }
            }

        } 
    }catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
            
        }
    }

?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Poll Create Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <!-- this meta is required for CSS validation to work properly -->
    <meta name="referrer" content="unsafe-url" />
    <script src="js/eventHandlers.js"></script>
</head>

<body>
    <div class="logsigngrid">
        <header>
            <h1>Micro-Polling Site</h1>
        </header>

        <div class="creation">
            <form action="" method="post" class="auth-form" id="pollcreation-form" enctype="multipart/form-data">
                <h1>Create a Poll</h1>

                <h3><label for="question" class="question">Title / Question</label></h3>
                <input type="text" id="question" placeholder="Type your question here" name="question">
                <p id="error-text-question" style="color: grey;">0 characters entered. 99 characters left</p>

                <h3><label for="options" class="options">Answer Options</label></h3>
                <input type="text" id="ans1" placeholder="Option 1" name="ans1" /></br>
                <p id="error-text-ans1" style="color: grey;">0 characters entered. 49 characters left</p>

                <input type="text" id="ans2" placeholder="Option 2" name="ans2" /></br>
                <p id="error-text-ans2" style="color: grey;">0 characters entered. 49 characters left</p>

                <input type="text" id="ans3" placeholder="Option 3" name="ans3" /></br>
                <p id="error-text-ans3" style="color: grey;">0 characters entered. 49 characters left</p>

                <input type="text" id="ans4" placeholder="Option 4" name="ans4" /></br>
                <p id="error-text-ans4" style="color: grey;">0 characters entered. 49 characters left</p>

                <input type="text" id="ans5" placeholder="Option 5" name="ans5" /></br>
                <p id="error-text-ans5" style="color: grey;">0 characters entered. 49 characters left</p>

                <label>Open Date/Time </label>
                <input type="datetime-local" id="opentime"></br>
                <p id="error-text-opentime" class="error-text-hidden">Opening time is Invalid!</p>

                <label>Close Date/Time </label>
                <input type="datetime-local" id="closetime">
                <p id="error-text-closetime" class="error-text-hidden">Closing time is Invalid!</p></br>

                <input type="submit" id="postpoll" class="form-submit" value="Create it!" /></br>
            </form>
        </div>
        <button id="logout" type="button" onclick="window.location.href='logout.php';">Logout</button></br>
    </div>
    <script src="js/eventRegisterPollCreate.js"></script>
</body>

</html>