<?php
include "header.php";
if (isset($_SESSION["signedInToxxx.com"]) && $_SESSION["signedInToxxx.com"] == true) {
    ?>
<div class="index-info">
    <span class="info">User </span><?php echo $db->getUsername($userid); ?><br>
    <span class="info">Email </span><?php echo $db->getUserEmail($userid); ?><br>
    <!-- <span class="info">TO Pay </span><?php echo 888; ?><br> -->
    <span class="info">Overview</span>
</div>
<?php $payeeBills = $db->getUserBills($userid);
    foreach ($payeeBills as $payeeBill):
        $billName = $db->getBillName($payeeBill); ?>
<div class="pending-bills">
    <div class="bill-name"><?php echo $billName; ?><a href="bills.php#bill-cell-<?php echo $payeeBill; ?>"><i
                class="fas fa-expand-arrows-alt"></i></a>
    </div>
    <div class="progress progress-moved">
        <div class="progress-bar"
            id="progress-<?php echo $db->getBillPercentage($payeeBill); ?>-<?php echo $payeeBill; ?>">
            <?php if ($db->getBillPercentage($payeeBill) != 0): ?>
            <span class="progress-percentage"><?php echo $db->getBillPercentage($payeeBill); ?>%</span>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- unpaid bills table -->
<?php 
$userBills = $db->getUserSplitBills($userid);
if (count($userBills) != 0):
?>
<table class="index-table">
    <thead>
        <tr>
            <th>Bill</th>
            <th>Payee</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $type = "pay";
        foreach ($userBills as $userBill):
            $splitBillName = $db->getBillName($db->getSplitBillParent($userBill));
            $splitBillAmount = number_format($db->getSplitBillAmount($userBill), 2, '.', '');
            $splitBillPayee = $db->getUsername($db->getBillPayee($db->getSplitBillParent($userBill))); ?>
        <tr class="splitbill-row" id="splitbill-row-<?php echo $userBill; ?>">
            <td><?php echo $splitBillName; ?></td>
            <td><?php echo $splitBillPayee; ?></td>
            <td><?php
                    $date = str_replace('/', '-', $db->getBillDate($db->getSplitBillParent($userBill)));
                    echo date("d/m/Y", strtotime($date)); ?></td>
            <td>$<?php echo $splitBillAmount; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php elseif (count($payeeBills) == 0 && count($userBills) == 0): ?>
<div class="no-info">No Information Available</div>
<?php endif; ?>
<script src="js/index.js"></script>
<?php } else { ?>
<h1 class="index-title">Sign up today to split bills easily with your mates. </h1>
<a class="btn-draw" href="signup.php"><span>Sign up</span></a>
<a class="btn-draw" href="signin.php"><span>Sign In</span></a>
<?php } ?>
<?php
include "footer.php";
?>