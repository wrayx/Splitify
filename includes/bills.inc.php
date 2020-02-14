<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header('Location: ../bills.php?create=failed&error=miss-' . $parameter . '-param');
            exit;
        }// end if statemente
    }// end foreach loop
}// end checkParams()

checkParams(array('name', 'amount', 'group'));
$name = h($_POST['name']);
$amount = h($_POST['amount']);
$userid = $db->getUserId($userInfo);
$group = h($_POST['group']);
$groupid = $db->getGroupId($group);
$db->createBill($userid, $name, $amount, $groupid);
$billId = $db->getBillId($name);
$groupMembers = $db->getGroupMembers($groupid);
$groupNum = $db->getGroupMemberNum($groupid);
$splitAmount = ((float)$amount) / $groupNum;
foreach ($groupMembers as $member) {
    if ($member != $userid) {
        $db->createSplitBill($billId, $member, $splitAmount);
        var_dump($billId);
        var_dump($userid);
        var_dump($splitAmount);
    }
}