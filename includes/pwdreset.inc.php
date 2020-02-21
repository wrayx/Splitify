<?php
require_once('inc.php');
function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../index.php?error=param-missing');
            exit;
        }// end if statement
    }// end foreach loop
}// end checkParams()

if (isset($_POST['pwd-submit'])) {
    checkParams(array('pwd', 're-pwd', 'selector', 'token'));
    $pwd = $_POST['pwd'];
    $rePwd = $_POST['re-pwd'];
    $selector = $_POST['selector'];
    $token = $_POST['token'];
    if ($pwd != $rePwd) {
        header("Location: ../index.php?error=pwddiff");
    } else {
        if ($db->verifyResetToken($selector, $token)) {
            $email = $db->getSelectorEmail($selector);
            $db->changeUserPwd($db->getUserId($email), $pwd);
            header("Location: ../signin.php?pwdchange=success");
        } else {
            header("Location: ../pwdrecover.php?pwdchange=failed");
        }
    }
}
else if (isset($_POST['account-pwd-submit'])) {
    checkParams(array('pwd', 're-pwd'));
    $pwd = $_POST['pwd'];
    $rePwd = $_POST['re-pwd'];
    if ($pwd != $rePwd) {
        header("Location: ../account.php?error=pwddiff");
    } else {
        $db->changeUserPwd($db->getUserId($email), $pwd);
        header("Location: ../account.php?pwdchange=success");
    }
}