<?php
require_once('../db/db.php');
$db = new DB('../db/splitify.db');
function h ($string){
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}
