<?php
function alertMessage($type, $messsage){
    if ($type == 0) {
        echo "<div class=\"alert\">";
    }
    else if ($type == 1) {
        echo "<div class=\"alert info\">";
    }
    echo "<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">
          <i class=\"fas fa-times\"></i>
          </span>".$messsage."</div>";
}
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'param-missing'){
        alertMessage(0, 'Please complete all fields.');
    }
    elseif ($_GET['error'] === 'paramsnotvalid'){
        alertMessage(0, 'E-mail and username are not valid.');
    }
    elseif ($_GET['error'] === 'email-not-valid'){
        alertMessage(0, 'E-mail address is not valid.');
    }
    elseif ($_GET['error'] === 'username-not-valid'){
        alertMessage(0, 'Username is not valid (only alphabetical and numerical characters are allowed).');
    }
    elseif($_GET['error'] === 'pwddiff'){
        alertMessage(0, 'Password entered did not match with repeated password.');
    }
    elseif($_GET['error'] === 'usernotexist'){
        alertMessage(0, 'User does not exist on our system.');
    }
}
elseif (isset($_GET['signup']) && $_GET['signup'] === 'success'){
    alertMessage(1, 'Sign up successful. You can sign in now.');
}
elseif (isset($_GET['signin'])){
    if ($_GET['signin'] === 'failed'){
        alertMessage(0, 'Authentication failed, please try again.');
    }
    elseif ($_GET['signin'] === 'success'){
        alertMessage(1, 'Sign in successful.');
    }
}
elseif (isset($_GET['pwdchange'])){
    if ($_GET['pwdchange'] === 'success'){
        alertMessage(1, 'The password has been changed, You can now sign in with the new password.');
    }
    elseif ($_GET['pwdchange'] === 'failed'){
        alertMessage(0, 'Password change faild, please try again');
    }
}
elseif(isset($_GET['email']) && $_GET['email'] === 'sent'){
    alertMessage(1, 'Email has been sent, please check your mail box for instructions.');
}

?>