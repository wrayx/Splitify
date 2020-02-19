<?php
include "header.php";
?>
    <div class="container">
        <h1 class="landing-title"><?php echo $title; ?></h1>
        <form action="includes/pwdreset.inc.php" method="POST">
            <input type="hidden" name="selector" value="<?php echo $_GET['selector']; ?>">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="group first-group">
                <input type="password" id="pwd" name="pwd" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="pwd">New Password</label>
            </div>
            <div class="group first-group">
                <input type="password" id="re-pwd" name="re-pwd" required>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="re-pwd">Repeat Password</label>
            </div>
            <div class="group">
                <button class="button fill" name="pwd-submit" type="submit">
                    <span class="text">Confirm</span>
                </button>
            </div>
        </form>
    </div>
<?php
include "footer.php";
?>