<?php
include "header.php";
?>
<div class="landing-form">
    <form action="includes/signup.inc.php" method="POST">
        <div class="group">
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="group first-group">
            <input type="text" aria-label="username" required
                value="<?php if (isset($_GET['username'])) echo $_GET['username']; ?>" name="username">
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Username</label>
        </div>
        <div class="group">
            <input type="text" aria-label="email"
                value="<?php if (isset($_GET['useremail'])) echo $_GET['useremail']; ?>" name="email" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>E-mail</label>
        </div>
        <div class="group">
            <input type="password" required name="pwd" aria-label="password">
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Password</label>
        </div>
        <div class="group">
            <input type="password" aria-label="repeat password" required name="re-pwd">
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>Repeat Password</label>
        </div>
        <div class="group">
            <button class="button fill" name="signup-submit" type="submit">
                <span class="text">Sign up</span>
            </button>
        </div>
    </form>
</div>
<?php
include "footer.php"
?>