<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $option = $_POST["option"];


    http_response_code(200);
} else {

    http_response_code(400);

}
?>