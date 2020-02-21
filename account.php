<?php
include "header.php";
?>
<div class="index-info">
    <span class="info">User </span><?php echo $db->getUsername($userid); ?><br>
    <span class="info">Email </span><?php echo $db->getUserEmail($userid); ?><br>
</div>
<div class="group first-group account-group">
    <h1>Change Account Details</h1>
</div>
<form action="includes/account.inc.php" method="POST">
    <div class="group account-group">
        <input type="text" name="username" value="<?php echo $db->getUsername($userid); ?>">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Username</label>
    </div>
    <div class="group account-group">
        <input type="text" name="email" value="<?php echo $db->getUserEmail($userid); ?>">
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>E-mail</label>
    </div>
    <button class="btn-draw" type="submit" name="info-submit"><span>Confirm</span></button>
</form>
<div class="group first-group account-group">
    <h1>Change Password</h1>
</div>
<form action="includes/pwdreset.inc.php" method="POST">
    <div class="group account-group">
        <input type="password" name="old-pwd" required>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Old Password</label>
    </div>
    <div class="group account-group">
        <input type="text" name="pwd" required>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>New Password</label>
    </div>
    <div class="group account-group">
        <input type="password" name="re-pwd" required>
        <span class="highlight"></span>
        <span class="bar"></span>
        <label>Repeat Password</label>
    </div>
    <button class="btn-draw" type="submit" name="account-pwd-submit"><span>Confirm</span></button>
</form>
<?php
include "footer.php"
?>