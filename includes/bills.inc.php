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
        }
    }
    return true;
}


function checkStr($params)
{
    foreach ($params as $param) {
        // input is not alpha numerical
        if (!ctype_alnum($_POST[$param])) {
            return false;
        }
    }
    return true;
}


if (checkParams(array('name', 'amount', 'group', 'paid'))) {
    if (!checkStr(array('name')) || !is_numeric($_POST['amount'])) {
        echo 'param-invalid';
        exit;
    }
    $name = h($_POST['name']);
    $amount = h($_POST['amount']);
    $userid = $db->getUserId($userInfo);
    $group = h($_POST['group']);
    $groupid = $db->getGroupId($group);
    $db->createBill($userid, $name, $amount, $groupid);
    if (h($_POST['paid']) === 'true') {
        $parent = $db->getBillId($name);
        $db->paySplitBill($db->getSplitBillid($parent, $userid));
    }
} elseif (checkParams(array('deleteId')) === true) {
    $id = h($_POST['deleteId']);
    $db->deleteBill($id);
} elseif (checkParams(array('paySplitBillId')) === true) {
    $id = h($_POST['paySplitBillId']);
    $db->paySplitBill($id);
} else {
    echo 'param-missing';
    exit;
}