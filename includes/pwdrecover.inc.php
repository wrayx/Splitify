<?php
require_once('inc.php');
// require('../random_compact/lib/random.php');

if (isset($_POST['pwd-submit'])) {
    $selector = bin2hex(mt_rand(8));
    $token = mt_rand(32);

    $url = "http://cs139.dcs.warwick.ac.uk/~u1915472/cs139/cs139_coursework/pwdreset.php?selector=".$selector."&token=".bin2hex($token)."";
    //  . http_build_query([
    //             'selector' => $selector, 
    //             'validator' => bin2hex($token)
    //         ]);
    $expires = date("U") + 1800;

   echo $url;
   echo $selector;

    $email = h($_POST['email']);
    // echo $email;

    if ($db->getUserId($email) === null) {
        header('Location: ../index.php?error=usernotexist');
        exit;
    }
    $db->saveResetToken($email, $selector, $token, $expires);

    $to = $email;
    $subject = 'Splitify Reset Password';
    $message = '<h1>Splitify: Reset Password</h1>
       <p>Please click the link down below to reset you password: </p>
       <p>' . $url . '</p>
       <p>The link will be expired in few minutes.</p><br><br>
       <p>Splitify</p>';

    $headers = 'From: noreply@splitify.com' . "\r\n" .
        'Reply-To: reply@splitify.com' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    header("Location: ../index.php?email=sent");
} else {
    header('Location: ../index.php?error=nosubmit');
}