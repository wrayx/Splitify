<?php
include "header.php";
?>
    <div class="container">
        <h1 class="landing-title"><?php echo $title; ?></h1>
        <form action="includes/signin.inc.php" method="POST">
            <div class="group first-group">
                <input type="text" name="usernameOrEmail" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Username or E-mail</label>
            </div>
            <div class="group">
                <input type="password" name="pwd" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
            <div class="group">
                <button class="button fill" name="signin-submit" type="submit">
                    <span class="text">Sign In</span>
                </button>
            </div>
        </form>
    </div>
<?php
include "footer.php"
?>