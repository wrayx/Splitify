<?php

$to = 'yyeween@gmail.com';
$subject = 'Splitify Notification';
$message = '
<h1>Payment Notification</h1>
<p><strong>Payee: </strong>xxx</p>
<p><strong>Amount: </strong>$19.00</p>
<p><strong>Date Added: </strong>12/08/2020</p>
<a href="#">Complete Payment</a>';

$headers = 'From: noreply@splitify.com' . "\r\n" .
    'Reply-To: reply@splitify.com' . "\r\n" .
    'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>