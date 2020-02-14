<?php
include_once "inc.php";
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters) {
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])){
            header('Location: ../groups.php?create=failed&error=miss-'.$parameter.'-param');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

checkParams(array('name', 'member-email'));
$name = h($_POST['name']);
if ($db->getGroupId($name) != null) {
    header('Location: ../groups.php?create=failed&error=namealreadyexist');
    exit;
}
else {
    $i = 0;
    while ($_POST['member-email'][$i] != null) {
        $email = h($_POST['member-email'][$i]);
        if (!$db->userExists($email)) {
            header('Location: ../groups.php?create=failed&error=usernotexist');
            exit;
        }
        $i++;
    }
    $db->createGroup($name);
    $i = 0;
    while ($_POST['member-email'][$i] != null) {
        $email = h($_POST['member-email'][$i]);
        var_dump($email);
        if ($db->getUserId($userInfo) == $db->getUserId($email)) {
            continue;
        }
        $db->addGroupMember($db->getUserId($email), $db->getGroupId($name));
        $i++;
    }
    $db->addGroupMember($db->getUserId($userInfo), $db->getGroupId($name));

    header('Location: ../groups.php?create=success');
}