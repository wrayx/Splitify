<?php
require_once('inc.php');

// user haven't not submit any form
if (!isset($_POST['signup-submit'])) {
    header('Location: ../signup.php');
    exit;
}

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../signup.php?error=param-missing');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

// 1. check if all fields have been filled and submit button has been pressed
checkParams(array('username', 'pwd', 'email', 're-pwd'));

$emailMaxLength = 40;
$usernameMaxLength = 20;
$username = h($_POST['username']);
$email = h($_POST['email']);
$pwd = h($_POST['pwd']);
$rePwd = h($_POST['re-pwd']);

// 2. check if password and repeated password did match
if ($pwd !== $rePwd) {
    header('Location: ../signup.php?error=pwddiff');
} // 3. validate email and username valid
else if ((!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > $emailMaxLength) && (!preg_match("/^[a-zA-Z0-9]*$/", $username) || strlen($username) > $usernameMaxLength)) {
    // both not valid
    header('Location: ../signup.php?error=paramsnotvalid');
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > $emailMaxLength) {
    // email not valid, send back ok username
    header('Location: ../signup.php?error=email-not-valid&username=' . $username);
} else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) || strlen($username) > $usernameMaxLength) {
    // username not valid, send back email
    header('Location: ../signup.php?error=username-not-valid&useremail=' . $email);
} else {
    $res = $db->createUser($username, $email, $pwd);
    if ($res) {
        header('Location: ../signin.php?signup=success');
    } else {
        header('Location: ../index.php?error=sqlerror');
    }
}