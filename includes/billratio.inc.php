<?php
include('inc.php');
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header("Location: ../bills.php?create=ratio&error=param-missing");
            exit();
        }
    }
}


if (isset($_POST['billid']) && isset($_POST['memberid']) && isset($_POST['memberratio'])) {
    checkParams(array('billid', 'memberid', 'memberratio'));
    $parent = $_POST['billid'];
    $members = $_POST['memberid'];
    $membersRatio = $_POST['memberratio'];
    for ($i = 0; $i < sizeof($membersRatio); $i++){
        // var_dump($db->getBillAmount($parent));
        $splitAmount = ($membersRatio[$i]/array_sum($membersRatio))*$db->getBillAmount($parent);  
        // var_dump($splitAmount); 
        $db->createSplitBill((int)$parent, (int)$members[$i], $splitAmount);
        $db->sendBillNotification($db->getUserEmail((int)$members[$i]), $db->getUsername((int)$members[$i]), $splitAmount, $db->getBillDate($parent));
    }
    header('Location: ../bills.php');
    exit();
} 
elseif (isset($_POST['name']) && isset($_POST['amount']) && isset($_POST['group'])){
    checkParams(array('name', 'amount', 'group'));
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