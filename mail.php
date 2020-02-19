<?php

$to      = 'yyeween@gmail.com';
$subject = 'Splitify Notification';
$message = 'Payment needed to for xxx';
$headers = 'From: noreply@splitify.com' . "\r\n" .
            'Reply-To: reply@splitify.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);

?>