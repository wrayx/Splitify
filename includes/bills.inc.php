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
    $billId = $db->getBillId($name);
    $groupMembers = $db->getGroupMembers($groupid);
    $groupNum = $db->getGroupMemberNum($groupid);
    $splitAmount = ((float)$amount) / $groupNum;
    foreach ($groupMembers as $member) {
        $db->createSplitBill($billId, $member, $splitAmount);
//        var_dump($billId);
//        var_dump($userid);
//        var_dump($splitAmount);
//        if ($member === $userid){
//            $splitBills = $db->getUserSplitBills($userid);
//            foreach ($splitBills as $splitBill){
//                if ($db->getSplitBillParent($splitBill) === $billId){
//                    $db->paySplitBill($splitBill);
//                }
//            }
//        }
    }
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