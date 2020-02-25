<?php
require("inc.php");
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../groups.php?create=failed&error=missing-param');
        }
    }
}

if (isset($_POST['name']) && isset($_POST['members'])) {
    checkParams(array('name', 'members'));
    $name = h($_POST['name']);
    var_dump($name);
    $members = $_POST['members'];
    if ($db->getGroupId($name) != null) {
        header('Location: ../groups.php?create=failed&error=namealreadyexist');
        exit;
    } else {
        foreach ($members as $member) {
            if ($db->getUserId($member) == null) {
                header('Location: ../groups.php?create=failed&error=usernotexist');
                exit;
            }
            // var_dump($member);
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
} 
else if (isset($_POST['group-id']) && isset($_POST['member-id'])) {
    $groupid = $_POST['group-id'];
    $memberid = $_POST['member-id'];
    $db->deleteGroupMember((int)$memberid, (int)$groupid);
    header("Location: ../groups.php?deletemember=success");
} 
else if (isset($_POST['group-id'])) {
    $groupid = $_POST['group-id'];
    $db->deleteGroup((int)$groupid);
    header("Location: ../groups.php?deletegroup=success");
} else {
    echo "failed";
    exit;
}