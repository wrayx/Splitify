<?php
require_once('db/db.php');
$db = new DB('db/splitify.db');
function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}

function modalId($type, $function, $id)
{
    if ($function === "") {
        return $type . "-modal-" . $id;
    } else {
        return $type . "-modal-" . $function . "-" . $id;
    }
}

function checkSignIn()
{
    if (!isset($_SESSION["signedInToxxx.com"]) || !isset($_SESSION["userInfo"])) {
        header("Location: signin.php?error=permdenied");
    }
}

function checkSignOut()
{
    if (isset($_SESSION["signedInToxxx.com"]) && isset($_SESSION["userInfo"])) {
        header("Location: index.php");
    }
}