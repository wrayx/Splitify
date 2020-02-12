<?php
include "header.php";
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
?>
<div class="container">
    <h1 class="index-title">Pending Bills</h1>
    <div class="pending-bills">
        <div class="bill-name">Bill Name<a href="bills.php"><i class="fas fa-expand-arrows-alt"></i></a></div>
        <div class="progress progress-moved">
            <div class="progress-bar" >
            </div>
        </div>
    </div>

    <div class="pending-bills">
        <div class="bill-name">Bill another name<a href="bills.php"><i class="fas fa-expand-arrows-alt"></i></a></div>
        <div class="progress progress-moved">
            <div class="progress-bar" >
            </div>
        </div>
    </div>

    <div class="pending-bills">
        <div class="bill-name">Bill Name 3<a href="bills.php"><i class="fas fa-expand-arrows-alt"></i></a></div>
        <div class="progress progress-moved">
            <div class="progress-bar" >
            </div>
        </div>
    </div>
</div>
<?php } else { ?>
    <div class="container">
        <h1 class="index-title">Sign up today to split bills easily with your mates. </h1>
        <a class="btn-draw" href="signup.php"><span>Sign up</span></a>
        <a class="btn-draw" href="signin.php"><span>Sign In</span></a>
    </div>
<?php } ?>
<?php
include "footer.php";
?>