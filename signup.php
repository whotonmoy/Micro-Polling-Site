<?php
    require_once("db.php");

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data); //encodes
        return $data;
    }

    $errors = array();
    $email = "";
    $username = "";
    $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = test_input($_POST["email"]);
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);

        $emailRegex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $usernameRegex = "/^[a-zA-Z0-9_]+$/";
        $passwordRegex = "/^(?=.*[^a-zA-Z])(?!.*\s).{8,}$/";

        if (!preg_match($emailRegex, $email)) {
            $errors["email"] = "Email is invalid!";
        }
        if (!preg_match($usernameRegex, $username)) {
            $errors["username"] = "Username is invalid!";
        }
        if (!preg_match($passwordRegex, $password)) {
            $errors["password"] = "Invalid Password";
        }


        $target_file = "";

        try {
            $db = new PDO($attr, $db_user, $db_pwd, $options);
            // SQL query that finds matches for the username in the Users table
            $query = "SELECT user_id, email, password, avatar_url FROM Users WHERE username = $username";
            $result = $db->query($query);

            $matches = $result->fetch(1);

            if ($matches) {
                $errors["Account Taken"] = "A user with that username already exists.";
            }

            if (empty($errors)) {

                $query = "INSERT INTO Users (email, username, password, avatar_url) VALUES ($email, $username, $password, 'avatar_stub')";
                $result = $db->exec($query);

                if (!$result) {
                    $errors["Database Error:"] = "Failed to insert user";
                }
                else {
                    // Directory where the avatars will be uploaded.
                    $target_dir = "uploads/";
                    $uploadOk = TRUE;

                    $imageFileType = strtolower(pathinfo($_FILES["profilephoto"]["name"],PATHINFO_EXTENSION));

                    $uid = $db->lastInsertId();

                    $target_file = $target_dir.$uid.$imageFileType;

                    // Checking is File already exists
                    if (file_exists($target_file)) {
                        $errors["profilephoto"] = "Sorry, file already exists.";
                        $uploadOK = FALSE;
                    }

                    // Checking if the file is too large
                    if ($_FILES["profilephoto"]["size"] > 1000000) {
                        $errors["profilephoto"] = "File must be smaller than 1MB. ";
                        $uploadOk = FALSE;
                    } 

                    // Checking image file type
                    if  ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        $errors["profilephoto"] = "Unsupported File type. Only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = FALSE;
                    }

                    if ($uploadOK) {
                        // Moving User's avatar to the uploads directory
                        $fileStatus = move_uploaded_file($_FILES["profilephoto"]['tmp_name'], $target_file);

                        // Checking $filestatus
                        if (!$fileStatus) {
                            $errors["Server Error"] = "Image file cannot be Moved!";
                            $uploadOK = FALSE;
                        }
                    }

                    if (!$uploadOK) {
                        $query = "DELETE FROM Users WHERE avatar_url = 'avatar_stub'";
                        $result = $db->exec($query);
                        if (!$result) {
                            $errors["Database Error"] = "Could not delete user when avatar upload failed";
                        }
                        $db = null;
                    }else {
                        $query =  "UPDATE Users SET avatar_url = $target_dir.$uid.$imageFileType WHERE user_id = $uid";
                        $result = $d->exec($query);
                        if (!$result) {
                            $errors["Database Error:"] = "could not update avatar_url";
                        } else {
                            $db = null;
                            header("Location:mainpage.php");
                            exit();
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }

        
        if (!empty($errors)) {
            foreach($errors as $type => $message) {
                print("$type: $message \n<br />");
                
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Sign-up Page</title>
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
            <h2>Sign Up</h2>
        </div>

        <div class="container">
            <form action="" method="post" class="auth-form" id="signup-form" enctype="multipart/form-data">

                <input type="text" placeholder="Email Address" id="email" name="email" value="<?= $email ?>" />
                <p id="error-text-email" class="error-msg <?= isset($errors['email'])?'':'error-text-hidden' ?>">Email is invalid!</p>

                <input type="text" placeholder="Username" id="username" name="username" value="<?= $username ?>" />
                <p id="error-text-username" class="error-msg <?= isset($errors['username'])?'':'error-text-hidden' ?>" >Username is invalid!</p>

                <input type="password" placeholder="Password" id="password" name="password" value="<?= $password ?>" />
                <p id="error-text-password" class="error-msg <?= isset($errors['password'])?'':'error-text-hidden' ?>">Password should be 8 characters or longer, no
                    spaces and should contain at least one non-letter character!</p>

                <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" />
                <p id="error-text-cpassword" class="error-text-hidden">Passwords don't match!</p>

                <label> Upload a Profile Photo:</label>
                <input type="file" id="profilephoto" name="profilephoto" accept="image/*" />

                <p id="error-text-profilephoto" class="error-msg <?= isset($errors['profilephoto'])?'':'error-text-hidden' ?>">Profile Photo is invalid!</p>

                <p>
                    <input type="submit" class="form-submit" id="buttons" value="Signup" />
                </p>

            </form>
        </div>

        <div class="ouser">
            <p>Already an User? <a href="mainpage.php">Login here</a></p>
        </div>
    </div>
    <script src="js/eventRegisterSignup.js"></script>
</body>

</html>