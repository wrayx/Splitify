<?php
if (isset($_POST['pwd-submit'])){
    $pwd = $_POST['pwd'];
    $rePwd = $_POST['re-pwd'];
    $selector = $_POST['selector'];
    $token = $_POST['token'];
    echo'$pwd = '.$pwd;
    echo '$selector= '.$selector;
}