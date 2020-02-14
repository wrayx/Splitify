<?php
require_once "inc.php";
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$userInfo = $_SESSION["userInfo"];
$userid = $db->getUserId($userInfo);
$filename = basename($_SERVER['PHP_SELF'], ".php");
if ($filename == "index")
    $title = "Home";
else if ($filename == "bills")
    $title = "Billing";
else if ($filename == "groups")
    $title = "Group";
else if ($filename == "signin")
    $title = "Sign In";
else if ($filename == "signup")
    $title = "Sign up";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splitify - <?php echo $title; ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<header>
  <a href="index.php" class="logo">Splitify</a>
  <nav class="site-nav">
    <ul class="underline-menu">
        <li class="<?php if ($filename == "index") echo "active" ?>"><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true){ ?>
        <li class="<?php if ($filename == "bills") echo "active" ?>"><a href="bills.php">Bills</a></li>
        <li class="<?php if ($filename == "groups") echo "active" ?>"><a href="groups.php">Groups</a></li>
        <li><a href="includes/signout.inc.php">Sign Out</a></li>
        <?php } else{ ?>
        <li class="<?php if ($filename == "signin") echo "active" ?>"><a href="signin.php">Sign In</a></li>
        <li class="<?php if ($filename == "signup") echo "active" ?>"><a href="signup.php">Sign up</a></li>
        <?php } ?>
    </ul>
  </nav>
</header>