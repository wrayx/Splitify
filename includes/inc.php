<?php
require_once('../db/db.php');
$db = new DB('../db/splitify.db');
date_default_timezone_set('Europe/London');
function h($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
}