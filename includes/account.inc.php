<?php
require_once('inc.php');
session_start();
$userid = $db->getUserId($_SESSION['userInfo']);

// user haven't submit any form
if (!isset($_POST['info-submit']) && !isset($_POST['pwd-submit'])) {
    header('Location: ../account.php?error=nosubmit');
    exit;
}
if (!isset($_SESSION['userInfo'])) {
    header('Location: ../index.php?error=notlogin');
    exit;
}

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../account.php?error=param-' . $parameter . '-empty');
            exit;
        }// end if statement
    }// end foreach loop
}// end checkParams()

if (isset($_POST['info-submit']) && isset($_POST['username']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    if ($username != $db->getUsername($userid)) {
        $db->changeUsername($userid, $username);
        $_SESSION['userInfo'] = $username;
    }
    if ($email != $db->getUserEmail($userid)) {
        $db->changeUserEmail($userid, $email);
        $_SESSION['userInfo'] = $email;
    }
    header('Location: ../account.php?changeinfo=success');
    exit;
}