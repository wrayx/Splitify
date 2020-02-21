<?php
include_once "inc.php";
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            // header('Location: ../groups.php?create=failed&error=miss-' . $parameter . '-param');
            return false;
        }// end if statemente
    }// end foreach loop
    return true;
}// end checkParams()

if (checkParams(array('name', 'members')) === true) {
    $name = h($_POST['name']);
    $members = $_POST['members'];
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
} else if (checkParams(array('deleteMemberId', 'groupid')) === true) {
    echo "deleteMemberId:" . $_POST['deleteMemberId'];
    $groupid = $_POST['groupid'];
    $memberid = explode("_", h($_POST['deleteMemberId']))[1];
    $db->deleteGroupMember((int)$memberid, $groupid);
} else if (checkParams(array('deleteGroupId')) === true) {
    echo "deleteGroupId " . $_POST['deleteGroupId'];
    var_dump($_POST['deleteGroupId']);
    $groupid = (int)h($_POST['deleteGroupId']);
    echo $groupid;
    var_dump($groupid);
    $db->deleteGroup($groupid);
} else {
    echo "failed";
}