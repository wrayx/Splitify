<?php
require_once('inc.php');

// user haven't not submit any form
if (!isset($_POST['signin-submit'])){
    header('Location: ../signin.php');
    exit;
}

function checkParams($parameters) {
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])){
            header('Location: ../signin.php?error=param-'.$parameter.'-empty');
            exit;
        }// end if statement
    }// end foreach loop
}// end checkParams()

checkParams(array('usernameOrEmail', 'pwd'));

$usernameOrEmail = h($_POST['usernameOrEmail']);
$pwd = h($_POST['pwd']);

$authenticated = $db->authenticateUser($usernameOrEmail, $pwd);

if ($authenticated) {
    session_start();
    $_SESSION["signedInToxxx.com"] = true;
    $_SESSION["userInfo"] = $usernameOrEmail;
    header('Location: ../index.php?signin=success');
} else {
    header('Location: ../signin.php?signin=faild');
}