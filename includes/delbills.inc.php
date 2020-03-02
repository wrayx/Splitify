<?php
include 'inc.php';
session_start();
$userInfo = $_SESSION['userInfo'];

function checkParams($parameters)
{
    foreach ($parameters as $parameter) {
        // some field is empty
        if (empty($_POST[$parameter])) {
            header("Location: ../bills.php?error=param-missing");
            exit();
        }
    }
}

if (isset($_POST['billID'])) {
    checkParams(array('billID'));
    $id = $_POST['billID'];
    $db->deleteBill((int) $id);
    header("Location: ../bills.php?deletebill=success");
    exit();
}
if (isset($_POST['splitBillID'])) {
    checkParams(array('splitBillID'));
    $id = $_POST['splitBillID'];
    // var_dump((int) $id);
    header("Location: ../bills.php?confirmbill=success");
    $db->paySplitBill((int) $id);
    exit();
}

header("Location: ../bills.php");
exit();