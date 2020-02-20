<?php
include "header.php";
?>
    <h1 class="landing-title"><?php echo $title; ?></h1>
    <form action="includes/pwdrecover.inc.php" method="POST">
        <div class="group first-group">
            <input type="text" name="email" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>E-mail</label>
        </div>
        <div class="group">
            We will send you an email to help you recover password.<br>
            Please follow the instructions in the Email.
        </div>
        <div class="group">
            <button class="button fill" name="pwd-submit" type="submit">
                <span class="text">Confirm</span>
            </button>
        </div>
    </form>
<?php
include "footer.php";
?>