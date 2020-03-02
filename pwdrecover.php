<?php
include "header.php";
?>

<div class="landing-form">
    <form action="includes/pwdrecover.inc.php" method="POST">
        <div class="group">
            <h1><?php echo $title; ?></h1>
        </div>
        <div class="group first-group">
            <input type="text" name="email" aria-label="email" required>
            <span class="highlight"></span>
            <span class="bar"></span>
            <label>E-mail</label>
        </div>
        <div class="group">
            We will send you an email to help you recover password.<br>
            Please follow the instructions in the Email.
        </div>
        <div class="group">
            <button class="button fill" name="pwd-submit" aria-label="confirm" type="submit">
                <span class="text">Confirm</span>
            </button>
        </div>
    </form>
</div>
<?php
include "footer.php";
?>