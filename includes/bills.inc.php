<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header("Location: ../bills.php?error=param-".$parameter."missing");
            exit;
        }
    }
}


function checkStr($params)
{
    foreach ($params as $param) {
        // input is not alpha numerical
        if (! preg_match('/^[a-zA-Z\s]+$/', $param)) {
            header("Location: ../bills.php?error=param-invalid");
            exit;
        }
    }
}


if (isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['group'])) {
    checkParams(array('name', 'amount', 'group'));
    $name = $_POST['name'];
    $amount = (float) $_POST['amount'];
    $userid = (int) $db->getUserId($userInfo);
    $group = $_POST['group'];
    $groupid = (int) $db->getGroupId($group);
    
    if (!is_float($amount)){
        header("Location: ../bills.php?error=amount-invalid");
        exit;
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)){
        header("Location: ../bills.php?error=name-invalid");
        exit;
    }
    
    $db->createBill($userid, $name, $amount, $groupid);
    if ($_POST['paid'] === 'true') {
        $parent = $db->getBillId($name);
        $db->paySplitBill($db->getSplitBillid($parent, $userid));
    }
    header("Location: ../bills.php");
    $billID = $db->getBillId($name);
    $groupMembers = $db->getGroupMembers($groupid);
    $groupNum = $db->getGroupMemberNum($groupid);
    $splitAmount = ($amount) / $groupNum;
    foreach ($groupMembers as $member) {
        $db->sendBillNotification($db->getUserEmail($member), $db->getUsername($userid), $splitAmount, $createdate);
    }
} elseif (isset($_POST['billID'])) {
    checkParams(array('billID'));
    $id = $_POST['billID'];
    $db->deleteBill((int)$id);
    header("Location: ../bills.php?deletebill=success");
} elseif (isset($_POST['splitBillID'])) {
    checkParams(array('splitBillID'));
    $id = $_POST['splitBillID'];
    $db->paySplitBill((int)$id);
    header("Location: ../bills.php?confirmbill=success");
} else {
    header("Location: ../bills.php");
}