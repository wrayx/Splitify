<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header("Location: ../bills.php?error=param-missing");
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
    if (!is_numeric($_POST['amount'])){
        header("Location: ../bills.php?error=amount-invalid");
        exit;
    }
    elseif (!preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['name'])){
        header("Location: ../bills.php?error=name-invalid");
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
    header('Location: ../bills.php');
} elseif (isset($_POST['deleteId'])) {
    checkParams(array('deleteId'));
    $id = h($_POST['deleteId']);
    $db->deleteBill($id);
} elseif (checkParams(array('paySplitBillId'))) {
    checkParams(array('paySplitBillId'));
    $id = h($_POST['paySplitBillId']);
    $db->paySplitBill($id);
} else {
//    echo 'param-missing';
    header("Location: ../bills.php?error=param-missing");
    exit;
}