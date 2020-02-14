<?php
include_once "inc.php";
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters) {
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])){
            header('Location: ../bills.php?create=failed&error=miss-'.$parameter.'-param');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

checkParams(array('name', 'amount', 'group'));
$name = h($_POST['name']);
$amount = h($_POST['amount']);
$group = h($_POST['group']);
$userid = $db->getUserId($userInfo);
$groupid = $db->getGroupId($group);
echo $group;

$db->createBill($userid, $name, $amount, $groupid);