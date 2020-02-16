<?php
include_once "inc.php";
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters) {
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../groups.php?create=failed&error=miss-' . $parameter . '-param');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

checkParams(array('name', 'members'));
$name = h($_POST['name']);
$members = $_POST['members'];
//var_dump($members);
//foreach ($members as $member){
//    $member = h($member);
//}
//var_dump($members);
if ($db->getGroupId($name) != null) {
    header('Location: ../groups.php?create=failed&error=namealreadyexist');
    exit;
} else {
    foreach ($members as $member) {
        if (!$db->userExists($member)) {
            header('Location: ../groups.php?create=failed&error=usernotexist');
            exit;
        }
    }
    $db->createGroup($name);
    $groupid = $db->getGroupId($name);
    foreach ($members as $member) {
        if ($db->getUserId($userInfo) != $db->getUserId($member)) {
            $db->addGroupMember($db->getUserId($member), $groupid);
        }
    }
    $db->addGroupMember($db->getUserId($userInfo), $groupid);

    header('Location: ../groups.php?create=success');
}