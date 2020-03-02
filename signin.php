<?php
include "header.php";
?>
<div class="landing-form">
    <form action="includes/signin.inc.php" method="POST">
        <div class="group">
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="group first-group">
            <input type="text" name="usernameOrEmail" aria-label="username or email" id="usernameOrEmail" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label for="usernameOrEmail">Username or E-mail</label>
        </div>
        <div class="group">
            <input type="password" name="pwd" id="pwd" aria-label="password" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label for="pwd">Password</label>
        </div>
        <div class="group">
            <button class="button fill" name="signin-submit" aria-label="sign in" type="submit">
                <span class="text">Sign In</span>
            </button>
            <a href="pwdrecover.php">Forget Password ?</a>
        </div>
    </form>
</div>
<?php
include "footer.php"
?>