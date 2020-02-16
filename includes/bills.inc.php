<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            return false;
        }// end if statemente
    }// end foreach loop
    return true;
}// end checkParams()

if (checkParams(array('name', 'amount', 'group')) === true) {
    $name = h($_POST['name']);
    $amount = h($_POST['amount']);
    $userid = $db->getUserId($userInfo);
    $group = h($_POST['group']);
    $groupid = $db->getGroupId($group);
    $db->createBill($userid, $name, $amount, $groupid);
} elseif (checkParams(array('deleteId')) === true) {
    $id = h($_POST['deleteId']);
    $db->deleteBill($id);
} elseif (checkParams(array('paySplitBillId')) === true) {
    $id = h($_POST['paySplitBillId']);
    $db->paySplitBill($id);
} else {
    header('Location: ../bills.php?create=failed&error=missing-param');
    exit;
}