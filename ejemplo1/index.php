<?php
/**
 * Created by PhpStorm.
 * User: sgarcia
 * Date: 15/10/18
 * Time: 9:48
 */
$name = $email = $gender = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $gender = test_input($_POST["gender"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "Your Given details are as :";
echo $name;
echo "";

echo $email;
echo "";

echo $gender;
