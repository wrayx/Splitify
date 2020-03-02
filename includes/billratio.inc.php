<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header("Location: ../bills.php?create=ratio&error=param-".$parameter."missing");
            exit();
        }
    }
}


function checkStr($params)
{
    foreach ($params as $param) {
        // input is not alpha numerical
        if (! preg_match('/^[a-zA-Z\s]+$/', $param)) {
            header("Location: ../bills.php?error=param-invalid");
            exit();
        }
    }
}


if (isset($_POST['billid']) && isset($_POST['memberID']) && isset($_POST['memberRatio'])) {
    checkParams(array('billid', 'memberID', 'memberRatio'));
    $parent = $_POST['billid'];
    $members = $_POST['memberID'];
    $membersRatio = $_POST['memberRatio'];
    for ($i = 0; i < sizeof($members); $i++){
        $splitAmount = ($membersRatio[$i]/array_sum($membersRatio))*$db->getBillAmount($parent);
        $db->createSplitBill($parent, $members[$i], $splitAmount);
    }
    header('Location: ../bill.php');
    exit();
} 
elseif (isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['group'])){
    $name = $_POST['name'];
    $amount = (float) $_POST['amount'];
    $userid = (int) $db->getUserId($userInfo);
    $group = $_POST['group'];
    $groupid = (int) $db->getGroupId($group);
    
    if (!is_float($amount) || $amount == 0.0){
        header("Location: ../bills.php?create=ratio&error=amount-invalid");
        exit;
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)){
        header("Location: ../bills.php?create=ratio&error=name-invalid");
        exit;
    }
    
    $db->createOnlyBill($userid, $name, $amount, $groupid);
    header('Location: ../bills.php?create=ratio&group='.$groupid.'&billid='.$db->getBillId($name));
    exit();
}
else {
    header("Location: ../bills.php?create=ratio");
    exit();
}