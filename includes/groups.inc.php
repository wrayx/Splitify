<?php
include_once "inc.php";
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters) {
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])){
            echo 'failed';
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
    $db->createGroup($name);
    $i = 0;
    while ($_POST['member-email'][$i] != null) {
        $email = h($_POST['member-email'][$i]);
        var_dump($email);
        if (!$db->userExists($email)){
            header('Location: ../groups.php?create=failed&error=usernotexist');
            exit;
        }
        $db->addGroupMember($db->getUserId($email), $db->getGroupId($name));
        $i++;
    }
    $db->addGroupMember($db->getUserId($userInfo), $db->getGroupId($name));

    header('Location: ../groups.php?create=success');
}

//if ($db->getTodoId($todoContent, $todoSpace, $userInfo)){
//    echo "failed";
//}
//else {
//    $db->createTodo($todoContent, $todoSpace, $userInfo);
//    echo "success";
//}