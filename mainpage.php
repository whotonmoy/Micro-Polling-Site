<?php
    require_once("db.php");

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); //encodes
        return $data;
    }
    
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);  
        
        if (!$db) {
            echo "Falied to Connect to Database!";
        }
        
        $errors = array();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);

            $query = "SELECT * FROM Users WHERE username = $username and password = $password";
            $result = $db->query($query);

            if (!$result) {
                // query has an error
                $errors["Database Error"] = "Could not retrieve user information";
            } elseif ($row = $result->fetch()) {
                // If there's a row, we have a match and login is successful!
                session_start();

                // Storing the user_id, email, password, and avatar_url fields from $row into the $_SESSION superglobal variable
                $_SESSION = $row;

                $db = null;
                header("Location:pollmanagement.php");
                exit();
            } else {
                // login unsuccessful
                $errors["Login Failed"] = "That username/password combination does not exist.";
            }
            $db = null;
        }

?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Main Page</title>
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

        <div id="pagehead">
            <h2>Login</h2>
        </div>

        <div class="container">
            <form action="" method="post" class="auth-form" id="login-form" enctype="multipart/form-data">
                <input type="text" placeholder="Username" id="username" name="username" />
                <p id="error-text-username" class="error-text-hidden">Username is invalid!</p>
                <input type="password" placeholder="Password" id="password" name="password" />
                <p id="error-text-password" class="error-text-hidden">Password is Incorrect!</p>
                <input type="submit" id="buttons" class="form-submit" value="Login" /></br>
            </form>
        </div>

        <div class="foot-note">
            <p>New User? <a href="signup.php">Sign up here</a></p>
            <p><a href="pollvote.php">Poll Vote Page</a></p>
            <p><a href="pollresults.php">Poll Results Page</a></p>
        </div>

        </br>

        <div class="foot">
            <h3>Recent Polls</h3>
            <hr>
            <?php
                // Selecting 5 most recent active Polls
                $polls_query_recent = "SELECT poll_id, question FROM Polls WHERE NOW() BETWEEN open_dt AND close_dt ORDER BY created_dt DESC LIMIT 5";
                $poll_result = $db->query($polls_query_recent);
                
                if ($poll_result) {
                    // Get the number of rows returned by the query
                    $num_rows = $poll_result->rowCount();
                
                    if ($num_rows > 0) {
                        while ($row = $poll_result->fetch(PDO::FETCH_ASSOC)) {
                            $poll_id = $row['poll_id'];
                            $question = $row['question'];
                
                            // Generate the link to the poll vote page
                            $vote_page_link = "poll_vote_page.php?poll_id=" . $poll_id;
                
                            // Display the question and the link
                            echo '<p><a href="' . $vote_page_link . '">' . $question . '</a></p>';
                        }
                    } else {
                        echo "No active polls found.";
                    }
                } 
                if (!$poll_result) {
                    $errors["Database Error"] = "Could not retrieve Polls";
                }
                if (!empty($errors)) {
                    foreach($errors as $type => $message) {
                        print("$type: $message \n<br />");  
                    }
                }

            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            } 
            ?>

        </div>
    </div>
    </div>
    <script src="js/eventRegisterLogin.js"></script>
</body>

</html>